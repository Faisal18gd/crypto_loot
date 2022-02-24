<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">URL Add <span style="font-size:13px"></span></h3>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<form role="form" method="get" action="{{url('admin/url')}}">
		{{csrf_field()}}
        
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">URL Address:</span></div>
				<div class="panel-body">

					<div class="form-group">
						<div class="col-lg-12">
							<label>URL</label><input name="url" class="form-control" placeholder="enter url"><br>
						</div>
                        <input type="hidden" name="get_id" value="{{$uid->id}}">
					</div>
				</div>
				<div class="panel-footer">
					&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection