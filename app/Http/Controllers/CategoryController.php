<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index () {
        return view('admin.categories.index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * @param Request $request
     */
    public function saveCreate(Request $request)
    {

    }

    public function update()
    {
        return view('admin.categories.create');
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
