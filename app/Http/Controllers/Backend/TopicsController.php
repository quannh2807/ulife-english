<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicsRequest;
use App\Models\Levels;
use App\Models\Topics;
use App\Repositories\TopicsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data = Topics::orderBy('id', 'DESC')->paginate(PAGE_SIZE);
        $levelData = DB::table('levels')->where('status', 1)->get();

        return view('admin.topics.index', [
            'data' => $data,
            'levelData' => $levelData,
        ]);
    }

    public function search(Request $request)
    {
        $mSearch = Topics::query();
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
        if (!empty(request('level'))) {
            $mSearch->where('level_id', request('level'));
        }
        if (request('status') >= 0) {
            $mSearch->where('status', request('status'));
        }

        $data = $mSearch->orderBy('id', 'DESC')->paginate(10);
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
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $isSave = $this->topicsRepository->storeNew($data);
        return redirect()->route('admin.topics.index')->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
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

    public function update(TopicsRequest $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $data['updated_by'] = Auth::user()->id;
        $isSave = $this->topicsRepository->update($id, $data);
        return redirect()->route('admin.topics.index')->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }


    public function remove(Request $request)
    {
        $id = $request->id;
        $this->topicsRepository->deleteById($id);
        return redirect()->route('admin.topics.index');
    }

    public function detail()
    {
        $questionId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        $detail = Topics::findOrFail($questionId);

        $response = '<table class="table table-bordered table-hover"><tbody>';
        if ($detail) {
            $response .= '<tr><td style="width: 120px;">T??n</td><td>' . $detail->name . '</td></tr>';
            $levelName = !empty($detail->hasLevel) ? '<span class="badge badge-primary">' . $detail->hasLevel->name . '</span>' : '<span class="badge badge-secondary">No Level</span>';
            $response .= '<tr><td style="width: 120px;">Level</td><td>' . $levelName . '</td></tr>';
            $statusName = htmlStatus($detail->status);
            $response .= '<tr><td style="width: 120px;">Tr???ng th??i</td><td>' . $statusName . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Ng??y t???o</td><td>' . $detail->created_at . '</td></tr>';

        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Kh??ng c?? d??? li???u.</td>';
            $response .= '</tr>';
        }
        $response .= '</tbody></table>';
        return $response;
    }
}
