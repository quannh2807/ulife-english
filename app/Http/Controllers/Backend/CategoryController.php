<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Question;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = Category::with('hasParentCate')->orderBy('id', 'DESC')->paginate(PAGE_SIZE);

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->fetchAll(['hasChildrenCateRecursive', 'hasParentCate'], ['id', 'name', 'parent_id']);

        return view('admin.categories.create', [
            'categories' => $categories,
        ]);
    }

    public function search(Request $request)
    {
        $question = Category::query();
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
        if (request('status') >= 0) {
            $question->where('status', request('status'));
        }
        $data = $question->orderBy('id', 'DESC')->paginate(10);

        return view('admin.categories.index', [
            'categories' => $data,
        ]);
    }

    /**
     * @param Request $request
     */
    public function saveCreate(CategoryRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        $this->categoryRepository->storeNew($data);

        return redirect()->route('admin.category.index');
    }

    public function update(Request $request)
    {
        $categoryId = $request->id;
        $categories = $this->categoryRepository->fetchAll(['hasChildrenCateRecursive', 'hasParentCate'], ['id', 'name', 'parent_id']);
        $category = $this->categoryRepository->findById($categoryId, []);

        return view('admin.categories.update', [
            'categories' => $categories,
            'category' => $category,
        ]);
    }

    /**
     * @param Request $request
     */
    public function saveUpdate(Request $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $data['updated_by'] = Auth::user()->id;
        $this->categoryRepository->update($id, $data);

        return redirect()->route('admin.category.index');
    }

    public function remove(Request $request)
    {
        $categoryId = $request->id;
        $this->categoryRepository->deleteById($categoryId);

        return redirect()->route('admin.category.index');
    }
}
