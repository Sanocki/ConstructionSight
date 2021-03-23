@extends('layouts.app')
@section('refresh')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <h4 style="text-align: center">{{ $error }}</h4>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                
                <div class="panel-heading">Create Lots</div>
                <div style="padding: 10px 40px"> 
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                            <label for="number" class="col-md-4 control-label" style="text-align: left">Number of Lots</label>
                        
                            <div class="col-md-6">
                                <input id="number" type="number" class="form-control" name="number" value="{{ old('number') }}" required autofocus>
                        
                                @if ($errors->has('number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
                            <label for="start" class="col-md-4 control-label"  style="text-align: left">Stating at</label>
                        
                            <div class="col-md-6">
                                <input id="start" type="number" class="form-control" name="start" value="{{ old('start') }}" required autofocus>
                        
                                @if ($errors->has('start'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            @foreach (\App\Job::all() as $task)
                                @if ($task->JobID != 1)
                                <input type="checkbox" class="btn-check" style="display: none" id="Job[{{ $task->JobID }}]" name="Job[]" value="{{ $task->JobID }}"  autocomplete="off">
                                <label class="btn btn-primary" style="width: 200px" for="Job[{{ $task->JobID }}]">{{ $task->Name }}</label>      
                                @endif
                            @endforeach

                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-secondary">
                                    Create Lots 
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
