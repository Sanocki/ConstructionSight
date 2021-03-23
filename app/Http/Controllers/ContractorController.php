<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\LotAssignments;
use App\Lot;
use App\Job;
use App\SiteApproval;

class ContractorController extends Controller
{
    protected function index()
    {
        $sites = SiteApproval::where([['UserID','=',Auth()->user()->UserID],['Status','=','1']])->get();
        // dd($sites[0]->sites->siteLots);
        $lots = LotAssignments::where([['UserID','=',Auth()->user()->UserID],['Complete','=',false]])->get();
        // dd($lots);
        return view('contractor.index', compact('lots','sites'));
    }

    protected function enter($lot)
    {
        $status = LotAssignments::where([['UserID', '=', Auth()->user()->UserID], ['LotID', '=', $lot]])->get()->first();
        $status->Occupying = true;
        $status->DateOccupied = DB::raw('CURRENT_TIMESTAMP');
        $status->save();

        return back();
    }

    protected function exit($lot)
    {
        $status = LotAssignments::where([['UserID', '=', Auth()->user()->UserID], ['LotID', '=', $lot]])->get()->first();
        $status->Occupying = false;
        $status->save();

        return back();
    }

    protected function finish($lot)
    {
        $status = LotAssignments::where([['UserID', '=', Auth()->user()->UserID], ['LotID', '=', $lot]])->get()->first();

        if ($status->JobID == Job::where('Name','=','Cleaner')->first()->JobID)
        {
            $cleaned = Lot::find($lot);
            $cleaned->StatusID = 1;
            $cleaned->save();
            // dd($cleaned);
            $status->delete();
        }
        else
        {
            $status->Occupying = false;
            $status->Complete = true;
            $status->save();
        }

        return back();
    }

    protected function clean($lot)
    {
        $status = Lot::where('LotID', '=', $lot)->get()->first();
        $status->StatusID = 2;
        $status->save();

        return back();
    }
}
