<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicsRequest;
use App\Models\Levels;
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
        $data = Topics::orderBy('id', 'DESC')->paginate(10);
        $levelData = DB::table('levels')->where('status', 1)->get();

        return view('admin.topics.index', [
            'data' => $data,
            'levelData' => $levelData,
        ]);
    }

    public function search(Request $request)
    {
        $question = Topics::query();
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
        if (!empty(request('level'))) {
            $question->where('level_id', request('level'));
        }
        if (request('status') >= 0) {
            $question->where('status', request('status'));
        }

        $data = $question->orderBy('id', 'DESC')->paginate(10);
        $levelData = DB::table('levels')->where('status', 1)->get();

        return view('admin.topics.index', [
            'data' => $data,
            'levelData' => $levelData,
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
