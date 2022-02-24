@extends('layouts.head')

@section('content')
</nav>
<div class="container" style="margin-top:80px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome back {{ Auth::user()->name }} <span style="float:right; font-size:12px">[ <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a> ]</span></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					<div style="display: inline-block; "><img style="width:100px; height:120px" src="{{ Auth::user()->avatar }}"/></div>
					<div style="margin-left:30px;display: inline-block; vertical-align:middle">
						<ul>
							<li style="margin-bottom: 5px;color:black"><b>Email:</b> {{ Auth::user()->email }}</li>
							<li style="margin-bottom: 5px;color:#333"><b>Balance:</b> {{ Auth::user()->balance }} points</li>
							<li style="margin-bottom: 5px;color:green"><b>Available:</b> {{ Auth::user()->available }} points</li>
							<li style="margin-bottom: 5px;color:red"><b>Pending:</b> {{ Auth::user()->pending }} points</li>
						</ul>
					</div>
                </div>
				<center><i>Nothing to do here. Please use your mobile app to earn / withdraw / change settings</i></center><br>
            </div>
        </div>
    </div>
</div>
@endsection
