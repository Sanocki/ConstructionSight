<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected function admin()
    {
        return view('manager.admin');
    }

    protected function create()
    {
        return view('manager.create');
    }

    protected function show()
    {
        return view('manager.show');
    }
}
