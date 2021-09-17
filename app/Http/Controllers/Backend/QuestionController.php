<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Video;
use App\Models\VideoSubtitle;
use App\Repositories\QuestionRepository;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    private $questionRepository;
    private $videoRepository;

    public function __construct(QuestionRepository $repository, VideoRepository $videoRepository)
    {
        $this->questionRepository = $repository;
        $this->videoRepository = $videoRepository;
    }

    public function index()
    {
        $data = Question::orderBy('id', 'DESC')->paginate(PAGE_SIZE);
        $levelData = DB::table('levels')->where('status', 1)->get();
        $topicsData = DB::table('topics')->where('status', 1)->get();

        return view('admin.question.index', [
            'data' => $data,
            'levelData' => $levelData,
            'topicsData' => $topicsData,
        ]);
    }

    public function search(Request $request)
    {
        //$keyword = $request->get('keyword');
        DB::enableQueryLog();
        $question = Question::query();
        if (!empty(request('keyword'))) {
            $question->where('name', 'LIKE', '%' . request('keyword') . '%');
            $question->orWhere('id', request('keyword'));
        }
        if (!empty(request('rangeDate'))) {
            $temp = explode('-', request('rangeDate'));
            $startDate = trim($temp[0]);
            $endDate = trim($temp[1]);
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)
                ->format('Y-m-d 00:00:00');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)
                ->format('Y-m-d 23:59:59');

            $question->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate);
        }
        if (!empty(request('level'))) {
            $question->where('level_id', request('level'));
        }
        if (!empty(request('topics'))) {
            $question->where('topics_id', request('topics'));
        }
        if (request('status') >= 0) {
            $question->where('status', request('status'));
        }
        $data = $question->orderBy('id', 'DESC')->paginate(10);
        //$queryLog = DB::getQueryLog();
        //dd($queryLog);

        $levelData = DB::table('levels')->where('status', 1)->get();
        $topicsData = DB::table('topics')->where('status', 1)->get();

        return view('admin.question.index', [
            'data' => $data,
            'levelData' => $levelData,
            'topicsData' => $topicsData,
        ]);
    }

    public function create()
    {
        $levelData = DB::table('levels')->where('status', 1)->get();
        $topicsData = DB::table('topics')->where('status', 1)->get();

        return view('admin.question.create', [
            'levelData' => $levelData,
            'topicsData' => $topicsData,
        ]);
    }

    public function store(QuestionRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['time_start'] = stringHoursToFloat($request->input('time_start'));
        $data['time_end'] = stringHoursToFloat($request->input('time_end'));

        $isSave = $this->questionRepository->storeNew($data);
        return redirect()->route('admin.question.index')->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
    }

    public function edit($id)
    {
        $detail = $this->questionRepository->findById($id, []);
        $levelData = DB::table('levels')->where('status', 1)->get();
        $topicsData = DB::table('topics')->where('status', 1)->get();
        $videoId = 0;
        $ytbID = '';
        if ($detail->getVideo) {
            $videoId = $detail->getVideo->id;
            $ytbID = $detail->getVideo->ytb_id;
        }

        return view('admin.question.update', [
            'detail' => $detail,
            'videoId' => $videoId,
            'ytbID' => $ytbID,
            'levelData' => $levelData,
            'topicsData' => $topicsData,
        ]);
    }

    public function update(QuestionRequest $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $data['updated_by'] = Auth::user()->id;
        $data['time_start'] = stringHoursToFloat($request->input('time_start'));
        $data['time_end'] = stringHoursToFloat($request->input('time_end'));
        $isSave = $this->questionRepository->update($id, $data);
        return redirect()->route('admin.question.index')->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->questionRepository->deleteById($id);
        return redirect()->route('admin.question.index');
    }

    public function getVideos()
    {
        $videoId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        $keyName = isset($_GET["keyName"]) ? $_GET["keyName"] : '';

        //DB::enableQueryLog();
        $videos = null;
        if (!empty($keyName)) {
            $videos = Video::orderby('id', 'asc')->select('*')
                ->where('title', 'like', '%' . $keyName . '%')
                ->limit(100)->get();
        } else {
            $videos = Video::orderby('id', 'asc')->select('*')->limit(100)->get();
        }
        //$queryLog = DB::getQueryLog();
        //dd($queryLog);

        $response = '<table id="videoList" class="table table-hover">';
        if (!$videos->isEmpty()) {
            foreach ($videos as $item) {
                $thumbNews = !empty($item->ytb_thumbnails) ? json_decode($item->ytb_thumbnails, true)['default']['url'] : 'no-image.png';
                $checked = $videoId == $item->id ? 'checked' : '';
                $response .= $checked === 'checked' ? '<tr class="checked" >' : '<tr>';
                $response .= '<td id="id" style="width: auto;"><input id="check_video" value="' . $item->id . '" ' . $checked . ' type="checkbox"><input id="ytb_id" value="' . $item->ytb_id . '" hidden >';
                $response .= '</td>';
                $response .= '<td id="thumb" style="width: 80px;"><img id="imgThumb" class="thumbList" src="' . $thumbNews . '"/></td>';
                $response .= '<td id="title">' . $item->title . '</td>';
                $response .= '</tr>';
            }
        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Không có dữ liệu.</td>';
            $response .= '</tr>';
        }
        $response .= '</table>';
        return $response;
    }

    public function detail()
    {
        $questionId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        $detail = Question::findOrFail($questionId);

        $response = '<table id="videoList" class="table table-bordered table-hover"><tbody>';
        if ($detail) {
            $response .= '<tr><td style="width: 120px;">Tên câu hỏi</td><td>' . $detail->name . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Đáp án <span class="badge badge-question">1</span></td><td>' . $detail->answer_1 . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Đáp án <span class="badge badge-question">2</span></td><td>' . $detail->answer_2 . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Đáp án <span class="badge badge-question">3</span></td><td>' . $detail->answer_3 . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Đáp án <span class="badge badge-question">4</span></td><td>' . $detail->answer_4 . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Đáp án đúng</td><td><span class="badge badge-question badge-correct">' . $detail->answer_correct . '</span></td></tr>';
            $response .= '<tr><td style="width: 120px;">Subtitle time</td><td><span>' . $detail->start_time . '</span><span>&nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size: 12px;"></i>&nbsp;&nbsp;' . $detail->end_time . '</span></td></tr>';

            $levelName = !empty($detail->getLevel) ? '<label id="status" class="levels">' . $detail->getLevel->name . '</label>' : '<label id="status" class="no-levels">No Level</label>';
            $response .= '<tr><td style="width: 120px;">Level</td><td>' . $levelName . '</td></tr>';

            $topicsName = !empty($detail->getTopics) ? '<label id="status" class="levels">' . $detail->getTopics->name . '</label>' : '<label id="status" class="no-levels">No Topics</label>';
            $response .= '<tr><td style="width: 120px;">Topics</td><td>' . $topicsName . '</td></tr>';

            $response .= '<tr><td style="width: 120px;">Mức độ</td><td>' . $detail->level_type . '</td></tr>';

            $statusName = $detail->status == 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                : '<label id="status" class="active">Kích hoạt</label>';
            $response .= '<tr><td style="width: 120px;">Trạng thái</td><td>' . $statusName . '</td></tr>';

        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Không có dữ liệu.</td>';
            $response .= '</tr>';
        }
        $response .= '</tbody></table>';
        return $response;
    }

    public function createQuestionList($video_id)
    {
        $video = $this->videoRepository->findById($video_id, [], ['id', 'title', 'ytb_thumbnails']);
        $thumbnails = json_decode($video->ytb_thumbnails);
        $video->ytb_thumbnails = $thumbnails->default;
        $subtitles = VideoSubtitle::with('hasLanguage')->where('video_id', $video_id)->get();
        return view('admin.question.createQuestionList', [
            'video' => $video,
            'videoId' => $video_id,
            'subtitles' => $subtitles,
        ]);
    }

    public function storeQuestionList(Request $request, $videoId)
    {
        //dd($request->all());
        $name = $request->input('name', []);
        $nameOrigin = $request->input('name_origin', []);
        $timeStart = $request->input('time_start', []);
        $timeEnd = $request->input('time_end', []);
        $answer_1 = $request->input('answer_1', []);
        $answer_2 = $request->input('answer_2', []);
        $answer_3 = $request->input('answer_3', []);
        $answer_4 = $request->input('answer_4', []);
        $answer_correct = $request->input('answer_correct', []);

        $data = [];
        foreach ($name as $index => $value) {
            $data[] = [
                "name" => $name[$index],
                "name_origin" => $nameOrigin[$index],
                "time_start" => $timeStart[$index],
                'time_end' => $timeEnd[$index],
                'answer_1' => $answer_1[$index],
                'answer_2' => $answer_2[$index],
                'answer_3' => $answer_3[$index],
                'answer_4' => $answer_4[$index],
                'answer_correct' => $answer_correct[$index],
                'video_id' => $videoId,
                'type' => 1, // config common question_type, 0 - Question, 1- Question Subtitle
                'created_at' => \Carbon\Carbon::now(),
            ];
        }
        //dd($data);
        $isSave = Question::insert($data);
        //$isSave = DB::table('questions')->insert($data);
        return redirect()->route('admin.question.index')->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
    }


    public function editQuestionList($video_id)
    {
        $video = $this->videoRepository->findById($video_id, [], ['id', 'title', 'ytb_thumbnails']);
        $thumbnails = json_decode($video->ytb_thumbnails);
        $video->ytb_thumbnails = $thumbnails->default;
        $subtitles = Question::where('video_id', $video_id)->orderByRaw('CAST(time_start as DECIMAL) asc')->get();
        return view('admin.question.updateQuestionList', [
            'video' => $video,
            'videoId' => $video_id,
            'subtitles' => $subtitles,
        ]);
    }

    public function updateQuestionList(Request $request, $videoId)
    {
        $id = $request->input('id', []);
        $name = $request->input('name', []);
        $nameOrigin = $request->input('name_origin', []);
        $timeStart = $request->input('time_start', []);
        $timeEnd = $request->input('time_end', []);
        $answer_1 = $request->input('answer_1', []);
        $answer_2 = $request->input('answer_2', []);
        $answer_3 = $request->input('answer_3', []);
        $answer_4 = $request->input('answer_4', []);
        $answer_correct = $request->input('answer_correct', []);

        $isSave = false;
        //$dataList = [];
        DB::enableQueryLog();
        foreach ($name as $index => $value) {
            $data = [
                "name" => $name[$index],
                "time_start" => $timeStart[$index],
                "name_origin" => $nameOrigin[$index],
                'time_end' => $timeEnd[$index],
                'answer_1' => $answer_1[$index],
                'answer_2' => $answer_2[$index],
                'answer_3' => $answer_3[$index],
                'answer_4' => $answer_4[$index],
                'answer_correct' => $answer_correct[$index],
                'video_id' => $videoId,
                'type' => 1, // config common question_type, 0 - Question, 1- Question Subtitle
                'updated_at' => \Carbon\Carbon::now(),
            ];
            //$dataList[] = $data;
            $isSave = Question::where('id', $id[$index])->update($data);
        }
        //$queryLog = DB::getQueryLog();
        //dd($queryLog);
        //dd($dataList);
        return redirect()->route('admin.question.index')->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }

    public function removeQuestionList(Request $request)
    {
        $videoId = $request->id;
        $delete = Question::where('video_id', $videoId)->delete();
    }

}
