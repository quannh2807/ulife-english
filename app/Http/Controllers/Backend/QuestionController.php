<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{


    public function __construct()
    {
    }

    public function index()
    {
        return view('admin.question.index');
    }

    public function create()
    {
        $levelData = DB::table('levels')->where('status', 1)->get();
        $topicsData = DB::table('topics')->where('status', 1)->get();

        return view('admin.question.create', [
            'levelData' => $levelData,
            'topicsData' => $topicsData,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
