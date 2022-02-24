<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">Admin profile</h3>
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

<form role="form" method="post" action="{{url('admin/aprof')}}">
{{csrf_field()}}
  <div class="col-lg-8">
    <div class="panel panel-yellow">
      <div class="panel-heading">Profile setup</div>
      <div class="panel-body">
		<div class="form-group">		
		<div class="col-lg-6">
			<label>Display name:</label><input name="name" type="text" class="form-control" placeholder="{{$admin->name}}"><br>
		</div>
		<div class="col-lg-6">
			<label>Email:</label><input name="email" type="email" class="form-control" placeholder="{{$admin->email}}"><br>
		</div>
		<div class="col-lg-6">
			<label>New Password:</label><input name="pass" type="password" class="form-control"><br>
		</div>
		<div class="col-lg-6">
			<label>Confirm new password:</label><input name="pass2" type="password" class="form-control"><br>
		</div>
		<div class="col-lg-12">
			<label>Current password:</label><input name="passc" type="password" class="form-control" required><br>
		</div>
		</div>
      </div>
      <div class="panel-footer">
		&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-warning">Update Profile</button>
		&nbsp;&nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
	</div>
    </div>
  </div>
  </form>

  <form role="form" method="post" action="{{url('admin/adminid')}}">
{{csrf_field()}}
  <div class="col-lg-8">
    <div class="panel panel-red">
      <div class="panel-heading">Transfer Admin rights</div>
      <div class="panel-body">
		<div class="form-group">	
		<div class="col-lg-5">
			<label>New Admin Email</label><input name="email" type="text" class="form-control" placeholder="email@domain.tld"><br>
		</div>
		<div class="col-lg-4">
			<label>Current password:</label><input name="passc" type="password" class="form-control" required><br>
		</div>
		<div class="col-lg-3">
			<button style="margin-top:25px; float:right" type="submit" class="btn btn-danger">Change Admin</button>
		</div>
		</div>
		</div>
      
    </div>
  </div>
  </form>
		
		

  </div>

@endsection
