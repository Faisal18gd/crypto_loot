<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')


<div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
			
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
        @endforeach
		</ul>
	</div><br />
@elseif (\Session::has('success'))
	<div class="alert alert-success">
    {{ \Session::get('success') }}
	</div>
@elseif (\Session::has('error'))
	<div class="alert alert-danger">
    {{ \Session::get('error') }}
	</div>
@endif			
				
			
                <!-- /.row -->
			<div class="col-lg-5 col-lg-offset-3" style="margin-top:100px">
				@if ($popup['type'] == 'r') 
					<div class="panel panel-green">
						<div class="panel-heading">Rewards for: {{$popup['name']}} <a href="/members/users" style="float:right; color:#fff; text-decoration:none">X</a></div>
							<div class="panel-body">
								<div class="form-group">
									<div class="col-lg-12">
										<label>Email:</label> {{$popup['email']}}<br>
										<label>UID:</label> {{$popup['uid']}}<br>
										<label>Balance:</label> {{$popup['balance']}} points<br>
									
										<form role="form" method="get" action="{{url('admin/reward')}}">
										{{csrf_field()}}
											<input name="uid" type="hidden" value="{{$popup['uid']}}">
											<div class="col-lg-10 form-group has-success input-group" style="margin-top:15px">
											<label class="control-label" for="inputSuccess">Reward amount <small>( points )</small>:</label>
												<input class="form-control" id="inputSuccess" type="text" name="amount" placeholder="0">
											</div>
											<button type="submit" class="btn btn-success">Add reward</button>
										</form>
									</div>
								</div>
							</div>
						<div style="height:10px"></div>
					</div>
				@elseif ($popup['type'] == 'p')
					<div class="panel panel-red">
						<div class="panel-heading">Penalty to: {{$popup['name']}} <a href="/members/users" style="float:right; color:#fff; text-decoration:none">X</a></div>
							<div class="panel-body">
								<div class="form-group">
									<div class="col-lg-12">
										<label>Email:</label> {{$popup['email']}}<br>
										<label>UID:</label> {{$popup['uid']}}<br>
										<label>Balance:</label> {{$popup['balance']}} points<br>
									
										<form role="form" method="get" action="{{url('admin/penalty')}}">
										{{csrf_field()}}
											<input name="uid" type="hidden" value="{{$popup['uid']}}">
											<div class="col-lg-10 form-group has-error input-group" style="margin-top:15px">
											<label class="control-label" for="inputError">Penalty amount <small>( points )</small>:</label>
												<input class="form-control" id="inputError" type="text" name="amount" placeholder="0">
											</div>
											<button type="submit" class="btn btn-danger">Cut points</button>
										</form>
									</div>
								</div>
							</div>
						<div style="height:10px"></div>
					</div>
				@endif
				
				</div>

</div>
@endsection