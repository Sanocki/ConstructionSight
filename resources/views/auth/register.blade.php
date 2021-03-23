@extends('layouts.app')

    <script>
        function changeFunc() {
            var selectBox = document.getElementById("role");
            var contractors = document.getElementById("contractors");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            contractors.style.display = "none";
        
            if (selectedValue == 4) contractors.style.display = "";
        }
   </script>

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-row{{ $errors->has('fname') ? ' has-error' : '' }}">
                            <label for="fname" class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-3">
                                <input id="fname" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>
                                @if ($errors->has('fname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-3">
                                <input id="lname" type="text" class="form-control" name="lname" value="{{ old('lname') }}" required autofocus>
                                @if ($errors->has('lname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">User Role</label>

                            <div class="col-md-6">
                                <select name="role" id="role" class="form-control" onchange="changeFunc();" required>
                                    <option value="" disabled selected>Select a role...</option>
                                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>
                                        Company
                                    </option>
                                    <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>
                                        Site Manager
                                    </option>
                                    <option value="3" {{ old('role') == 3 ? 'selected' : '' }}>
                                        Supervisor
                                    </option>
                                    <option value="4" {{ old('role') == 4 ? 'selected' : '' }}>
                                        Contractor
                                    </option>
                                </select>

                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div id="contractors" class="form-group{{ $errors->has('Job') ? ' has-error' : '' }}" style="display: none" {{ old('role') == '' ? 'style="display: none"' : 'style="display: none"' }}>
                            {{  old('role')  }}
                            <label for="job" class="col-md-4 control-label">Job Type</label>
                            <div class="col-md-6">
                                <select name="job" id="job" class="form-control">
                                    <option value="" disabled selected>Select your job...</option>
                                    @php
                                        $jobs = \App\Job::where('JobID', '!=', 1)->get();
                                    @endphp
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job->JobID }}">
                                            {{ $job->Name }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('job'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('job') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-md-4 control-label">Company Name</label>

                            <div class="col-md-6">
                                <input id="company" type="company" class="form-control" name="company" value="{{ old('company') }}" required>

                                @if ($errors->has('company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
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