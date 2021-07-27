<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LevelsRequest;
use App\Models\Topics;
use App\Repositories\TopicsRepository;
use Illuminate\Http\Request;

class TopicsController extends Controller
{

    private $dataRepository;

    public function __construct(TopicsRepository $repository)
    {
        $this->dataRepository = $repository;
    }

    public function index()
    {

        $data = Topics::paginate(10);
        return view('admin.topics.index', [
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('admin.topics.create');
    }

    public function store(LevelsRequest $request)
    {
        $data = $request->all();
        $this->dataRepository->storeNew($data);
        return redirect()->route('admin.topics.index')->with('success', 'Thêm mới Topics thành công');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $data = $this->dataRepository->findById($id, []);
        return view('admin.topics.update', [
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $this->dataRepository->update($id, $data);
        return redirect()->route('admin.topics.index');
    }


    public function remove(Request $request)
    {
        $id = $request->id;
        $this->dataRepository->deleteById($id);
        return redirect()->route('admin.topics.index');
    }

    public function destroy($id)
    {
    }
}
