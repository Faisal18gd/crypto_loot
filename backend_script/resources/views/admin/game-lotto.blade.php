<?php use Carbon\Carbon; ?>
@extends('layouts.head')
@section('content')
<style>
	.holder {
		line-height: 35px;
		padding: 5px
	}

	.emails {
		padding: 5px 10px;
		border-radius: 3px 0px 0px 3px;
		background: #ccc
	}

	.uids {
		border-radius: 3px 0px 0px 3px;
		background: #ccc;
		padding: 5px 10px;
		margin:5px !important
	}
	.uids a {
		text-decoration: none;
		font-weight: bold;
	}
	.uids a:hover {
		text-decoration: none;
		cursor: pointer
	}

	.emails-close {
		cursor: pointer;
		padding: 5px 10px;
		border-radius: 0px 3px 3px 0px;
		background: #07c;
		color: #fff
	}
</style>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Lotto Setup</h3>
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
		<div class="panel panel-default">
			<div class="panel-heading">Reward on match: <small>(enter amount only)</small></div>
			<div class="panel-body">
				<form role="form" method="get" action="{{url('config/setint')}}">
					{{csrf_field()}}
					<input type="hidden" name="max" value="5" />
					<input type="hidden" name="key" value="GAME_LOTTO_MATCH_1" />
					<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
						<div class="form-group input-group">
							<span class="input-group-addon">1 set</span>
							<input name="value" class="form-control" placeholder="{{env('GAME_LOTTO_MATCH_1')}}">
							<span class="input-group-addon">tokens</span>
						</div>
					</div>
					<div class="col-lg-2 form-group" style="padding:0px !important">
						<button type="submit" class="btn btn-info">Submit</button>
					</div>
				</form>
				<form role="form" method="get" action="{{url('config/setint')}}">
					{{csrf_field()}}
					<input type="hidden" name="max" value="5" />
					<input type="hidden" name="key" value="GAME_LOTTO_MATCH_2" />
					<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
						<div class="form-group input-group">
							<span class="input-group-addon">2 sets</span>
							<input name="value" class="form-control" placeholder="{{env('GAME_LOTTO_MATCH_2')}}">
							<span class="input-group-addon">tokens</span>
						</div>
					</div>
					<div class="col-lg-2 form-group" style="padding:0px !important">
						<button type="submit" class="btn btn-info">Submit</button>
					</div>
				</form>
				<form role="form" method="get" action="{{url('config/setint')}}">
					{{csrf_field()}}
					<input type="hidden" name="max" value="5" />
					<input type="hidden" name="key" value="GAME_LOTTO_MATCH_3" />
					<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
						<div class="form-group input-group">
							<span class="input-group-addon">3 sets</span>
							<input name="value" class="form-control" placeholder="{{env('GAME_LOTTO_MATCH_3')}}">
							<span class="input-group-addon">tokens</span>
						</div>
					</div>
					<div class="col-lg-2 form-group" style="padding:0px !important">
						<button type="submit" class="btn btn-info">Submit</button>
					</div>
				</form>
				<form role="form" method="get" action="{{url('config/setint')}}">
					{{csrf_field()}}
					<input type="hidden" name="max" value="5" />
					<input type="hidden" name="key" value="GAME_LOTTO_MATCH_4" />
					<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
						<div class="form-group input-group">
							<span class="input-group-addon">4 sets</span>
							<input name="value" class="form-control" placeholder="{{env('GAME_LOTTO_MATCH_4')}}">
							<span class="input-group-addon">tokens</span>
						</div>
					</div>
					<div class="col-lg-2 form-group" style="padding:0px !important">
						<button type="submit" class="btn btn-info">Submit</button>
					</div>
				</form>
				<form role="form" method="get" action="{{url('config/setint')}}">
					{{csrf_field()}}
					<input type="hidden" name="max" value="5" />
					<input type="hidden" name="key" value="GAME_LOTTO_MATCH_5" />
					<div class="col-lg-8" style="padding:0px 15px 0px 0px !important">
						<div class="form-group input-group">
							<span class="input-group-addon">Winner</span>
							<input name="value" class="form-control" placeholder="{{env('GAME_LOTTO_MATCH_5')}}">
							<span class="input-group-addon">points</span>
						</div>
					</div>
					<div class="col-lg-2 form-group" style="padding:0px !important">
						<button type="submit" class="btn btn-info">Submit</button>
					</div>
				</form>

			</div>
		</div>
		<div class="clearfix"></div>

		<form role="form" method="get" action="{{url('game/lotto/setwinner')}}">
			{{csrf_field()}}
			<div class="panel panel-primary">
				<div class="panel-heading">Add a winner: <small>(winner will be removed automatically once reward
						dispatched)</small></div>
				<div class="panel-body">
					<div class="col-lg-8">
						<input name="email" class="form-control" placeholder="someone@email.tld">
					</div>
					<div class="col-lg-4">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<div class="col-lg-12" style="margin:20px 0px 10px 0px">
						@foreach($data['winners'] as $d)
						<span class="holder"><span class="emails">{{$d['email']}}</span><a class="emails-close"
								href="/game/lotto/delwinner?d={{$d['uid']}}">X</a></span>
						@endforeach
					</div>
				</div>
			</div>
		</form>


		<div class="panel panel-red">
			<div class="panel-heading"><b>Players who joined for the next round draw:</b></div>
			<div class="alert alert-info" style="margin:0px !important; padding:10px 20px !important">
			@if (\Session::has('userinfo'))
				{!! \Session::get('userinfo') !!}
			@else
				Click on a <b>User ID</b> to check the email address
			@endif
			</div>
			<div class="panel-body">
				@foreach($data['played'] as $p)
				<div class="col-lg-3 col-md-4">
					<p class="uids">
						<a href="/game/lotto/showemail?uid={{$p['id']}}">
							UID: {{$p['id']}} <br>Number: {{$p['number']}}
						</a>
					</p>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection