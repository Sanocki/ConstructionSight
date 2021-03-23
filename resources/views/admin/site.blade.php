@extends('layouts.app')

@section('content')

    @if ($flash = session('success'))
        <div id="flash-message" class="alert alert-success text-center" role="alert">
            {{ $flash }}
        </div>
    @endif

    @if ($flash = session('nochange'))
        <div id="flash-message" class="alert alert-info text-center" role="alert">
            {{ $flash }}
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Pending Applications | {{ $approvals[0]->Site }}</div>
                    
                    <div class="panel-body">
                        <table class="table table-dark" style="width: 100%">
                            <thead>
                                <th>Action</th>
                                @if (auth()->user()->RoleID != 3)
                                <th>Name</th>
                                @else
                                <th>Company</th>
                                @endif      
                                @if (auth()->user()->RoleID == 3)
                                <th>Job</th>
                                @endif
                                <th>Email</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($approvals as $ap)
                                @if ($ap->Status == 0)
                                <tr>
                                    <td><a href="/admin/Saccept/{{ $ap->ApprovalID }}">Accept</a></td>
                                    
                                    @if (auth()->user()->RoleID != 3)
                                    <td>{{ $ap->FirstName . ' ' . $ap->LastName }}</td>
                                    @else
                                    <td>{{ $ap->Company }}</td>
                                    @endif                                        @if (auth()->user()->RoleID == 3)
                                        <td>{{ $ap->Job }}</td>
                                        @endif
                                        <td>{{ $ap->email }}</td>
                                        <td><a href="/admin/Sreject/{{ $ap->ApprovalID }}">Remove</a></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>    
    
    @foreach ($sites as $site)
    @if (!is_a($sites, 'Illuminate\Database\Eloquent\Collection'))
    @php
            $site = $sites
            @endphp 
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $site->Name }}</div>
                    <div class="panel-body">
                        <table class="table table-dark" >
                            <thead>
                                @if (auth()->user()->RoleID != 3)
                                <th>Name</th>
                                @else
                                <th>Company</th>
                                @endif                                
                                @if (auth()->user()->RoleID == 3)
                                <th>Job</th>
                                @endif
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($approvals as $ap)
                                        @if ($site->SiteID == $ap->SiteID && $ap->Status == 1)
                                        <tr>
                                            @if (auth()->user()->RoleID != 3 )
                                            <td>{{ $ap->FirstName . ' ' . $ap->LastName }}</td>
                                            @else
                                            <td>{{ $ap->Company }}</td>
                                            @endif
                                            @if (auth()->user()->RoleID == 3)
                                            <td>{{ $ap->Job }}</td>
                                            @endif
                                            <td>{{ $ap->Phone }}</td>
                                            <td>{{ $ap->email }}</td>
                                            <td><a href="/admin/reject/{{ $ap->ApprovalID }}">Remove</a></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!is_a($sites, 'Illuminate\Database\Eloquent\Collection'))
        @break
        @endif
        @endforeach
        @endsection
        