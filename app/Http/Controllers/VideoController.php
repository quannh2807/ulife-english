<?php


namespace App\Http\Controllers;


class VideoController
{
    public function index() {
        return view('admin.dashboard.index');
    }

    public function youtube() {
        return view('admin.video.index');
    }

}
