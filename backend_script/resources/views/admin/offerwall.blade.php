<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')
<style>
	.padd {
		padding: 5px
	}

	.ofgrid:hover {
		cursor: pointer
	}

	.ofgrid {
		height: 80px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		text-transform: uppercase;
		font-size: 25px;
		margin-bottom: 10px
	}

	.voff {
		padding-top: 5px;
		padding-bottom: 5px;
		padding-left: 50px;
		color: #fff;
		text-align: center
	}

	.voff:hover {
		cursor: pointer
	}
</style>


<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Offerwall setup</h3>
		</div>
	</div>
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div><br />
	@endif

	@if (\Session::has('success'))
	<div class="alert alert-success">
		{{ \Session::get('success') }}
	</div>
	@elseif (\Session::has('error'))
	<div class="alert alert-danger">
		{{ \Session::get('error') }}
	</div>
	@endif
	<div class="panel panel-info">
		<div class="panel-heading">
			<img src="{{$data['fyber']['img']}}" style="height:30px; margin:7px" alt="Fyber" />
		</div>
		<div class="panel-body">
			<form role="form" method="get" action="{{url('admin/updateapi')}}">
				{{csrf_field()}}
				<input name="offerwall" type="hidden" value="{{$data['fyber']['offerwall']}}">
				<div class="panel-body">
					<div class="col-lg-12" style="margin-bottom:20px">
						<div style="font-size:15px; background:#ccc; padding:10px; border-radius:3px">
							<div style="margin-bottom:10px;text-align:center; background-color:#eee; font-weight:bold">POSTBACK URL</div>
							{!!$data['fyber']['postback']!!}
						</div>
					</div>
					<div class="col-lg-9">
						<div class="form-group input-group">
							<span class="input-group-addon" style="font-weight:bold">URL secret:</span>
							<input name="secretname" type="hidden" value="{{$data['fyber']['secretname']}}">
							<input name="secret" class="form-control" value="{{$data['fyber']['secret']}}">
						</div>
					</div>
					<div class="col-lg-3">
						<button type="submit" class="btn btn-primary"
							style="width:120px; margin-right:20px">Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="panel panel-danger">
		<div class="panel-heading">
			{{$data['pollfish']['img']}}
		</div>
		<div class="panel-body">
			<form role="form" method="get" action="{{url('admin/updateapi')}}">
				{{csrf_field()}}
				<input name="offerwall" type="hidden" value="{{$data['pollfish']['offerwall']}}">
				<div class="panel-body">
					<div class="col-lg-12" style="margin-bottom:20px">
						<div style="font-size:15px; background:#ccc; padding:10px; border-radius:3px">
							<div style="margin-bottom:10px;text-align:center; background-color:#eee; font-weight:bold">POSTBACK URL</div>
							{!!$data['pollfish']['postback']!!}
						</div>
					</div>
					<div class="col-lg-9">
						<div class="form-group input-group">
							<span class="input-group-addon" style="font-weight:bold">URL secret:</span>
							<input name="secretname" type="hidden" value="{{$data['pollfish']['secretname']}}">
							<input name="secret" class="form-control" value="{{$data['pollfish']['secret']}}">
						</div>
					</div>
					<div class="col-lg-3">
						<button type="submit" class="btn btn-primary"
							style="width:120px; margin-right:20px">Update</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
@endsection