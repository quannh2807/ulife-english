<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicsRequest;
use App\Models\Topics;
use App\Repositories\TopicsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicsController extends Controller
{

    private $topicsRepository;

    public function __construct(TopicsRepository $repository)
    {
        $this->topicsRepository = $repository;
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
        $levelData = DB::table('levels')->where('status', 1)->get();
        return view('admin.topics.create', [
            'levelData' => $levelData,
        ]);
    }

    public function store(TopicsRequest $request)
    {
        $data = $request->all();
        $this->topicsRepository->storeNew($data);
        return redirect()->route('admin.topics.index')->with('success', 'Thêm mới Topics thành công');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $data = $this->topicsRepository->findById($id, []);
        $levelData = DB::table('levels')->where('status', 1)->get();
        return view('admin.topics.update', [
            'data' => $data,
            'levelData' => $levelData
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $this->topicsRepository->update($id, $data);
        return redirect()->route('admin.topics.index');
    }


    public function remove(Request $request)
    {
        $id = $request->id;
        $this->topicsRepository->deleteById($id);
        return redirect()->route('admin.topics.index');
    }

    public function destroy($id)
    {
    }
}
