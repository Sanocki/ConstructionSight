<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\Role;
use App\SiteApproval;

class SiteController extends Controller
{
    public function __construct()
    {
        // Checks who is currently logged in has access 
        // $this->middleware(function ($request, $next) {
        //     if (auth()->user()->RoleID != Role::COMPANY)
        //     {
        //         return redirect('/');
        //     }
        //     return $next($request);
        // });
    }

    protected function index()
    {
        $company = auth()->user()->UserID;
        $sites = Site::where('OwnerID',$company)->get();
        return view('site/index', compact('sites'));
    }

    protected function avaliable()
    {
        $sites = Site::all();
        return view('site/apply', compact('sites'));
    }

    protected function apply(Site $site)
    {
        $sites = Site::all();
        $userID = auth()->user()->UserID;
        $check = SiteApproval::where([['UserID','=',$userID],['SiteID','=',$site->SiteID]])->get();
        
        if ($check->isEmpty())
        {
            // Creates the new site Application
            SiteApproval::create([
                'SiteID' => $site->SiteID,
                'UserID' => $userID
            ]);
            session()->flash('success', "You have applied to this site!");
        }
        else
        {
            session()->flash('nochange', "You have already applied to this site!");
        }
                
        return redirect('site/apply');
    }


    protected function show(Site $site)
    {
        return view('site/show', compact('site'));
    }

    protected function create()
    {
        return view('site/create');
    }

    protected function store(Request $request)
    {
        
        // Validates form input
        $this->validate(request(), [
            'name' => 'required|max:255|min:5',
            'address' => 'required|max:255|min:5|unique:tbl_Sites',
            'phone' => 'required|min:10',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/site/', $filename);
        } else {
            $filename = '';
        }

        // Creates the new site
        Site::create([
            'OwnerID' => auth()->user()->UserID,
            'Name' => $request['name'],
            'Address' => $request['address'],
            'Phone' => $request['phone'],
            'Photo' => $filename,
        ]);

        // Redirect w/ success 
        session()->flash('success', "SITE CREATED");
        return redirect('site/index');
    }

    protected function edit(Site $site)
    {
        return view('site/edit', compact('site'));
    }

    protected function update(Request $request, Site $site)
    {
        // Validates form input
        $this->validate(request(), [
            'name' => 'required|max:255|min:5',
            'address' => 'required|max:255|min:5',
            'phone' => 'required|min:10',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/site/', $filename);
        } else {
            $filename = $site->Photo;
        }

        // Updates the site
        $site->Name = $request['name'];
        $site->Address = $request['address'];
        $site->Phone = $request['phone'];
        $site->Photo = $filename;
    
        // Redirect w/ success 
        if( $site->save()) {
            session()->flash('success', 'Item Successfully updated');
        }
        return redirect('site/index');
    }
}
