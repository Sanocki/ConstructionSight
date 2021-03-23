<?php

namespace App\Http\Controllers;

use App\Site;
use App\Lot;
use App\SiteApproval;
use App\LotAssignments;
use App\Role;
use App\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LotController extends Controller
{
    protected function index()
    {
        // $user = auth()->user()->UserID;
        // $lots = AssignedSites::where('OwnerID',$user)->get();
        $sites = Site::all();
        return view('lot/index', compact('sites'));
    }

    protected function create()
    {
        $user = auth()->user()->UserID;

        // What sites is this person with
        $site = SiteApproval::Where([['UserID', '=', $user], ['Status', '=', 1]]);

        return view('lot/create', compact('site'));
    }

    protected function store(Request $request)
    {
        $user = auth()->user()->UserID;

        // dd($request);

        $this->validate($request, [
            'number' => 'required|numeric',
            'start' => 'required',
        ]);

        // What sites is this person with
        $site = SiteApproval::Where([['UserID', '=', $user], ['Status', '=', 1]])->first();
        // dd($request->start);
        $lotNumber = $request->start;
        $errorCounter = 0;
        // Creates the new assignments
        for ($i = 1; $i <= $request->number; $i++) {
            if (Lot::where([['SiteID','=',$site->SiteID],['Number','=',$lotNumber]])->count() == 0)
            {
                $lot = Lot::create([
                    'StatusID' => 1,
                    'SiteID' => $site->SiteID,
                    'Number' => $lotNumber,
                ]);
                foreach ($request->Job as $task)
                {
                    LotAssignments::create([
                        'LotID' => $lot->LotID,
                        'JobID' => $task,
                    ]);
                }
            }
            else
            {
                $errorCounter ++;
            }

            $lotNumber++;
        }

        if ($errorCounter > 0)
        {
            return back()->withErrors($errorCounter . ' lot(s) not added due to number duplication!'); 
        }

        return view('lot/create', compact('site'));
    }

    protected function show(Lot $lot)
    {
        // What site is this person doing
        $site = SiteApproval::Where([['UserID', '=', auth()->user()->UserID], ['Status', '=', '1']])->get()->first()->SiteID;

        $workers = DB::table('tbl_SiteApproval')
            ->join('Users', 'Users.UserID', '=', 'tbl_SiteApproval.UserID')
            ->where('tbl_SiteApproval.SiteID', '=', $site)
            ->where('tbl_SiteApproval.Status', '=', 1)
            ->where('Users.RoleID', '=', Role::CONTRACTOR)
            ->select('*')
            ->get();

        // dd($workers);
        return view('lot/show', compact('lot', 'workers'));
    }

    protected function Details(Request $request)
    {
        if ($request->has('Lot')) {
            $this->validate($request, [
                'Jobs' => 'required',
            ]);

            // Creates the new jobs
            for ($i = 0; $i < count($request['Jobs']); $i++) {
                LotAssignments::create([
                    'LotID' => $request->Lot,
                    'JobID' => $request->Jobs[$i],
                ]);
            }
            // dd($request);
        } else {
            $this->validate($request, [
                'Workers' => 'required',
            ]);

            // Creates the new jobs
            for ($i = 0; $i < count($request['Workers']); $i++) {
                $values = explode(',', $request->Workers[$i]);
                $job = LotAssignments::Find($values[1]);

                // Updates the site
                $job->UserID = $values[0];
                $job->save();
            }
        }

        return back();
    }

    protected function remove($j, $l)
    {
        // Remove the job completely 
        if($j == 0)
        {
            $job = LotAssignments::where([['AssignmentID', '=', $l]])->get()->first();
            // dd($job);
            $job->delete();
        }
        // Remove just the person assigned to job
        else
        {
            $job = LotAssignments::where('AssignmentID', '=', $l)->get()->first();
            $job->UserID = null;
            $job->Occupying = 0;
            $job->Complete = 0;
            $job->DateOccupied = null;
            $job->save();
        }
        

        return back();
    }

    protected function contractor()
    {
        $collection = LotAssignments::where('UserID', '=', auth()->user()->UserID)->get()->sortBy('SiteID');
        // dd($collection);
        return view('contractor/show', compact('collection'));
    }

    protected function status($lot, $status)
    {
        $update = Lot::find($lot);
        $complete = LotAssignments::Where([['LotID','=',$lot],['JobID','=',1]])->first();
        
        if ($status == Status::Where('Name','=','Complete')->first()->StatusID)
        {
            $complete->Complete = 1;
        }
        else
        {
            $complete->Complete = 0;
        }
        
        $complete->save();
        
        $update->StatusID = $status;
        $update->save();

        return back();
    }
}
