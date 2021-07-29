<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = Category::with('hasParentCate')->paginate(10);

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

    /**
     * @param Request $request
     */
    public function saveCreate(CategoryRequest $request)
    {
        $data = $request->all();

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
