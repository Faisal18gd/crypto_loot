<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')


<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">Terms of Service</h3>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  
 
 @if (\Session::has('error'))
	<div class="alert alert-danger">
    {{ \Session::get('error') }}
	</div>
@elseif (\Session::has('success'))
	<div class="alert alert-success">
    {{ \Session::get('success') }}
	</div>
@endif
<form role="form" method="get" action="{{url('admin/addtos')}}">
{{csrf_field()}}
<div class="col-lg-10">
  <div class="panel panel-primary">
    <div class="panel-heading">Add / Update TOS <span style="color:#cccccc; font-size:12px">(HTML code allowed)</span></div>
    <div class="panel-body">	
	<div class="form-group">
		<div class="col-lg-12">
			<textarea class="form-control" rows="15" name="tos">{{$terms}}</textarea>
		</div>		
	</div>	
	</div>
    <div class="panel-footer">
		&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Submit</button>
	</div>
  </div>
</div>
</form>
  
</div>

@endsection
