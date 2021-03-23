@extends('layouts.app')
<script type='text/javascript'>
    function myFunction(id)
    {
        window.location.href = "/site/index/" + id;
    }
</script> 

@section('content')

@if ($flash = session('success'))
<div id="flash-message" class="alert alert-success" role="alert">
    {{ $flash }}
</div>
@endif

@if ($flash = session('nochange'))
<div id="flash-message" class="alert alert-warning" role="alert">
    {{ $flash - message }}
</div>
@endif

@foreach ($sites as $site)
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading bg-success" onclick="return myFunction({{ $site->SiteID }});">{{ $site->Name }}</div>
                        <div style="margin: 40px 10px">
                            <h2>{{ $site->Address }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
@endsection
