<?php

namespace App\Http\Controllers;

use App\SiteApproval;
use App\Site;
use App\Job;
use App\Role;
use Illuminate\Support\Facades\DB;

class SiteApprovalController extends Controller
{
    public function __construct()
    {
        // Checks who is currently logged in has access 
        $this->middleware(function ($request, $next) {
            if (auth()->user()->RoleID == Role::CONTRACTOR)
            {
                return redirect('/');
            }
            return $next($request);
        });
    }

    protected function index()
    {
        // Who is looking at the admin page 
        $user = auth()->user();
        $jobs = Job::all();
    
        // Company Admin Page
        if ($user->RoleID == Role::COMPANY)
        {
            $sites = Site::where('OwnerID',$user->UserID)->get();

            $approvals = DB::table('tbl_SiteApproval')
            ->join('tbl_Sites','tbl_SiteApproval.SiteID','=','tbl_Sites.SiteID')
            ->join('Users','tbl_SiteApproval.UserID','=','Users.UserID')
            ->join('lk_Roles','Users.RoleID','=','lk_Roles.RoleID')
            ->select('*','Users.LastName as Name','tbl_Sites.Name as Site','lk_Roles.Name as Role')
            ->where('tbl_Sites.OwnerID','=',$user->UserID)
            ->where('tbl_SiteApproval.Status','!=', 3)
            ->where('Users.RoleID','=',Role::MANAGER)
            ->orderBy('tbl_SiteApproval.SiteID')
            ->get();

        }
        // Manager Admin Page
        elseif ($user->RoleID == Role::MANAGER)
        {
            $site = SiteApproval::Where([['UserID','=',$user->UserID],['Status','=',1]])->get()->first();

            // Look at tbl SiteApprovals and see what site this manager is apart of 
            
            $approvals = DB::table('tbl_SiteApproval')
            ->join('tbl_Sites','tbl_SiteApproval.SiteID','=','tbl_Sites.SiteID')
            ->join('Users','tbl_SiteApproval.UserID','=','Users.UserID')
            ->join('lk_Roles','Users.RoleID','=','lk_Roles.RoleID')
            ->select('*','Users.LastName as Name','tbl_Sites.Name as Site','lk_Roles.Name as Role','tbl_SiteApproval.UserID as Owner')
            ->where('tbl_SiteApproval.SiteID','=',$site->SiteID)
            ->where('tbl_SiteApproval.Status','!=',3)
            ->where('Users.RoleID','=',Role::SUPERVISOR)
            ->get();

            $sites = $site->sites;
        }
        // Supervisor Admin Page
        elseif ($user->RoleID == Role::SUPERVISOR)
        {
            $site = SiteApproval::Where([['UserID','=',$user->UserID],['Status','=',1]])->get()->first();

            // Look at tbl SiteApprovals and see what site this supervisor is apart of 
            $approvals = DB::table('tbl_SiteApproval')
            ->join('tbl_Sites','tbl_SiteApproval.SiteID','=','tbl_Sites.SiteID')
            ->join('Users','tbl_SiteApproval.UserID','=','Users.UserID')
            ->join('lk_Roles','Users.RoleID','=','lk_Roles.RoleID')
            ->join('lk_Jobs','Users.JobID','=','lk_Jobs.JobID')
            ->select('*','lk_Jobs.Name as Job','Users.LastName as Name','tbl_Sites.Name as Site','lk_Roles.Name as Role','tbl_SiteApproval.UserID as Owner')
            ->where('tbl_SiteApproval.SiteID','=',$site->SiteID)
            ->where('tbl_SiteApproval.Status','!=',3)
            ->where('Users.RoleID','=',Role::CONTRACTOR)
            ->get();
            
            $sites = $site->sites;
        }

        // dd($approvals);

        return view('admin/site', compact('approvals','sites'));
    }

    protected function accept(SiteApproval $approval)
    {
        $approval->Status = 1;
        // Redirect w/ success 
        if( $approval->save()) {
            session()->flash('success', $approval->users->Name . ' has been ACCEPTED into site ' . $approval->sites->Name);
        }
        return redirect('admin/site');
    }

    protected function reject(SiteApproval $approval)
    {
        $approval->Status = 3;
        // Redirect w/ success 
        if( $approval->save()) {
            session()->flash('nochange', $approval->users->Name . ' has been REJECTED from site ' . $approval->sites->Name);
        }
        return redirect('admin/site');
    }
}
