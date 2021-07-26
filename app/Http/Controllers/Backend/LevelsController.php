<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LevelsRequest;
use App\Models\Category;
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

        $data = Levels::paginate(10);
        //dd($data);
        return view('admin.level.index', [
            'data' => $data,
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
