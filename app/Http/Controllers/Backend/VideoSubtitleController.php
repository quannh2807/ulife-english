<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadSubRequest;
use App\Models\VideoSubtitle;
use App\Repositories\LanguageRepository;
use App\Repositories\VideoRepository;
use App\Repositories\VideoSubtitleRepository;
use Benlipp\SrtParser\Parser;
use Illuminate\Http\Request;

class VideoSubtitleController extends Controller
{
    private $videoRepository;
    private $videoSubtitleRepository;
    private $languageRepository;

    public function __construct(
        VideoRepository         $videoRepository,
        VideoSubtitleRepository $videoSubtitleRepository,
        LanguageRepository      $languageRepository
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
        $subtitles = VideoSubtitle::with('hasLanguage')->where('video_id', $video_id)->get();

        return view('admin.subtitles.index', [
            'video' => $video,
            'subtitles' => $subtitles,
        ]);
    }

    public function store(Request $request)
    {
        $allData = $request->all();
        $this->videoSubtitleRepository->storeNew($allData);
        $newData = $this->videoSubtitleRepository->fetchAll([]);

        return response()->json([
            'msg' => 'Thêm mới thành công!',
            'newItem' => $newData[count($newData) - 1],
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

    public function destroy($id)
    {
        //
    }

    public function import()
    {
        $videos = $this->videoRepository->fetchAll([], ['id', 'title']);

        return view('admin.videos.import', [
            'videos' => $videos,
        ]);
    }

    public function preview(UploadSubRequest $request)
    {
        $parser = new Parser();
        $file = $request->file('file_upload');
        $parser->loadFile($file->path());
        $subtitles = $parser->parse();

        return response()->json([
            'subtitles' => $subtitles,
        ]);
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
            $this->videoSubtitleRepository->storeNew([
                'video_id' => $video_id,
                'time_start' => $sub->startTime,
                'time_end' => $sub->endTime,
                $lang => $sub->text,
            ]);
        }

        return redirect()->route('admin.video.index');
    }
}
