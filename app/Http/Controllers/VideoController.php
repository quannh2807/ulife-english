<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
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
        $videos = $this->videoRepository->fetchAll(['hasCategory']);

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

    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->videoRepository->deleteById($id);

        return redirect()->route('admin.video.index');
    }
}
