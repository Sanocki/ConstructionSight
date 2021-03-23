<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('refresh')
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Construction Sight') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>


</head>
<body>
    @php
        if (!Auth::guest())
        {
            $belongs = \App\SiteApproval::where([['UserID','=', auth()->user()->UserID],['Status','=', 1]])->first() == null ? false : true;
            $role = Auth()->user()->RoleID;
        }
    @endphp
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Construction Sight') }}
                    </a>
                </div>

                
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @if (!Auth::guest())
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            {{-- SITE LINKS --}}
                            @if ($role == 1)
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Sites<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="/site/index">View Sites</a>
                                </li>
                                <li>
                                    <a href="/site/create">Create New Site</a>
                                </li>
                                <li class="divider">&nbsp</li>
                                <li>
                                    <a href="/admin/site">Site Applications</a>
                                </li>
                            </ul>
                            @elseif($role == 2 && $belongs)
                                <a href="/admin/site" class="dropdown-toggle" role="button"> Supervisor Approvals</a>    
                            @elseif($role == 3 && $belongs)
                                <a href="/admin/site" class="dropdown-toggle" role="button"> Contractor Approvals</a>    
                            @else
                            {{-- Check if the person is apart of a site so no need to apply --}}
                                @if (!$belongs || $role == 4)
                                    <a href="/site/apply" class="dropdown-toggle" role="button"> Apply To A Site!</a>                                    
                                @endif
                            @endif
                        </li>
                        {{-- Check if the person is apart of a site so they can see the lots --}}
                        @if ($belongs)
                        <li class="dropdown">
                            @if ($role == 2)
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                               Lots<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="/lot/create">Creation</a>
                                </li>
                                <li>
                                    <a href="/admin/lot">Assignments</a>
                                </li>
                            </ul>
                            @elseif ($role == 3 )
                            <a href="/supervisor/index" class="dropdown-toggle" role="button">View Lots</a>         
                            @elseif ($role == 4 )
                                <a href="/contractor/index" class="dropdown-toggle" role="button">View Lots</a>                                    
                            @endif
                        </li>
                        @endif
                    </ul>
                    @endif
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                   Welcome! <strong>{{ Auth::user()->FirstName . ' ' . Auth::user()->LastName }}</strong><span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
