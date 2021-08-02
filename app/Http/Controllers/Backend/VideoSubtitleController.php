<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\VideoSubtitle;
use App\Repositories\LanguageRepository;
use App\Repositories\VideoRepository;
use App\Repositories\VideoSubtitleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->sub_id;
        $selectedSub = $this->videoSubtitleRepository->findById($id, []);

        return response()->json([
            'selectedSub' => $selectedSub,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
