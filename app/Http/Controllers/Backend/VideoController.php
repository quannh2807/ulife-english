<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Http\Requests\VideoRequestUpdate;
use App\Models\Topics;
use App\Models\Video;
use App\Repositories\CategoryRepository;
use App\Repositories\VideoRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $categories = $this->categoryRepository->fetchAll([], ['id', 'name']);
        $videos = Video::with('hasCategories')->orderBy('id', 'DESC')->paginate(10);

        return view('admin.videos.index', [
            'videos' => $videos,
            'categories' => $categories,
        ]);
    }

    public function search(Request $request)
    {
        $categories = $this->categoryRepository->fetchAll([], ['id', 'name']);
        $videos = Video::with('hasCategories')->where([
            ['title', 'like', '%' . $request->keyword . '%'],
            ['type', 'like', '%' . $request->type . '%'],
            ['status', 'like', '%' . $request->status . '%'],
        ])->paginate(10);

        return view('admin.videos.index', [
            'videos' => $videos,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->fetchAll(['hasChildrenCateRecursive', 'hasParentCate'], ['id', 'name', 'parent_id']);
        $topicData = Topics::where('status', 1)->orderBy('id', 'ASC')->get();

        return view('admin.videos.create', [
            'categories' => $categories,
            'topicData' => $topicData,
        ]);
    }

    /**
     * @param Request $request
     */
    public function saveCreate(VideoRequest $request)
    {
        $data = $request->except('categories');
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $categories = $request->categories;
        $saveVideo = $this->videoRepository->storeNew($data);
        // luu record quan he n-n vao bang video_category
        $saveVideo->hasCategories()->sync($categories);

        return redirect()->route('admin.video.index');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $topicData = Topics::where('status', 1)->orderBy('id', 'ASC')->get();
        $categories = $this->categoryRepository->fetchAll(['hasChildrenCateRecursive', 'hasParentCate'], ['id', 'name', 'parent_id']);
        $current_video = $this->videoRepository->findById($id, ['hasCategories']);
        //$current_video->ytb_thumbnails = json_decode($current_video->ytb_thumbnails, true)['default'];

        return view('admin.videos.update', [
            'categories' => $categories,
            'topicData' => $topicData,
            'video' => $current_video,
        ]);
    }

    /**
     * @param Request $request
     */
    public function saveUpdate(VideoRequestUpdate $request)
    {
        $request->request->remove('ytb_url');
        $currentVideo = $this->videoRepository->findById($request->id, []);
        // luu record quan he n-n vao bang video_category
        $categories = $request->categories;
        $currentVideo->hasCategories()->detach($categories);
        $currentVideo->hasCategories()->sync($categories);

        $video = $request->except('_token', 'categories');
        $video['created_by'] = Auth::user()->id;
        $video['updated_by'] = Auth::user()->id;
        if ($request->hasFile('custom_thumbnails')) {
            // remove old image
            if (!empty($video->custom_thumbnails)) {
                if (file_exists('storage/' . $video->custom_thumbnails)) {
                    unlink('storage/' . $video->custom_thumbnails);
                };
            }
            $path = $request->file('custom_thumbnails')->store('thumbnails', 'public');
            $video['custom_thumbnails'] = $path;
        }
        $updateVideo = $this->videoRepository->update($video['id'], $video);

        return redirect()->route('admin.video.index');
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->videoRepository->deleteById($id);

        return redirect()->route('admin.video.index');
    }
}
