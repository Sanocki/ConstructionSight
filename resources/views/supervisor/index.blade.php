@extends('layouts.app')
<script type='text/javascript'>
    function myFunction(id) {
        window.location.href = "/site/index/" + id;
    }

    function showDetails(id) {
        var x = document.getElementsByName("display" + id);
        console.log(x);
        x.forEach(el => {
            if (el.style.display === "") {
                el.style.display = "none";
            } else {
                el.style.display = "";
            }
        });
    }

</script>

@section('refresh')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <meta http-equiv="refresh" content="30" />
@endsection

@section('content')

@php
$icons = [
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
                    <div class="panel-heading">{{ $lots[0]->lot->site->Name }} | <strong>Incomplete Lots</strong></div>
                    <div class="panel-body">
                        <input class="form-control" id="incompleteInput" type="text" placeholder="Search.."  style="width: 95%;">
                        <div class="form-check form-check-inline">
                            <div style="padding:10px 0px;" id="Lots">
                                @php
                                    $incompleteLots = $lots->where('Complete', 0)->sortBy('DateAssigned');
                                @endphp
                                @foreach ($incompleteLots as $lot)
                                    <div class="row" name='row'
                                        style="width: 100%; color:rgb(48, 48, 48); margin:15px 0px; border: 1px solid rgb(189, 189, 189); text-align:center; box-shadow: 2px 2px rgb(237, 237, 237); padding: 10px 0px">
                                        <div class="col"
                                            style="padding: 5px 10px;color:{{ $houseColor[$lot->lot->StatusID] }}; text-align:left;">
                                            <button onclick="showDetails({{ $lot->LotID }})" class="btn"><span class="{{ $status[$lot->lot->StatusID] }}" style="min-width:50px">
                                                </span>LOT: {{ $lot->lot->Number }} </button><a href="/lot/index/{{ $lot->LotID }}" class="btn" style="background:none;border:none; color:black">Edit</a>
                                                {{-- <button class=" btn btn-secondary" style="margin: 0px 10px" onclick="showDetails({{ $lot->LotID }})">View</button> <button class=" btn btn-secondary" style="margin: 0px 10px" onclick="showDetails({{ $lot->LotID }})">Edit</button></h4> --}}
                                        </div>
                                        <div class="col" style="padding: 5px 10px; text-align:right">
                                            <h4>Due Date:
                                                {{ \Carbon\Carbon::parse($lot->lot->DueDate)->format('j F, y') }} </h4>
                                        </div>
                                        <div style="width: 100%"></div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none;padding-top: 10px;">
                                            <p class="h4">Job</p>
                                        </div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none; padding-top: 10px;">
                                            <p class="h4">Contractor</p>
                                        </div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none; padding-top: 10px;">
                                            <p class="h4">Date Assigned</p>
                                        </div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none; padding-top: 10px;">
                                            <p class="h4">Date Occupied</p>
                                        </div>

                                        @php
                                            $jobs = \App\LotAssignments::where('LotID', $lot->LotID)->get();
                                        @endphp
                                        {{-- {{ $jobs = \App\LotAssignments::where('LotID',$lot->LotID)->get() }} --}}
                                        @foreach ($jobs as $job)
                                            {{-- {{ $job }} --}}
                                            @if ($job->JobID != 1)
                                                <div name="display{{ $lot->LotID }}" style="width:100%; display: none;">
                                                </div>
                                                <div class="col"
                                                    style="margin: 5px 2px;">
                                                    <span title="{{ $job->jobs->Name . $job->jobs->JobID }}">
                                                        <h4 class="{{ $icons[$job->jobs->JobID] }}"
                                                            style={{ $job->UserID === null ? 'color:' . $jobColor[1] : ($job->Complete ? 'color:' . $jobColor[4] : ($job->Occupying ? 'color:' . $jobColor[3] : 'color:' . $jobColor[2])) }}>
                                                        </h4>
                                                    </span>
                                                    <br>
                                                    <label>{{ $job->jobs->Name }}</label>
                                                </div>
                                                <div class="col" name="display{{ $lot->LotID }}"
                                                    style="display: none; padding-top: 20px;">
                                                    <span title="{{ $job->jobs->Name . $job->jobs->JobID }}">
                                                        <p>{{ $job->UserID == null ? 'Not Assigned' : $job->user->Company }}
                                                        </p>
                                                    </span>
                                                </div>
                                                <div class="col" name="display{{ $lot->LotID }}"
                                                    style="display: none; padding-top: 20px;">
                                                    <p>{{ $job->DateAssigned == null ? 'N/A' : \Carbon\Carbon::parse($job->DateAssigned)->format('j F') }}
                                                    </p>
                                                </div>
                                                <div class="col" name="display{{ $lot->LotID }}"
                                                    style="display: none; padding-top: 20px;">
                                                    <p>{{ $job->DateOccupied == null ? 'N/A' : \Carbon\Carbon::parse($job->DateOccupied)->format('j F @ H:i') }}
                                                    </p>
                                                </div>
                                            @endif
                                            {{-- <a class="btn btn-primary" href="/lot/index/{{ $lot->LotID }}">{{ $lot->lot->Number }}</a> --}}
                                        @endforeach
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">{{ $lots[0]->lot->site->Name }} | <strong>Completed Lots</strong></div>
                    <div class="panel-body">
                        <input class="form-control" id="completeInput" type="text" placeholder="Search.." style="width: 95%;">
                        <div class="form-check form-check-inline">
                            <div style="padding:10px 0px;" id="CompleteLots">
                                @php
                                    $completeLots = $lots->where('Complete', 1)->sortBy('DateAssigned');
                                @endphp
                                @foreach ($completeLots as $lot)
                                    <div class="row" name="completeRow"
                                        style="width: 100%; color:black; margin:5px 0px; border: 1px solid rgb(189, 189, 189); text-align:center; box-shadow: 2px 2px rgb(237, 237, 237); ">
                                        <div class="col"
                                            style="padding: 5px 10px;color:{{ $houseColor[$lot->lot->StatusID] }}; text-align:left;">
                                            <button onclick="showDetails({{ $lot->LotID }})" class="btn"><span class="{{ $status[$lot->lot->StatusID] }}" style="min-width:50px">
                                            </span>LOT: {{ $lot->lot->Number }}</button><a href="/lot/index/{{ $lot->LotID }}" class="btn" style="background:none;border:none; color:black">Edit</a>
                                        </div>
                                        <div class="col" style="padding: 5px 10px; text-align:right">
                                            <h4>Due Date:
                                                {{ \Carbon\Carbon::parse($lot->lot->DueDate)->format('j F, y') }} </h4>
                                        </div>
                                        <div style="width: 100%"></div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none;padding-top: 10px;">
                                            <p class="h4">Job</p>
                                        </div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none; padding-top: 10px;">
                                            <p class="h4">Contractor</p>
                                        </div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none; padding-top: 10px;">
                                            <p class="h4">Date Assigned</p>
                                        </div>
                                        <div class="col" name="display{{ $lot->LotID }}"
                                            style="display: none; padding-top: 10px;">
                                            <p class="h4">Date Occupied</p>
                                        </div>

                                        @php
                                            $jobs = \App\LotAssignments::where('LotID', $lot->LotID)->get();
                                        @endphp
                                        {{-- {{ $jobs = \App\LotAssignments::where('LotID',$lot->LotID)->get() }} --}}
                                        @foreach ($jobs as $job)
                                            {{-- {{ $job }} --}}
                                            @if ($job->JobID != 1)
                                                <div name="display{{ $lot->LotID }}" style="width:100%; display: none;">
                                                </div>
                                                <div class="col"
                                                    style="margin: 5px 2px">
                                                    <span title="{{ $job->jobs->Name . $job->jobs->JobID }}">
                                                        <h4 class="{{ $icons[$job->jobs->JobID] }}"
                                                            style={{ $job->UserID === null ? 'color:' . $jobColor[1] : ($job->Complete ? 'color:' . $jobColor[4] : ($job->Occupying ? 'color:' . $jobColor[3] : 'color:' . $jobColor[2])) }}>
                                                        </h4>
                                                        <br>
                                                        <label>{{ $job->jobs->Name }}</label>
                                                    </span>
                                                </div>
                                                <div class="col" name="display{{ $lot->LotID }}"
                                                    style="display: none; margin: 5px 2px; ">
                                                    <span title="{{ $job->jobs->Name . $job->jobs->JobID }}">
                                                        <p>{{ $job->UserID == null ? 'Not Assigned' : $job->user->Company }}
                                                        </p>
                                                    </span>
                                                </div>
                                                <div class="col" name="display{{ $lot->LotID }}"
                                                    style="display: none; margin: 5px 2px; ">
                                                    <p>{{ $job->UserID == null ? 'N/A' : \Carbon\Carbon::parse($job->DateAssigned)->format('j F') }}
                                                    </p>
                                                </div>
                                                <div class="col" name="display{{ $lot->LotID }}"
                                                    style="display: none; margin: 5px 2px; ">
                                                    <p>{{ $job->UserID == null ? 'N/A' : \Carbon\Carbon::parse($job->DateOccupied)->format('j F @ H:i') }}
                                                    </p>
                                                </div>
                                            @endif
                                        @endforeach
                                        {{-- <a class="btn btn-primary" href="/lot/index/{{ $lot->LotID }}">{{ $lot->lot->Number }}</a> --}}
                                    </div>
                                @endforeach
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    $jobs = \App\Job::Where('JobID', '!=', 1)->get();
    $stats = \App\Status::All();
    @endphp

    <div style="position: absolute; top:80px; left:50px; width:300px; height; 400px; padding: 20px 20px; text-align:center;">
        <h1>LEGEND</h1>
        <ul class="list-group" style="text-align:left">
            @php
                $i = 0;
                $j = 1;
            @endphp
            <li class="list-group-item">House Status</li>
            @foreach ($status as $stat)
                <li class="list-group-item"><span class="{{ $stat }}"
                        style="padding: 5px 20px; color:{{ $houseColor[$j++] }}"></span>{{ $stats[$i++]->Name }}</li>
            @endforeach
            @php
                $i = 1;
                $j = 1;
            @endphp
            <li class="list-group-item">Job Status</li>
            @foreach ($jobStats as $stat)
                <li class="list-group-item"><span class="{{ $icons[2] }}"
                        style="padding: 5px 20px; color:{{ $jobColor[$j++] }}"></span>{{ $stat }}</li>
            @endforeach
        </ul>
    </div>


    <script>
        $(document).ready(function() {
            $("#incompleteInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#Lots .row").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        $(document).ready(function() {
            $("#completeInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#CompleteLots .row").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

@endsection
