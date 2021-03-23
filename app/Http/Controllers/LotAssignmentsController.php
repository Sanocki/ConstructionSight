<?php

namespace App\Http\Controllers;

use App\Lot;
use App\Role;
use App\Job;
use App\User;
use Illuminate\Support\Facades\DB;
use App\LotAssignments;
use App\Manager;
use App\SiteApproval;
use Illuminate\Http\Request;

use function Psy\debug;

class LotAssignmentsController extends Controller
{
    public function __construct()
    {
        // Checks who is currently logged in has access 
        $this->middleware(function ($request, $next) {
            if (auth()->user()->RoleID == Role::CONTRACTOR) {
                return redirect('/');
            }
            return $next($request);
        });
    }

    protected function index()
    {
        // Who is looking at the admin page 
        $user = auth()->user();
        $lots = Lot::all();
        $jobs = Job::where('RoleID', '=', Role::SUPERVISOR);
        $site = SiteApproval::Where([['UserID', '=', $user->UserID], ['Status', '=', '1']])->get()->first()->SiteID;

        // Get the supervisors of this site
        $supervisors = DB::table('tbl_SiteApproval')
            ->join('Users', 'tbl_SiteApproval.UserID', '=', 'Users.UserID')
            ->where('tbl_SiteApproval.SiteID', '=', $site)
            ->where('tbl_SiteApproval.Status', '=', 1)
            ->where('Users.RoleID', '=', Role::SUPERVISOR)
            ->get();

        // Get the lots assigned to the 
        $assigned = DB::table('tbl_LotAssignment')
            ->join('tbl_Lots', 'tbl_Lots.LotID', '=', 'tbl_LotAssignment.LotID')
            ->select('tbl_LotAssignment.LotID', 'tbl_LotAssignment.UserID', 'tbl_Lots.Number', 'tbl_LotAssignment.JobID')
            ->get();


        // $assignments = DB::table('tbl_Lots')
        //     ->join('tbl_Sites','tbl_Lots.SiteID','=','tbl_Sites.SiteID')
        //     ->join('tbl_SiteApproval','tbl_Sites.SiteID','=','tbl_SiteApproval.SiteID')
        //     ->join('Users','tbl_SiteApproval.UserID','=','Users.UserID')
        //     ->where('tbl_Sites.OwnerID','=',$user->UserID)
        //     ->select('*','Users.Name as Worker','tbl_Sites.Name as Site')
        //     ->get();


        $assignments = DB::table('tbl_Lots')
            ->join('tbl_Sites', 'tbl_Lots.SiteID', '=', 'tbl_Sites.SiteID')
            ->join('tbl_SiteApproval', 'tbl_Sites.SiteID', '=', 'tbl_SiteApproval.SiteID')
            ->where('tbl_SiteApproval.UserID', '=', $user->UserID)
            ->where('tbl_SiteApproval.Status', '=', 1)
            ->select('*')
            ->get();



        // dd($assignments);
        // $assignments = DB::table('lk_LotAssignments')
        //     ->join('tbl_Lots','lk_LotAssignments.LotID','=','tbl_Lots.LotID')
        //     ->join('tbl_Sites','tbl_Lots.SiteID','=','tbl_Sites.SiteID')
        //     ->join('Users','lk_LotAssignments.UserID','=','Users.UserID')
        //     ->where('lk_LotAssignments.UserID','=',$user->UserID)
        //     ->select('*','Users.Name as Worker','tbl_Sites.Name as Site')
        //     ->orderBy('lk_LotAssignments.LotID')
        //     ->get();

        // dd($assigned);
        return view('admin/lot', compact('assignments', 'lots', 'supervisors', 'assigned'));
    }

    protected function store(Request $request)
    {
        // Validates form input
        // dd($request->has('Assign'));
        if ($request->has('Assign')) {
            
            $this->validate($request, [
                'Supervisor' => 'required',
                'LotID' => 'required',
                ]);
                
                // Creates the new assignments
                for ($i = 0; $i < count($request['LotID']); $i++) {
                    LotAssignments::create([
                        'UserID' => $request->Supervisor,
                        'JobID' => 1,
                        'LotID' => $request->LotID[$i],
                        ]);
                    }
                    session()->flash('success', "Lot Assigned");
        }
                
        if ($request->has('Remove')) {
            // Removes assignments
            for ($i = 0; $i < count($request['LotID']); $i++) {
                $assignment = LotAssignments::where([['LotID','=',$request->LotID[$i]],['UserID','=',$request->Remove]])->first();
                $assignment->delete();
            }
            session()->flash('success', "Lot Unassigned");
        }

        // Redirect w/ success 
        return redirect('admin/lot');
    }
}
