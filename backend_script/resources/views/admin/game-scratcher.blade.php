<?php use Carbon\Carbon;

?>
@extends('layouts.head')
@section('content')
<style>
	.numspan {
		border-radius: 3px 0px 0px 3px;
		background-color: #f00;
		padding: 5px 10px;
		color: #fff;
		line-height: 40px
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

	.lvl {
		border: 1px solid #ccc;
		padding: 8px !important;
		display: block;
		margin: 5px 0px;
		border-radius: 4px;
		cursor: pointer;
		text-align: center
	}

	.lvl:hover {
		text-decoration: none;
		background-color: #f00;
		color: #fff
	}

	.item_text_bg {
		background-color: #ccc;
		padding: 5px;
		border: 2px solid #fff;
		border-radius: 3px
	}

	.editbtn {
		float: right;
		cursor: pointer;
		background-color: rgba(0, 0, 0, 0.2);
		padding: 0px 10px;
		border-radius: 3px;
		color: #fff;
		line-height: 30px
	}

	.editbtn:hover {
		text-decoration: none;
		color: #fff;
		font-weight: bold
	}

	.imageview {
		max-height: 200px;
		max-width: 300px;
		height: auto;
		width: auto
	}
	.iconimage{
		height: 30px;
		width: 30px;
		margin-right:10px
	}
</style>
<script type="text/javascript">
	function sliderChange(val) {
		document.getElementById('seekbaroutput').innerHTML = val;
	}
</script>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Scratcher game setup</h3>
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

		<div class="panel panel-info">
			<div class="panel-heading" style="text-align:center">Winner will be removed automatically from this list
				after
				dispatching the reward.</div>
			<div class="panel-body">
				<form role="form" method="get" action="{{url('game/scratcher/setwinner')}}">
					{{csrf_field()}}
					<div class="col-lg-10 col-md-10" style="padding:0px 15px 0px 0px !important">
						<div class="form-group input-group">
							<span class="input-group-addon" style="color:#000; font-weight:bold">Add a winner:</span>
							<input name="email" class="form-control" placeholder="someone@email.tld"><br>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 form-group" style="padding:0px !important">
						<button type="submit" class="btn btn-primary">Add to list</button>
					</div>
				</form>
				@foreach($data['winner'] as $d)
				<span class="numspan">{{$d['email']}}</span><a class="numa"
					href="/game/scratcher/delwinner?d={{$d['uid']}}">X</a>
				@endforeach
			</div>
		</div>



		<div class="panel panel-primary">
			<div class="panel-heading">Add scratch item</div>
			<div class="panel-body">
				<form role="form" method="post" action="{{url('admin/addscratchcard')}}" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<div class="col-lg-4">
							<div class="form-group input-group">
								<span class="input-group-addon" style="font-weight:bold">Price:</span>
								<input name="cost" class="form-control" placeholder="1000"><br>
								<span class="input-group-addon">token</span>
							</div>
						</div>
						<div class="col-lg-3">
							<select class="form-control" name="free">
								<option value=1>First card free </option>
								<option value=0>Purchase only </option>
							</select>
						</div>
						<div class="col-lg-5">
							<div class="form-group input-group">
								<span class=" input-group-addon">Difficulty level:</span>
								<input name="difficulty" class="form-control" oninput="sliderChange(this.value)"
									type="range" min="0" max="100" value="50" step="10" class="slider">
								<span class="input-group-addon" style="font-weight:bold"><span
										id="seekbaroutput">50</span>%</span>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group input-group">
								<span class="input-group-addon" style="font-weight:bold">Winner</span>
								<input name="cash_reward" class="form-control" placeholder="1"><br>
								<span class="input-group-addon">points</span>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group input-group">
								<span class="input-group-addon" style="font-weight:bold">Min reward:</span>
								<input name="min_reward" class="form-control" placeholder="10"><br>
								<span class="input-group-addon">tokens</span>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group input-group">
								<span class="input-group-addon" style="font-weight:bold">Max reward:</span>
								<input name="max_reward" class="form-control" placeholder="100"><br>
								<span class="input-group-addon">tokens</span>
							</div>
						</div>
						<div class="col-lg-8">
							<label>URL to open alongside when clicks on this card:</label>
							<input name="link" class="form-control" placeholder="https://mintservice.ltd"><br>
						</div>
						<div class="col-lg-4">
							<label>Background color:</label>
							<input name="bgcolor" class="form-control" placeholder="#1493ff"><br>
						</div>
						<div class="col-lg-4">
							<div class="form-group input-group">
								<span style="font-weight:bold">Card image:</span>
								<input name="front_image" type="file">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group input-group">
								<span style="font-weight:bold">Icon image:</span>
								<input name="icon_image" type="file">
							</div>
						</div>
						<div class="col-lg-4" style="text-align:center; margin-top:5px">
							<button type="submit" class="btn btn-primary">Add scratcher item</button>
						</div>
					</div>
				</form>
			</div>
		</div>


		@foreach($data['game'] as $g)
		<div class="col-lg-6">
			<div class="panel" style="background-color:#fff; border-color:{{$g->bgcolor}}">
				<div class="panel-heading" style="background-color:{{$g->bgcolor}}; color:#ccc">
					<img class="iconimage" src="{{$g->icon_image}}"/><b>Item ID:</b> {{$g->id}} @if ($g->free == 1) &nbsp; >>first card is free<< @endif <a
						class="editbtn" href="/admin/editscratchcard?id={{$g->id}}">EDIT</a>
				</div>
				<div class="panel-body">
					<div style="text-align:center"><img class="imageview" src="{{$g->front_image}}" /></div>
					<div class="item_text_bg" style="margin-top:10px"><b>Difficulty:</b> {{$g->difficulty}}%</div>
					<div class="item_text_bg"><b>Cost:</b> {{$g->cost}} tokens</div>
					<div class="item_text_bg"><b>Points reward:</b> {{$g->cash_win}}</div>
					<div class="item_text_bg"><b>Min token reward:</b> {{$g->min_win}}</div>
					<div class="item_text_bg"><b>Max token reward:</b> {{$g->max_win}}</div>
				</div>
			</div>
		</div>
		@endforeach


	</div>
</div>
@endsection