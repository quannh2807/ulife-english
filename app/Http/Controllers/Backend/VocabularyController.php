<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyRequest;
use App\Models\Vocabulary;
use App\Models\VocabularyCat;
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
        $category = VocabularyCat::where('status', 1)->get();
        return view('admin.vocabulary.create', [
            'category' => $category
        ]);
    }

    public function store(VocabularyRequest $request)
    {
        $data = $request->except('_token', 'files');
        if ($request->hasFile('thumb')) {
            $path = $request->file('thumb')->store('thumbnails', 'public');
            $data['thumb'] = $path;
        }
        $is_store = $this->vocabularyRepository->storeNew($data);
        if ($is_store) {
            return redirect()->route('admin.vocabulary.index')->with('success', 'Thêm mới thành công');
        } else {
            return redirect()->route('admin.vocabulary.index')->with('error', 'Thêm mới không thành công, vui lòng thử lại.');
        }
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

    public function update(Request $request)
    {
        $detail = Vocabulary::find($request->id);
        $data = $request->except('_token', 'files');
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
        $is_update = $this->vocabularyRepository->update($request->id, $data);
        if ($is_update) {
            return redirect()->route('admin.vocabulary.index')->with('success', 'Cập nhật thành công.');
        } else {
            return redirect()->route('admin.vocabulary.index')->with('error', 'Cập nhật không thành công, vui lòng thử lại.');
        }
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
            $response .= '<tr><td style="width: 120px;">Tên</td><td>' . $detail->name . '</td></tr>';
            $response .= '<tr><td>Phiên âm</td><td>' . $detail->spelling . '</td></tr>';
            $response .= '<tr><td>Ảnh</td><td><img src="' . thumbImagePath($detail->thumb) . '" width="100px" height="80px"></td></tr>';
            $response .= '<tr><td>Mô tả</td><td>' . $detail->description . '</td></tr>';
            $response .= '<tr><td>Danh mục</td><td><label id="status" class="levels">' . $detail->category->name . '</label></td></tr>';
            $response .= '<tr><td>Trạng thái</td><td>' . htmlStatus($detail->status) . '</td></tr>';
            $response .= '<tr><td>Ngày tạo</td><td>' . $detail->created_at . '</td></tr>';
        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Không có dữ liệu.</td>';
            $response .= '</tr>';
        }
        $response .= '</tbody></table>';
        return $response;
    }
}
