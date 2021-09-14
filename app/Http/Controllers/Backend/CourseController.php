<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    private $courseRepository;

    public function __construct(CourseRepository $repository)
    {
        $this->courseRepository = $repository;
    }

    public function index()
    {
        $data = Course::orderBy('id', 'DESC')->paginate(PAGE_SIZE);
        return view('admin.course.index', [
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $mSearch = Course::query();
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

        return view('admin.course.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $levelData = DB::table('levels')->where('status', 1)->get();
        return view('admin.course.create', [
            'levelData' => $levelData,
        ]);
    }

    public function store(CourseRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $isSave = $this->courseRepository->storeNew($data);
        return redirect()->route('admin.course.index')->with($isSave ? SUCCESS : ERROR, $isSave ? CREATE_SUCCESS : CREATE_ERROR);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $data = $this->courseRepository->findById($id, []);
        $levelData = DB::table('levels')->where('status', 1)->get();
        return view('admin.course.update', [
            'data' => $data,
            'levelData' => $levelData,
        ]);
    }

    public function update(CourseRequest $request)
    {
        $id = $request->id;
        $data = $request->except(['_token', 'id']);
        $data['updated_by'] = Auth::user()->id;
        $isSave = $this->courseRepository->update($id, $data);
        return redirect()->route('admin.course.index')->with($isSave ? SUCCESS : ERROR, $isSave ? UPDATE_SUCCESS : UPDATE_ERROR);
    }


    public function remove(Request $request)
    {
        $id = $request->id;
        $this->courseRepository->deleteById($id);
        return redirect()->route('admin.course.index');
    }

    public function detail()
    {
        $questionId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        $detail = Course::findOrFail($questionId);

        $response = '<table class="table table-bordered table-hover"><tbody>';
        if ($detail) {
            $response .= '<tr><td style="width: 120px;">Tên</td><td>' . $detail->name . '</td></tr>';
            $response .= '<tr><td style="width: 120px;">Description</td><td>' . $detail->description . '</td></tr>';

            $levelName = !empty($detail->hasLevel) ? '<span class="badge badge-primary">' . $detail->hasLevel->name . '</span>' : '<span class="badge badge-secondary">No Level</span>';
            $response .= '<tr><td style="width: 120px;">Level</td><td>' . $levelName . '</td></tr>';

            $statusName = htmlStatus($detail->status);
            $response .= '<tr><td style="width: 120px;">Trạng thái</td><td>' . $statusName . '</td></tr>';

        } else {
            $response .= '<tr>';
            $response .= '<td align="center" colspan="2">Không có dữ liệu.</td>';
            $response .= '</tr>';
        }
        $response .= '</tbody></table>';
        return $response;
    }
}
