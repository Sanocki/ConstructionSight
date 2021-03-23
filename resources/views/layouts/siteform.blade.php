@section('content')
<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Site Name</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

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
        <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>

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
        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('lots') ? ' has-error' : '' }}">
    <label for="lots" class="col-md-4 control-label">Number of Lots</label>

    <div class="col-md-6">
        <input id="lots" type="text" class="form-control" name="lots" value="{{ old('lots') }}">

        @if ($errors->has('lots'))
            <span class="help-block">
                <strong>{{ $errors->first('lots') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
    <label for="photo" class="col-md-4 control-label">Site Photo</label>

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
            Create
        </button>
    </div>
</div>
@endsection