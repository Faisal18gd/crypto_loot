<?php use \App\Http\Controllers\AdminController;

?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Points withdrawal setup</h3>
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

	<div class="panel tabbed-panel panel-primary">
		<div style="padding:10px 0px 0px 10px; background-color:#428bca">
			<ul class="nav nav-tabs">
				<li><a href="/members/paysettings" style="color:#0f0">Payment Settings</a></li>
				<li><a href="/members/gcreward" style="color:#0f0">Tokens withdrawal</a></li>
				<li class="active" style="color:#000; font-weight:bold"><a>Points withdrawal</a></li>
			</ul>
		</div>
		<div class="panel-body">
			<div class="tab-content">

				<form role="form" method="post" action="{{url('admin/ngatewayc')}}" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="col-lg-12">
						<div class="panel panel-red">
							<div class="panel-heading">Points withdrawal option:</div>
							<div class="panel-body">

								<div class="form-group col-lg-12">
									<label>Item title:</label>
									<input name="name" class="form-control" placeholder="Paypal cash $10">
								</div>
								<div class="form-group col-lg-12">
									<textarea class="form-control" rows="3" name="descr"
										placeholder="Enter item description here. Basic HTML code allowed."></textarea>
								</div>
								<div class="form-group">
									<div class="col-lg-4">
										<label>Country ISO <span style="font-size:12px">(empty for all
												countries)</span>:</label>
										<input name="country" class="form-control" placeholder="US">
									</div>
									<div class="col-lg-4">
										<label>Points required</label>
										<div class="form-group input-group">
											<input name="points" class="form-control" placeholder="0000">
											<span class="input-group-addon">points</span>
										</div>
									</div>
									<div class="col-lg-4">
										<label>Gateway image:</label>
										<input name="image" type="file">
									</div>
									<div class="col-lg-12">
										<button type="submit" class="btn btn-danger">Create Gateway</button>
									</div>
								</div>

							</div>

						</div>
					</div>
				</form>

				@foreach($gateways as $gate)
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading">{{$gate->name}} <a title="Remove"
								href="/admin/delgateway?id={{$gate->id}}" style="color:#fff; float:right">X</a>
						</div>
						<div class="panel-body" align="center">
							<div class="col-lg-6">
								<img style="width:150px; height:150px" src="{{$gate->image_link}}" />
							</div>
							<div class="col-lg-6">
								{{$gate->descr}}
							</div>
						</div>
						<div class="panel-footer">Points: {{$gate->points}}<span
								style="float:right; color:green">Country: {{$gate->country}}</span></div>
					</div>
				</div>
				@endforeach


			</div>
		</div>
	</div>
</div>
@endsection