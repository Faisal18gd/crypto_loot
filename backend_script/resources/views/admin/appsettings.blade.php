<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Site settings <span style="font-size:13px">[ <a style="text-decoration:none" href="{{url('admin/rcache')}}">Remove
						All Cache</a> ]</span></h3>
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
	@elseif (\Session::has('error'))
	<div class="alert alert-danger">
		{{ \Session::get('error') }}
	</div>
	@elseif (\Session::has('success'))
	<div class="alert alert-success">
		{{ \Session::get('success') }}
	</div>
	@endif
	<form role="form" method="get" action="{{url('admin/apsett')}}">
		{{csrf_field()}}
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Website settings:</span></div>
				<div class="panel-body">

					<div class="form-group">
						<div class="col-lg-3">
							<label>App Name</label><input name="APP_NAME" class="form-control" placeholder="{{$configs['sites']['APP_NAME']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Website URL</label><input name="APP_URL" class="form-control" placeholder="{{$configs['sites']['APP_URL']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Timezone</label><input name="TIMEZONE" class="form-control" placeholder="{{$configs['sites']['TIMEZONE']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Database Name</label><input name="DB_DATABASE" class="form-control" placeholder="{{$configs['sites']['DB_DATABASE']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Database Host</label><input name="DB_HOST" class="form-control" placeholder="{{$configs['sites']['DB_HOST']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Database Port</label><input name="DB_PORT" class="form-control" placeholder="{{$configs['sites']['DB_PORT']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Database Password</label><input name="DB_PASSWORD" type="password" class="form-control" placeholder="password"><br>
						</div>
						<div class="col-lg-3">
							<label>App-to-Backend Secret</label><input name="JWT_SECRET" class="form-control" placeholder="{{$configs['sites']['JWT_SECRET']}}"><br>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Change Settings</button>
					&nbsp;&nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
	</form>

	<form role="form" method="get" action="{{url('admin/apsett')}}">
		{{csrf_field()}}
		<div class="col-lg-12">
			<div class="panel panel-red">
				<div class="panel-heading">Mail setup:</div>
				<div class="panel-body">

					<div class="form-group">
						<div class="col-lg-3">
							<label>Mail Driver</label><input name="MAIL_DRIVER" class="form-control" placeholder="{{$configs['mails']['MAIL_DRIVER']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Mail Host</label><input name="MAIL_HOST" class="form-control" placeholder="{{$configs['mails']['MAIL_HOST']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Mail Port</label><input name="MAIL_PORT" class="form-control" placeholder="{{$configs['mails']['MAIL_PORT']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Username</label><input name="MAIL_USERNAME" class="form-control" placeholder="{{$configs['mails']['MAIL_USERNAME']}}"><br>
						</div>
						<div class="col-lg-3">
							<label>Password</label><input name="MAIL_PASSWORD" class="form-control" placeholder="mail password"><br>
						</div>
						<div class="col-lg-3">
							<label>Mail Encryption</label><input name="MAIL_ENCRYPTION" class="form-control" placeholder="{{$configs['mails']['MAIL_ENCRYPTION']}}"><br>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-danger">Change Settings</button>
					&nbsp;&nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</div>
	</form>


</div>
@endsection