<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadSubRequest;
use App\Models\VideoSubtitle;
use App\Repositories\LanguageRepository;
use App\Repositories\VideoRepository;
use App\Repositories\VideoSubtitleRepository;
use Benlipp\SrtParser\Parser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoSubtitleController extends Controller
{
    private $videoRepository;
    private $videoSubtitleRepository;
    private $languageRepository;

    public function __construct(
        VideoRepository $videoRepository,
        VideoSubtitleRepository $videoSubtitleRepository,
        LanguageRepository $languageRepository
    )
    {
        $this->videoRepository = $videoRepository;
        $this->videoSubtitleRepository = $videoSubtitleRepository;
        $this->languageRepository = $languageRepository;
    }

    public function index(Request $request)
    {
        $video_id = $request->video_id;
        $video = $this->videoRepository->findById($video_id, [], ['id', 'title', 'ytb_thumbnails']);
        $thumbnails = json_decode($video->ytb_thumbnails);
        $video->ytb_thumbnails = $thumbnails->default;
        $subtitles = VideoSubtitle::where('video_id', $video_id)->orderByRaw('CAST(time_start as DECIMAL) asc')->get();

        return view('admin.subtitles.index', [
            'video' => $video,
            'subtitles' => $subtitles,
        ]);
    }

    public function store(Request $request)
    {
        $allData = $request->all();
        $allData['time_start'] = stringHoursToFloat($request->time_start);
        $allData['time_end'] = stringHoursToFloat($request->time_end);

        $currentSub = VideoSubtitle::where('id', $request->sub_id)->first();

        if ($currentSub) {
            $this->videoSubtitleRepository->update($currentSub->id, $allData);
            $item = $this->videoSubtitleRepository->findById($currentSub->id, []);
        } else {
            $this->videoSubtitleRepository->storeNew($allData);
            $newData = $this->videoSubtitleRepository->fetchAll([]);
            $item = $newData[count($newData) - 1];
        }

        return response()->json([
            'item' => $item,
        ]);
    }

    public function show(Request $request)
    {
        $id = $request->sub_id;
        $selectedSub = $this->videoSubtitleRepository->findById($id, []);

        return response()->json([
            'selectedSub' => $selectedSub,
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $this->videoSubtitleRepository->deleteById($request->id);

        return response()->json([
            'msg' => 'Xóa thành công'
        ], 200);
    }

    public function destroyAll(Request $request)
    {
        $ids = $request->ids;
        VideoSubtitle::whereIn('id', explode(",", $ids))->delete();

        return response()->json([
            'msg' => 'Xóa thành công'
        ]);
    }

    public function import()
    {
        $videos = $this->videoRepository->fetchAll([], ['id', 'title']);

        return view('admin.videos.import', [
            'videos' => $videos,
        ]);
    }

    public function preview(Request $request)
    {
        $parser = new Parser();
        if ($request->hasFile('file_sub')) {
            $file = $request->file('file_sub');
            $parser->loadFile($file->path());
            $subtitles = $parser->parse();

            return response()->json([
                'subtitles' => $subtitles,
            ]);
        }
    }

    public function upload(UploadSubRequest $request)
    {
        $video_id = $request->video_id;
        $lang = $request->lang;
        $parser = new Parser();
        $file = $request->file('file_upload');
        $parser->loadFile($file->path());
        $subtitles = $parser->parse();

        foreach ($subtitles as $key => $sub) {
            $data = [
                'video_id' => $video_id,
                'time_start' => $sub->startTime,
                'time_end' => $sub->endTime,
                $lang => $sub->text,
            ];
            // check record existed
            $currentSub = VideoSubtitle::where([
                ['video_id', $video_id],
                ['time_start', $sub->startTime],
                ['time_end', $sub->endTime],
            ])->first();
            if ($currentSub) {
                $this->videoSubtitleRepository->update($currentSub->id, $data);
            } else {
                $this->videoSubtitleRepository->storeNew($data);
            }
        }

        return redirect()->route('admin.subtitle.index', [
            'video_id' => $video_id,
        ]);
    }

    public function refresh(Request $request)
    {
        $video_id = $request->video_id;
        $subtitles = $subtitles = VideoSubtitle::where('video_id', $video_id)->orderByRaw('CAST(time_start as DECIMAL) asc')->get();

        return response()->json([
            'subtitles' => $subtitles,
        ]);
    }
}
