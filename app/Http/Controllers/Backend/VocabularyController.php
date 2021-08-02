<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyRequest;
use App\Models\Vocabulary;
use App\Repositories\VocabularyRepository;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    private $vocabularyRepository;

    public function __construct(VocabularyRepository $repository)
    {
        $this->vocabularyRepository = $repository;
    }

    public function index()
    {
        $data = Vocabulary::orderBy('id', 'DESC')->paginate(10);
        return view('admin.vocabulary.index', [
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $question = Vocabulary::query();
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

        return view('admin.vocabulary.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin.vocabulary.create');
    }

    public function store(VocabularyRequest $request)
    {
        $data = $request->except('_token', 'files');
        if ($request->hasFile('thumb')) {
            $path = $request->file('thumb')->store('thumbnails', 'public');
            $data['thumb'] = $path;
        }
        $this->vocabularyRepository->storeNew($data);
        return redirect()->route('admin.vocabulary.index')->with('success', 'Thêm mới thành công');
    }

    public function edit($id)
    {
        $data = $this->vocabularyRepository->findById($id, []);
        return view('admin.vocabulary.update', [
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
        $this->vocabularyRepository->update($request->id, $data);
        return redirect()->route('admin.vocabulary.index');
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->vocabularyRepository->deleteById($id);
        return redirect()->route('admin.vocabulary.index');
    }
}
