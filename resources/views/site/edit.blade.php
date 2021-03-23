@extends('layouts.app')

@section('content')
<div>
    <a href="/site/index" class="primary">BACK</a>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">EDIT Site</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Site Name</label>
                        
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $site->Name  }}" required autofocus>
                        
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Address</label>
                        
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $site->Address }}" required autofocus>
                        
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>
                        
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ $site->Phone }}" required>
                        
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            <label for="photo" class="col-md-4 control-label">Current Site Photo</label>
                        
                            <div class="col-md-6">
                                @if (!empty($site->Photo))
                                    <img src="{{ asset('uploads/site/' . $site->Photo) }}" width="100%">
                                @else
                                    <p>None uploaded</p>
                                @endif
                            </div>
                            <label for="photo" class="col-md-4 control-label">Upload New Photo</label>
                            <div class="col-md-6">
                                    <input type="file" id="photo" name="photo" />                                
                                @if ($errors->has('photo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
