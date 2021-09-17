<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countCourse = Course::where('status', 1)->count();
        $countLesson = Lesson::where('status', 1)->count();
        $countVideo = Video::where('status', 1)->count();

        return view('admin.dashboard.index', [
            'countCourse' => $countCourse,
            'countLesson' => $countLesson,
            'countVideo' => $countVideo,
        ]);
    }
}
