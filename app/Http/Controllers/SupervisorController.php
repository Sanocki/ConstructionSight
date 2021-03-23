<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LotAssignments;

class SupervisorController extends Controller
{
    protected function index()
    {
        $lots = LotAssignments::where('UserID','=',Auth()->user()->UserID)->get();
        
        return view('supervisor.index', compact('lots'));
    }
}
