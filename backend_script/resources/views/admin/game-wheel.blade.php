<?php use Carbon\Carbon; ?>
@extends('layouts.head')
@section('content')
<style>
	.numspan {
		border-radius: 3px;
		background-color: #428bca;
		padding: 7px 10px;
		color: #fff;
		font-weight: bold;
		line-height: 40px
	}

	.numimp {
		border-radius: 3px 0px 0px 3px;
		color: #666 !important;
		padding: 5px;
		background-color: #cc0
	}

	.numa {
		color: #666 !important;
		padding: 5px;
		border-radius: 0px 3px 3px 0px;
		background-color: #ccc;
		cursor: pointer;
		margin-right: 10px
	}

	.numa:hover {
		text-decoration: none
	}
</style>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Spin Wheel Setup</h3>
		</div>
	</div>
	<div class="tab-content">
		@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div><br />
		@elseif (\Session::has('error'))
		<div class="alert alert-danger">
			{{ \Session::get('error') }}
		</div>
		@elseif (\Session::has('success'))
		<div class="alert alert-success">
			{{ \Session::get('success') }}
		</div>
		@endif
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="form-group">
					<div class="col-lg-12" style="padding:0px !important">
						<form role="form" method="get" action="{{url('game/wheel/type')}}">
							{{csrf_field()}}
							<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
								<div class="form-group input-group">
									<span class="input-group-addon">Reward by:</span>
									<select class="form-control" name="t">
										@if(env('GAME_WHEEL_PAYTYPE') == 1)
										<option value="1" selected="selected">Points</option>
										<option value="2">Tokens</option>
										@else
										<option value="1">Points</option>
										<option value="2" selected="selected">Tokens</option>
										@endif
									</select>
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding:0px !important">
								<button type="submit" class="btn btn-primary">Update Type</button>
							</div>
						</form>
						<form role="form" method="get" action="{{url('config/setint')}}">
							{{csrf_field()}}
							<input type="hidden" name="max" value="3" />
							<input type="hidden" name="key" value="GAME_WHEEL_COST" />
							<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
								<div class="form-group input-group">
									<span class="input-group-addon">Spin cost:</span>
									<input name="value" class="form-control"
										placeholder="{{env('GAME_WHEEL_COST')}}"><br>
									<span class="input-group-addon">tokens</span>
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding:0px !important">
								<button type="submit" class="btn btn-primary">Update</button>
							</div>
						</form>
						<form role="form" method="get" action="{{url('game/wheel/setmaxspin')}}">
							{{csrf_field()}}
							<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
								<div class="form-group input-group">
									<span class="input-group-addon">Max free spin:</span>
									<input name="max" class="form-control"
										placeholder="{{env('GAME_WHEEL_MAX_FREE')}}"><br>
									<span class="input-group-addon">Spins</span>
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding:0px !important">
								<button type="submit" class="btn btn-primary">Update Spin</button>
							</div>
						</form>
						<form role="form" method="get" action="{{url('config/setint')}}">
							{{csrf_field()}}
							<input type="hidden" name="max" value="3" />
							<input type="hidden" name="key" value="GAME_WHEEL_MINS" />
							<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
								<div class="form-group input-group">
									<span class="input-group-addon">Free spin in every:</span>
									<input name="value" class="form-control"
										placeholder="{{env('GAME_WHEEL_MINS')}}"><br>
									<span class="input-group-addon">minutes</span>
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding:0px !important">
								<button type="submit" class="btn btn-primary">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>


		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-12 panel panel-green">
					<form role="form" method="get" action="{{url('game/wheel/setdata')}}">
						{{csrf_field()}}
						<div class="col-lg-4" style="padding:15px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Easiness level:</span>
								<input name="easiness" class="form-control" placeholder="1"><br>
							</div>
						</div>
						<div class="col-lg-5" style="padding:15px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Reward amount:</span>
								<input name="amount" class="form-control" placeholder="1200"><br>
							</div>
						</div>
						<div class="col-lg-3" style="padding:15px 0px 15px 0px !important">
							<button type="submit" class="btn btn-primary">Add to Spinner</button>
						</div>
					</form>
				</div>
				@if(env('GAME_WHEEL_PAYTYPE') == '2')
				@foreach($data as $d)
				<span style="white-space:nowrap">
					<span class="numimp">{{$d->easiness}}</span><span class="numspan">{{ round($d->amount, 0)}}
						T</span><a class="numa" href="/game/wheel/deldata?d={{$d->id}}">X</a>
				</span>
				@endforeach
				@else
				@foreach($data as $d)
				<span style="white-space:nowrap">
					<span class="numimp">{{$d->easiness}}</span><span class="numspan">{{ round($d->amount, 0)}}
						P</span><a class="numa" href="/game/wheel/deldata?d={{$d->id}}">X</a>
				</span>
				@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
@endsection