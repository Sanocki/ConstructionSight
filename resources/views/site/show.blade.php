@extends('layouts.app')

<script type='text/javascript'>
    function editSite(id)
    {
        window.location.href = "/site/edit/" + id;
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


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">SITE INFORMATION
                    <button onclick="editSite({{ $site->SiteID }})" class="btn btn-link btn-lg"><span class="glyphicon glyphicon-pencil"></span></button>
                </div>
                <div class="panel-heading">
                    <a href="/site/index" class="btn btn-primary">BACK</a>
                </div>
                    <div style="margin: 40px 10px">
                        <h1>{{ $site->Name }}</h1>
                        <h2>Address: {{ $site->Address }}</h2>
                        <p>Phone Number: {{ $site->Phone }}</p>
                        @if (!empty($site->Photo))
                            <img src="{{ asset('uploads/site/' . $site->Photo) }}" width="100%">
                        @endif
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
