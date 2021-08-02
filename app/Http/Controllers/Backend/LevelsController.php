<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LevelsRequest;
use App\Models\Game;
use App\Models\Levels;
use App\Repositories\LevelRepository;
use Illuminate\Http\Request;

class LevelsController extends Controller
{

    private $levelRepository;

    public function __construct(LevelRepository $repository)
    {
        $this->levelRepository = $repository;
    }

    public function index()
    {
        $data = Levels::orderBy('id', 'DESC')->paginate(10);
        return view('admin.level.index', [
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $question = Levels::query();
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

        return view('admin.level.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin.level.create');
    }

    public function store(LevelsRequest $request)
    {
        /*  $validatedData = $request->validate([
              'name' => 'required|max:255',
              'status' => 'required',
          ]);
          $show = Levels::create($validatedData);
          return redirect('admin.level.index')->with('success', 'Thêm mới level thành công');*/
        $data = $request->all();
        $this->levelRepository->storeNew($data);
        return redirect()->route('admin.level.index')->with('success', 'Thêm mới level thành công');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $data = $this->levelRepository->findById($id, []);
        return view('admin.level.update', [
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $this->levelRepository->update($id, $data);
        return redirect()->route('admin.level.index');
    }


    public function remove(Request $request)
    {
        $id = $request->id;
        $this->levelRepository->deleteById($id);
        return redirect()->route('admin.level.index');
    }

    public function destroy($id)
    {
    }
}
