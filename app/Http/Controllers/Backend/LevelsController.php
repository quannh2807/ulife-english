<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LevelsRequest;
use App\Models\Game;
use App\Models\Levels;
use App\Repositories\LevelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelsController extends Controller
{

    private $levelRepository;

    public function __construct(LevelRepository $repository)
    {
        $this->levelRepository = $repository;
    }

    public function index()
    {
        $data = Levels::orderBy('id', 'DESC')->paginate(PAGE_SIZE);
        return view('admin.level.index', [
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $mSearch = Levels::query();
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
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $isSave = $this->levelRepository->storeNew($data);
        return redirect()->route('admin.level.index')->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
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

    public function update(LevelsRequest $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $data['updated_by'] = Auth::user()->id;
        $isSave = $this->levelRepository->update($id, $data);
        return redirect()->route('admin.level.index')->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }


    public function remove(Request $request)
    {
        $id = $request->id;
        $this->levelRepository->deleteById($id);
        return redirect()->route('admin.level.index');
    }

    public function detail()
    {
        $questionId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        $detail = Levels::findOrFail($questionId);

        $response = '<table class="table table-bordered table-hover"><tbody>';
        if ($detail) {
            $response .= '<tr><td style="width: 120px;">T??n</td><td>' . $detail->name . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">SubName</td><td>' . $detail->sub_name . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Description</td><td>' . $detail->description . '</td></tr>';

            $statusName = htmlStatus($detail->status);
            $response .= '<tr><td style="width: 120px;">Tr???ng th??i</td><td>' . $statusName . '</td></tr>';

        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Kh??ng c?? d??? li???u.</td>';
            $response .= '</tr>';
        }
        $response .= '</tbody></table>';
        return $response;
    }
}
