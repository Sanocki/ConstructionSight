<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected function admin()
    {
        return view('company.admin');
    }

    protected function create()
    {
        return view('company.create');
    }

    protected function index()
    {
        return view('company.index');
    }
}
