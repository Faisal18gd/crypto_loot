<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'MintCash') }} - Panel</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- MetisMenu CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/startmin.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div id="wrapper">


    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'MintCash') }}</a>
        </div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <ul class="nav navbar-right navbar-top-links">
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
            @else
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
        @if (Auth::user()->id == env('ADMIN'))
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <h4 style="margin:20px" class="text-success">Admin Panel</h4>
                        <li><a href="{{ url('/members/index')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                        <li><a href="{{ url('/members/notifications')}}"><i class="fa  fa-bell-o fa-fw"></i> Notification</a></li>
                        <li><a href="{{ url('/members/users')}}"><i class="fa fa-users fa-fw"></i> User Management</a></li>
                        <li><a href="{{ url('/members/frauds')}}"><i class="fa fa-shield fa-fw"></i> Fraud Prevention</a></li>
                        <li><a href="{{ url('/members/withdrawals')}}"><i class="fa fa-usd fa-fw"></i> Withdrawals</a></li>
                        <li><a href="{{ url('/members/ehistory')}}"><i class="fa fa-list-ul fa-fw"></i> Activities History</a></li>
                        <li><a href="{{ url('/members/spinwheel')}}"><i class="fa fa-list fa-fw"></i> Spin Wheel</a></li>
                        <li><a href="{{ url('/members/scratcher')}}"><i class="fa fa-list fa-fw"></i> Scratcher</a></li>
                        <li><a href="{{ url('/members/lotto')}}"><i class="fa fa-list fa-fw"></i> Lotto</a></li>
                        <li><a href="{{ url('/members/slot')}}"><i class="fa fa-list fa-fw"></i> Slot Game</a></li>
                        <li><a href="{{ url('/members/leaderboard')}}"><i class="fa fa-list fa-fw"></i> Leaderboard</a></li>
                        <li><a href="{{ url('/members/paysettings')}}"><i class="fa fa-exchange fa-fw"></i> Payment Settings</a></li>
                        <li><a href="{{ url('/members/offerwalls')}}"><i class="fa fa-sitemap fa-fw"></i> Offerwall Setup</a></li>
                        <li><a href="{{ url('/members/appsettings')}}"><i class="fa fa-wrench fa-fw"></i> App Settings</a></li>
                        <li><a href="{{ url('/members/faq')}}"><i class="fa fa-file-text fa-fw"></i> F.A.Q. Management</a></li>
                        <li><a href="{{ url('/members/terms')}}"><i class="fa fa-file-text fa-fw"></i> Terms of Service</a></li>
                        <li><a href="{{ url('/members/admins')}}"><i class="fa  fa-user fa-fw"></i> Admin Profile</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out fa-fw"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    </nav>
    @endif


    @yield('content')

</div>

<script src="https://code.jquery.com/jquery-2.1.3.min.js"
        integrity="sha256-ivk71nXhz9nsyFDoYoGf2sbjrR9ddh+XDkCcfZxjvcM=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.js"></script>
<script src="{{ asset('js/startmin.js') }}"></script>
@auth
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.1/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="{{ asset('js/morris-data.js') }}"></script>
    <script>
        $("[data-toggle=popover]").popover()
    </script>
@endauth

</body>

</html>