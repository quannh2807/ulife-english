<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\VocabularyCatRequest;
use App\Http\Requests\VocabularyCatRequestUpdate;
use App\Models\VocabularyCat;
use App\Repositories\VocabularyCatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocabularyCatController extends Controller
{
    private $vocabularyCatRepository;

    public function __construct(VocabularyCatRepository $repository)
    {
        $this->vocabularyCatRepository = $repository;
    }

    public function index()
    {
        $data = VocabularyCat::orderBy('id', 'DESC')->paginate(PAGE_SIZE);
        return view('admin.vocabularyCat.index', [
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $mSearch = VocabularyCat::query();
        if (!empty(request('keyword'))) {
            $mSearch->where('name', 'LIKE', '%' . request('keyword') . '%');
            $mSearch->orWhere('id', request('keyword'));
        }
        if (!empty(request('rangeDate'))) {
            $temp = explode('-', request('rangeDate'));
            $startDate = trim($temp[0]);
            $endDate = trim($temp[1]);
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)
                ->format('Y-m-d 00:00:00');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)
                ->format('Y-m-d 23:59:59');

            $mSearch->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate);
        }
        if (request('status') >= 0) {
            $mSearch->where('status', request('status'));
        }
        $data = $mSearch->orderBy('id', 'DESC')->paginate(10);

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
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        if ($request->hasFile('thumb')) {
            if (!isUrl($request->thumb)) {
                $path = $request->file('thumb')->store('thumbnails', 'public');
                $data['thumb'] = $path;
            }
        }
        $isSave = $this->vocabularyCatRepository->storeNew($data);
        return redirect()->route('admin.vocabularyCat.index')->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
    }

    public function edit($id)
    {
        $data = $this->vocabularyCatRepository->findById($id, []);
        return view('admin.vocabularyCat.update', [
            'data' => $data
        ]);
    }

    public function update(VocabularyCatRequestUpdate $request)
    {
        $request->request->remove('inlineRadioUpload');
        $detail = VocabularyCat::find($request->id);
        $data = $request->except('_token', 'files');
        $data['updated_by'] = Auth::user()->id;

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
        $isSave = $this->vocabularyCatRepository->update($request->id, $data);
        return redirect()->route('admin.vocabularyCat.index')->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $this->vocabularyCatRepository->deleteById($id);
        return redirect()->route('admin.vocabularyCat.index');
    }

    public function detail()
    {
        $questionId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        $detail = VocabularyCat::findOrFail($questionId);

        $response = '<table class="table table-bordered table-hover"><tbody>';
        if ($detail) {
            $response .= '<tr><td style="width: 120px;">Tên</td><td>' . $detail->name . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Ảnh</td><td><img src="' . thumbImagePath($detail->thumb) . '" width="100px" height="80px"></td></tr>';
            $response .= '<tr><td style="width: 120px;">Mô tả</td><td>' . $detail->description . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Trạng thái</td><td>' . htmlStatus($detail->status) . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Ngày tạo</td><td>' . $detail->created_at . '</td></tr>';
        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Không có dữ liệu.</td>';
            $response .= '</tr>';
        }
        $response .= '</tbody></table>';
        return $response;
    }
}
