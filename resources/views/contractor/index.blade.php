@extends('layouts.app')
<script type='text/javascript'>
    function myFunction(id) {
        window.location.href = "/site/index/" + id;
    }

</script>

@section('refresh')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <meta http-equiv="refresh" content="15" />
@endsection

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

    @foreach ($sites as $site)
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>{{ $site->sites->Name }} | Assigned Lots</strong></div>
                        <div class="panel-body">
                            @php
                                $lots = $lots->sortBy('LotID');
                                $dates = $lots->sortBy('DateAssigned');
                                $siteLots = $site->sites->siteLots;
                            @endphp
                            @foreach ($dates as $lot)
                                @if ($siteLots->contains('LotID', $lot->LotID))
                                    <div class="row"
                                        style="width: 100%; color:rgb(48, 48, 48); margin:15px 0px; border: 1px solid rgb(189, 189, 189); text-align:center; box-shadow: 2px 2px rgb(237, 237, 237); padding: 10px 0px">
                                        <div class="col"
                                            style="padding: 5px 20px;color:{{ $houseColor[$lot->lot->StatusID] }}; text-align:left;">
                                            <span class="{{ $status[$lot->lot->StatusID] }}" style="min-width:30px">
                                            </span>LOT: {{ $lot->lot->Number }}
                                        </div>
                                        <div class="col" style="padding: 5px 20px; text-align:right">
                                            <p>Date Assigned:
                                                {{ \Carbon\Carbon::parse($lot->DateAssigned)->format('j F, y') }} </p>
                                        </div>
                                        <div style="width: 100%"></div>
                                        @php
                                            $Occupier = \App\LotAssignments::where([['LotID', '=', $lot->LotID], ['Occupying', '=', 1]])->get();
                                        @endphp
                                        @if (count($Occupier) > 0)
                                            @foreach ($Occupier as $job)
                                                <div class="col" style="margin: 5px 2px;">
                                                    <span title="{{ $job->jobs->Name . $job->jobs->JobID }}">
                                                        <h4 class="{{ $icons[$job->jobs->JobID] }}"
                                                            style={{ $job->UserID === null ? 'color:' . $jobColor[1] : ($job->Complete ? 'color:' . $jobColor[4] : ($job->Occupying ? 'color:' . $jobColor[3] : 'color:' . $jobColor[2])) }}>
                                                        </h4>
                                                    </span><br>
                                                    <label>{{ $job->jobs->Name }}</label>
                                                    <br>
                                                    <label>{{ \Carbon\Carbon::parse($job->DateOccupied)->format('j F @ H:i') }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div style="width: 100%; border-bottom:1px solid rgb(189, 189, 189); margin-bottom:10px"></div>
                                        <div class="col">
                                            <a class="btn btn-light" style="width: 100%" href="occupy/{{ $lot->LotID }}" class="btn">Occupy</a>
                                        </div>
                                        <div class="col">
                                            <a class="btn btn-light" style="width: 100%" href="leave/{{ $lot->LotID }}" class="btn">Leave</a>
                                        </div>
                                        <div class="col">
                                            <a class="btn btn-light" style="width: 100%" href="clean/{{ $lot->LotID }}" class="btn">Needs Cleaning</a>
                                        </div>
                                        <div class="col">
                                            <a class="btn btn-light" style="width: 100%" href="complete/{{ $lot->LotID }}" class="btn">Complete</a>
                                        </div>
                                        {{-- <label for="">Status</label> --}}
                                    </div>
                                @endif
    @endforeach
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    @endforeach

@endsection
