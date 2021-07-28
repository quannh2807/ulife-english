<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Video;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    private $questionRepository;

    public function __construct(QuestionRepository $repository)
    {
        $this->questionRepository = $repository;
    }

    public function index()
    {
        $data = Question::paginate(10);
        return view('admin.question.index', [
            'data' => $data,
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
        $this->questionRepository->storeNew($data);
        return redirect()->route('admin.question.index')->with('success', 'Thêm mới thành công');
    }


    public function edit($id)
    {
        $detail = $this->questionRepository->findById($id, []);
        $levelData = DB::table('levels')->where('status', 1)->get();
        $topicsData = DB::table('topics')->where('status', 1)->get();

        return view('admin.question.update', [
            'detail' => $detail,
            'levelData' => $levelData,
            'topicsData' => $topicsData,
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $this->questionRepository->update($id, $data);
        return redirect()->route('admin.question.index');
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
        if (!empty($videos)) {
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

}
