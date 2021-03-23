@extends('layouts.app')
@section('refresh')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

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
                    <div class="panel-heading">{{ $assignments[0]->Name }} | <strong>Pending Lots</strong></div>
                    <div class="panel-body" >
                        <form class="form-horizontal" method="POST">
                        <div class="form-check form-check-inline">
                                {{ csrf_field() }}
                                <div class="{{ $errors->has('LotID') ? ' has-error' : '' }}">                              
                                    <div >                                
                                        @if ($errors->has('LotID'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('LotID') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @php
                                     $assigned = $assigned->where('JobID','=',1)
                                @endphp
                                <div  style="padding:10px 50px;">
                                    @foreach ($assignments as $lot)
                                    @if (! $assigned->contains('LotID',$lot->LotID))
                                        <input type="checkbox" class="btn-check" style="display: none" id="LotID[{{ $lot->Number }}]" name="LotID[]" value="{{ $lot->LotID }}"  autocomplete="off">
                                        <label class="btn btn-primary" style="min-width: 50px" for="LotID[{{ $lot->Number }}]">{{ $lot->Number }}</label>        
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div style="padding:10px 50px;">
                            <div class="form-check form-check-inline">
                                    <select class="form-control" name="Supervisor" id="Supervisor">
                                        <option disabled selected>Assign Supervisor</option>
                                        @foreach ($supervisors as $sup)
                                        <option value="{{ $sup->UserID }}">{{ $sup->FirstName . ' ' . $sup->LastName }}</option>
                                        @endforeach
                                    </select>
                                        <button name="Assign" class="btn btn-secondary" style="margin: 10px 0px" value="true">Assign Lots</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @foreach ($supervisors as $sup)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $sup->FirstName }} | <strong>Assigned Lots</strong></div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST">
                        <div class="form-check form-check-inline">
                                {{ csrf_field() }}
                                <div class="{{ $errors->has('LotID') ? ' has-error' : '' }}">                              
                                    <div >                                
                                        @if ($errors->has('LotID'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('LotID') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div  style="padding:10px 50px;">
                                    @php
                                        $assigned = $assigned->sortBy('LotID');
                                    @endphp
                                @foreach ($assigned as $lot)
                                    @if ($lot->UserID == $sup->UserID)
                                    <input type="checkbox" class="btn-check" style="display: none" id="LotID[{{ $lot->Number }}]" name="LotID[]" value="{{ $lot->LotID }}"  autocomplete="off">
                                    <label class="btn btn-primary" style="min-width: 50px"  for="LotID[{{ $lot->Number }}]">{{ $lot->Number }}</label>      
                                    @endif
                                @endforeach
                                <hr>
                                <button name="Remove" class="btn btn-secondary" style="margin: 0px 0px" value="{{ $sup->UserID }}">Unassign</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>    



@endsection
