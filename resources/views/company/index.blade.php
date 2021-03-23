@extends('layouts.app')

<script type='text/javascript'>
    function myFunction(id)
    {
        window.location.href = "/company/index/" + id;
    }

    function editSite(id)
    {
        window.location.href = "/company/create/" + id;
    }
</script> 

@section('content')

{{-- Checks if the incoming variable is a collection or array --}}
@if (!is_a($sites, 'Illuminate\Database\Eloquent\Collection'))
    <div>
        <a href="/company/index" class="primary">BACK</a>
        <button onclick="editSite({{ $sites->SiteID }})">Edit</button>
    </div>
@endif


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
                <div class="panel-heading">SITE INFORMATION</div>
                @if (!is_a($sites, 'Illuminate\Database\Eloquent\Collection'))
                    <div style="margin: 40px 10px">
                        <h1>{{ $sites->Name }}</h1>
                        <h2>Address: {{ $sites->Address }}</h2>
                        <p>Phone Number: {{ $sites->Phone }}</p>
                        <p>Number of Lots: {{ $sites->Lots }}</p>
                        @if (!empty($sites->Photo))
                            <img src="{{ asset('uploads/site/' . $sites->Photo) }}">
                        @endif
                    </div>
                @else
                    @foreach ($sites as $site)
                        <div style="margin: 40px 10px" onclick="return myFunction({{ $site->SiteID }});">
                            <h1>{{ $site->Name }}</h1>
                            <h2>{{ $site->Address }}</h2>
                        </div>
                    @endforeach
                @endif 
            </div>
        </div>
    </div>
</div>

@endsection
