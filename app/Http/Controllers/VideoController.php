<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index () {
        return view('admin.video.index');
    }

    public function create()
    {
        return view('admin.video.create');
    }

    /**
     * @param Request $request
     */
    public function saveCreate(Request $request)
    {

    }

    public function update()
    {
        return view('admin.video.create');
    }

    /**
     * @param Request $request
     */
    public function saveUpdate(Request $request)
    {

    }

    public function remove()
    {
        echo 'Deleted';
    }
}
