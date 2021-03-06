<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyRequest;
use App\Http\Requests\VocabularyRequestUpdate;
use App\Models\Vocabulary;
use App\Models\VocabularyCat;
use App\Repositories\VocabularyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    private $vocabularyRepository;

    public function __construct(VocabularyRepository $repository)
    {
        $this->vocabularyRepository = $repository;
    }

    public function index()
    {
        $category = VocabularyCat::where('status', 1)->get();
        $data = Vocabulary::orderBy('id', 'DESC')->paginate(PAGE_SIZE);
        return view('admin.vocabulary.index', [
            'data' => $data,
            'category' => $category,
        ]);
    }

    public function search(Request $request)
    {
        $category = VocabularyCat::where('status', 1)->get();
        $mQuery = Vocabulary::query();
        if (!empty(request('keyword'))) {
            $mQuery->where('name', 'LIKE', '%' . request('keyword') . '%');
            $mQuery->orWhere('id', request('keyword'));
        }
        if (!empty(request('rangeDate'))) {
            $temp = explode('-', request('rangeDate'));
            $startDate = trim($temp[0]);
            $endDate = trim($temp[1]);
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)
                ->format('Y-m-d 00:00:00');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)
                ->format('Y-m-d 23:59:59');

            $mQuery->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate);
        }
        if (request('category') >= 0) {
            $mQuery->where('cat_id', request('category'));
        }
        if (request('status') >= 0) {
            $mQuery->where('status', request('status'));
        }
        $data = $mQuery->orderBy('id', 'DESC')->paginate(10);

        return view('admin.vocabulary.index', [
            'data' => $data,
            'category' => $category,
        ]);
    }

    public function create()
    {
        $category = VocabularyCat::where('status', 1)->get();
        return view('admin.vocabulary.create', [
            'category' => $category
        ]);
    }

    public function store(VocabularyRequest $request)
    {
        $data = $request->except('_token', 'files');
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        if ($request->hasFile('thumb')) {
            if (!isUrl($request->thumb)) {
                $path = $request->file('thumb')->store('thumbnails', 'public');
                $data['thumb'] = $path;
            }
        }
        $isSave = $this->vocabularyRepository->storeNew($data);
        return redirect()->route('admin.vocabulary.index')->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
    }

    public function edit($id)
    {
        $category = VocabularyCat::where('status', 1)->get();
        $data = $this->vocabularyRepository->findById($id, []);
        return view('admin.vocabulary.update', [
            'data' => $data,
            'category' => $category
        ]);
    }

    public function update(VocabularyRequestUpdate $request)
    {
        $detail = Vocabulary::find($request->id);
        $data = $request->except('_token', 'files');
        $data['updated_by'] = Auth::user()->id;

        if ($request->hasFile('thumb')) {
            $path = $request->file('thumb')->store('thumbnails', 'public');
            $data['thumb'] = $path;
            // remove old image
            if (!empty($detail->thumb)) {
                if (file_exists('storage/' . $detail->thumb)) {
                    unlink('storage/' . $detail->thumb);
                };
            }
        }
        $isSave = $this->vocabularyRepository->update($request->id, $data);
        return redirect()->route('admin.vocabulary.index')->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->vocabularyRepository->deleteById($id);
        return redirect()->route('admin.vocabulary.index');
    }

    public function detail()
    {
        $questionId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        $detail = Vocabulary::findOrFail($questionId);

        $response = '<table class="table table-bordered table-hover"><tbody>';
        if ($detail) {
            $response .= '<tr><td style="width: 120px;">T??n</td><td>' . $detail->name . '</td></tr>';
            $response .= '<tr><td>Phi??n ??m</td><td>' . $detail->spelling . '</td></tr>';
            $response .= '<tr><td>???nh</td><td><img src="' . thumbImagePath($detail->thumb) . '" width="100px" height="80px"></td></tr>';
            $response .= '<tr><td>M?? t???</td><td>' . $detail->description . '</td></tr>';
            $response .= '<tr><td>Danh m???c</td><td><span class="badge badge-primary">' . $detail->category->name . '</span></td></tr>';
            $response .= '<tr><td>Tr???ng th??i</td><td>' . htmlStatus($detail->status) . '</td></tr>';
            $response .= '<tr><td>Ng??y t???o</td><td>' . $detail->created_at . '</td></tr>';
        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Kh??ng c?? d??? li???u.</td>';
            $response .= '</tr>';
        }
        $response .= '</tbody></table>';
        return $response;
    }

    public function categoryList($catId)
    {
        $category = VocabularyCat::findOrFail($catId);
        $data = Vocabulary::where('cat_id', $catId)->orderBy('id', 'DESC')->paginate(PAGE_SIZE);

        return view('admin.vocabulary.category_list', [
            'data' => $data,
            'catId' => $catId,
            'category' => $category,
        ]);
    }

    public function categoryCreate($catId)
    {
        $category = VocabularyCat::where('status', 1)->get();
        return view('admin.vocabulary.category_create', [
            'catId' => $catId,
            'category' => $category,
        ]);
    }

    public function categoryStore(VocabularyRequest $request)
    {
        $catId = $request->catId ? $request->catId : 0;
        $data = $request->except('_token', 'files');
        if ($request->hasFile('thumb')) {
            if (!isUrl($request->thumb)) {
                $path = $request->file('thumb')->store('thumbnails', 'public');
                $data['thumb'] = $path;
            }
        }
        $isSave = $this->vocabularyRepository->storeNew($data);
        return redirect()->route('admin.vocabulary.categoryList', ['catId' => $catId])->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
    }

    public function categoryEdit($catId, $id)
    {
        $category = VocabularyCat::where('status', 1)->get();
        $detail = $this->vocabularyRepository->findById($id, []);
        return view('admin.vocabulary.category_update', [
            'catId' => $catId,
            'data' => $detail,
            'category' => $category,
        ]);
    }

    public function categoryUpdate(VocabularyRequestUpdate $request, $catId)
    {
        $request->request->remove('inlineRadioUpload');
        $detail = Vocabulary::find($request->id);
        $data = $request->except('_token', 'files');
        if ($request->hasFile('thumb')) {
            // remove old image
            if (!empty($detail->thumb) && !isUrl($request->thumb)) {
                if (file_exists('storage/' . $detail->thumb)) {
                    unlink('storage/' . $detail->thumb);
                };
            }
            if (!isUrl($request->thumb)) {
                $path = $request->file('thumb')->store('thumbnails', 'public');
                $data['thumb'] = $path;
            }
        }
        $isSave = $this->vocabularyRepository->update($request->id, $data);
        return redirect()->route('admin.vocabulary.categoryList', ['catId' => $catId])->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }

    public function categorySearch(Request $request, $catId)
    {
        $category = VocabularyCat::where('status', 1)->get();
        $mQuery = Vocabulary::query();
        if (!empty(request('keyword'))) {
            $mQuery->where('name', 'LIKE', '%' . request('keyword') . '%');
            $mQuery->orWhere('id', request('keyword'));
        }
        if (!empty(request('rangeDate'))) {
            $temp = explode('-', request('rangeDate'));
            $startDate = trim($temp[0]);
            $endDate = trim($temp[1]);
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)
                ->format('Y-m-d 00:00:00');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)
                ->format('Y-m-d 23:59:59');

            $mQuery->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate);
        }
        $mQuery->where('cat_id', $catId);
        if (request('status') >= 0) {
            $mQuery->where('status', request('status'));
        }
        $data = $mQuery->orderBy('id', 'DESC')->paginate(10);

        return view('admin.vocabulary.category_list', [
            'data' => $data,
            'catId' => $catId,
            'category' => $category,
        ]);
    }
}
