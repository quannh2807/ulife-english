<?php
/**
 * Class HomeController
 * Created by nguyendx.
 * Date: 7/23/21
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }
}
