@extends('layouts.app')
<script type='text/javascript'>
    function myFunction(id) {
        window.location.href = "/site/index/" + id;
    }

</script>

@section('refresh')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

@php
$stats = \App\Status::All();
@endphp

@section('content')

    @php
    $icons = [
        1 => 'fa fa-child fa-2x',
        2 => 'fa fa-hamburger fa-2x',
        3 => 'fa fa-cheese fa-2x',
        4 => 'fa fa-universal-access fa-2x',
        5 => 'fa fa-chess-bishop fa-2x',
        6 => 'fa fa-chess-king fa-2x',
        7 => 'fa fa-chess-knight fa-2x',
        8 => 'fa fa-chess-pawn fa-2x',
        9 => 'fa fa-chess-queen fa-2x',
        10 => 'fa fa-chess-rook fa-2x',
        11 => 'fa fa-check-circle fa-2x',
    ];
    $status = [
        1 => 'fa fa-home fa-lg',
        2 => 'fa fa-broom fa-lg',
        3 => 'fa fa-check-circle fa-lg',
    ];
    $houseColor = [
        1 => 'grey',
        2 => 'brown',
        3 => 'green',
    ];
    $jobColor = [
        1 => 'lightgrey',
        2 => 'black',
        3 => 'orange',
        4 => 'green',
    ];
    $jobStats = [
        1 => 'Not Assigned',
        2 => 'Assigned',
        3 => 'Working',
        4 => 'Complete',
    ];
    @endphp

    @if ($flash = session('success'))
        <div id="flash-message" class="alert alert-success" role="alert">
            {{ $flash }}
        </div>
    @endif

    @if ($flash = session('nochange'))
        <div id="flash-message" class="alert alert-warning" role="alert">
            {{ $flash }}
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading bg-success">
                        <div class="row">

                            <div class="col">
                                <h4 class="display-4" style="font-weight: bolder" >LOT #{{ $lot->Number }} </h4>
                            </div>
                            <div class="col" style="text-align: right">
                               <span style="font-weight: bolder">Update Status: </span> 
                                @foreach ($stats as $stat)
                                    <a href="/lot/status/{{ $lot->LotID }}/{{ $stat->StatusID }}" class="btn">{{$stat->Name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-check form-check-inline">
                            <form method="POST">
                                {{ csrf_field() }}
                                <div class="row" style="width: 100%; text-align:center; margin-left:2px">
                                    <div class="col list-group-item">
                                        <span class="{{ $status[$lot->StatusID] }}"
                                            style="padding: 5px 20px; color:{{ $houseColor[$lot->StatusID] }}"></span>Status:
                                        {{ $stats[$lot->StatusID - 1]->Name }}
                                    </div>
                                    <div style="width: 100%"></div>
                                    @foreach ($lot->assignments->sortBy('JobID') as $job)
                                        <div class="col stats">
                                            <span class="{{ $icons[$job->JobID]}}" style={{ $job->UserID === null ? 'color:' . $jobColor[1] : ($job->Complete ? 'color:' . $jobColor[4] : ($job->Occupying ? 'color:' . $jobColor[3] : 'color:' . $jobColor[2])) }}></span>
                                            <br>
                                            <label>{{ $job->jobs->Name }}              
                                                <br>                              
                                                    <a title="Remove Job {{ $job->jobs->Name }} From Lot"
                                                style="text-align: right" class="fa fa-trash"
                                                href="/lot/remove/0/{{ $job->AssignmentID }}"></a></label>
                                        </div>
                                        @if (isset($job->user))
                                            @if ($job->user->RoleID != 3)
                                                <div class="col stats" style="margin-top:20px">
                                                    <div>
                                                        {{ $job->user->Company }}
                                                    </div>
                                                    <div>
                                                        <a title="Remove Person Assigned to {{ $job->jobs->Name }}"
                                                            class="fa fa-trash"
                                                            href="/lot/remove/1/{{ $job->AssignmentID }}"></a>
                                                    </div>
                                                </div>
                                                <div class="col stats" style="margin-top:20px">
                                                    {{ $job->Occupying ? 'Working' : ($job->Complete ? 'Finished' : '' ) }}
                                                    <br>
                                                    {{ $job->Occupying ? \Carbon\Carbon::parse($job->DateOccupied)->format('j F @ H:i') : '' }}
                                                </div>
                                                <div class="col stats" style="margin-top:20px">
                                                    {{ $job->Complete ? 'Job Complete' : 'Job Not Complete' }}
                                                </div>
                                            @else
                                                <div class="col stats" style="margin-top:20px">
                                                    <div>
                                                        {{ $job->user->FirstName . ' ' . $job->user->LastName }}
                                                    </div>
                                                    <div>
                                                        <a title="Remove Assigned {{ $job->jobs->Name }}"
                                                            style="text-align: right" class="fa fa-trash"
                                                            href="/lot/remove/1/{{ $job->AssignmentID }}"></a>
                                                    </div>
                                                </div>
                                                <div class="col stats">
                                                </div>

                                                <div class="col stats" style="margin-top:20px">
                                                    {{ $job->Complete ? 'Job Complete' : 'Job Not Complete' }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="col stats" >
                                                <select class="form-control" name="Workers[]" id="Workers[]"
                                                    style="width: 90%;">
                                                    <option value="" disabled selected>Select a contractor...</option>
                                                    @foreach ($workers as $worker)
                                                        @if ($worker->JobID == $job->JobID)
                                                            <option
                                                                value="{{ $worker->UserID }},{{ $job->AssignmentID }}">
                                                                {{ $worker->Company . ' | ' . $worker->LastName }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                        @endif
                                        <div style="width: 100%"></div>
                                    @endforeach


                                </div>
                                <div style="text-align: center; padding: 20px 0px">
                                    <button class="btn btn-secondary">Add Contractors</button>
                                </div>
                        </div>
                    </div>
                    </form>

                    <div class="form-group" style="text-align:center">
                        <h4>Add Jobs to Lot</h4>
                        <hr>

                        <div class="{{ $errors->has('Jobs') ? ' has-error' : '' }}">
                            <div>
                                @if ($errors->has('Jobs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Jobs') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <form class="form-horizontal" method="POST">
                            {{ csrf_field() }}
                            @foreach (\App\Job::all() as $task)
                                @if (!$lot->assignments->contains('JobID', $task->JobID))
                                    <input type="checkbox" class="btn-check" style="display: none"
                                        id="{{ $task->JobID }}" name="Jobs[]" value="{{ $task->JobID }}"
                                        autocomplete="off">
                                    <label class="btn btn-primary " style="width: 200px"
                                        for="{{ $task->JobID }}">{{ $task->Name }}</label>
                                    {{-- <input type="checkbox" class="btn-check" id="{{ $task->JobID }}" name="Jobs[]"
                                    value="{{ $task->JobID }}">
                                <label for="Jobs{{ $task->JobID }}">{{ $task->Name }}</label><br> --}}
                                @endif
                            @endforeach
                            <div style="text-align: center; padding: 20px 0px">

                                <button class="btn btn-secondary" name="Lot" value="{{ $lot->LotID }}">Add Jobs</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
