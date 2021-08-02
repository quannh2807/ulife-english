<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyCatRequest;
use App\Models\VocabularyCat;
use App\Repositories\VocabularyCatRepository;
use Illuminate\Http\Request;

class VocabularyCatController extends Controller
{
    private $vocabularyCatRepository;

    public function __construct(VocabularyCatRepository $repository)
    {
        $this->vocabularyCatRepository = $repository;
    }

    public function index()
    {
        $data = VocabularyCat::orderBy('id', 'DESC')->paginate(10);
        return view('admin.vocabularyCat.index', [
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $question = VocabularyCat::query();
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

        return view('admin.vocabularyCat.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin.vocabularyCat.create');
    }

    public function store(VocabularyCatRequest $request)
    {
        $data = $request->except('_token', 'files');
        if ($request->hasFile('thumb')) {
            $path = $request->file('thumb')->store('thumbnails', 'public');
            $data['thumb'] = $path;
        }
        $this->vocabularyCatRepository->storeNew($data);
        return redirect()->route('admin.vocabularyCat.index')->with('success', 'Thêm mới thành công');
    }

    public function edit($id)
    {
        $data = $this->vocabularyCatRepository->findById($id, []);
        return view('admin.vocabularyCat.update', [
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', 'files');
        if ($request->hasFile('thumb')) {
            $path = $request->file('thumb')->store('thumbnails', 'public');
            $data['thumb'] = $path;
        }
        $this->vocabularyCatRepository->update($request->id, $data);
        return redirect()->route('admin.vocabularyCat.index');
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->vocabularyCatRepository->deleteById($id);
        return redirect()->route('admin.vocabularyCat.index');
    }
}
