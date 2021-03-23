@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Lots</div>
                @foreach ($collection as $item)
                <div class="bg-primary" style="padding: 2px 4px; margin: 5px 2px">
                    {{ $item->lot->site->Name }} Lot#{{ $item->LotID}} Status: {{ $item->lot->StatusID }} <br>
                    @foreach (\App\LotAssignments::Where([['Occupying','=',1],['LotID','=',$item->LotID]])->get() as $worker)
                    Currently Occupying: <strong>{{ $worker->user->FirstName }} : {{ $worker->jobs->Name }}</strong><br>
                    @endforeach
                </div>
                <a href="occupy/{{ $item->AssignmentID }}/{{ $item->UserID}}">Occupy</a>
                <a href="complete/{{ $item->AssignmentID }}/{{ $item->UserID}}">Complete</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
