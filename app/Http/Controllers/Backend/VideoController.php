<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Video;
use App\Repositories\CategoryRepository;
use App\Repositories\VideoRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    private $videoRepository;
    private $categoryRepository;

    public function __construct(VideoRepository $videoRepository, CategoryRepository $categoryRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $videos = Video::with('hasCategory')->paginate(10);

        return view('admin.videos.index', [
            'videos' => $videos,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->fetchAll(['hasChildrenCateRecursive', 'hasParentCate'], ['id', 'name', 'parent_id']);

        return view('admin.videos.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param Request $request
     */
    public function saveCreate(VideoRequest $request)
    {
        $data = $request->all();
        $this->videoRepository->storeNew($data);

        return redirect()->route('admin.video.index');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $categories = $this->categoryRepository->fetchAll(['hasChildrenCateRecursive', 'hasParentCate'], ['id', 'name', 'parent_id']);
        $current_video = $this->videoRepository->findById($id, []);
        $current_video->ytb_thumbnails = json_decode($current_video->ytb_thumbnails, true)['default'];

        return view('admin.videos.update', [
            'categories' => $categories,
            'video' => $current_video,
        ]);
    }

    /**
     * @param Request $request
     */
    public function saveUpdate(Request $request)
    {
        $video = $request->except('_token');
        if ($request->hasFile('custom_thumbnails')) {
            $path = $request->file('custom_thumbnails')->store('thumbnails', 'public');

            $video['custom_thumbnails'] = $path;
        }
        $this->videoRepository->update($video['id'], $video);

        return redirect()->route('admin.video.index');
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->videoRepository->deleteById($id);

        return redirect()->route('admin.video.index');
    }
}
