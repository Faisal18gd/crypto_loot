<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')
<style>
	.btnd{width:100%; background-color:#eee; border:0px; padding:10px 0px 10px 0px; color:#666; text-align:center; font-size:12px; font-weight: bold;}
	.btnd:hover{text-decoration:none; cursor:pointer; font-size:13px; color:#666}
	.btna{width:100%; background-color:#d9534f; border:0px; padding:10px 0px 10px 0px; color:#fff; text-align:center; font-size:12px; font-weight: bold;}
	.btna:hover{text-decoration:none; cursor:pointer; font-size:13px; color:#fff}
</style>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">Fraud Prevention</h3>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  
<div class="row">
 @if (\Session::has('error'))
	<div class="alert alert-danger">
    {{ \Session::get('error') }}
	</div>
@elseif (\Session::has('success'))
	<div class="alert alert-success">
    {{ \Session::get('success') }}
	</div>
@endif
<div class="col-lg-8">
<div class="row">
	<div class="col-lg-4" style="padding:1px; margin-bottom:5px">
	<form role="form" method="get" action="{{url('admin/prevent')}}">
	{{csrf_field()}}
		<input name="cat" type="hidden" value="ROOT_BLOCK">
		@if (env('ROOT_BLOCK') == '1')
			<input name="prevent" type="hidden" value="0">
			<button type="submit" class="btna">Block Rooted Device</button>
		@else
			<input name="prevent" type="hidden" value="1">
			<button type="submit" class="btnd">Block Rooted Device</button>
		@endif
	</form>
	</div>
	<div class="col-lg-4" style="padding:1px; margin-bottom:5px">
	<form role="form" method="get" action="{{url('admin/prevent')}}">
	{{csrf_field()}}
		<input name="cat" type="hidden" value="VPN_BLOCK">
		<input name="cat2" type="hidden" value="SILENT_DETECT">
		@if (env('VPN_BLOCK') == '1')
			<input name="prevent" type="hidden" value="0">
			<input name="prevent2" type="hidden" value="1">
			<button type="submit" class="btna">Block VPN Traffic</button>
		@else
			<input name="prevent" type="hidden" value="1">
			<input name="prevent2" type="hidden" value="0">
			<button type="submit" class="btnd">Block VPN Traffic</button>
		@endif
	</form>
	</div>
	<div class="col-lg-4" style="padding:1px; margin-bottom:5px">
	<form role="form" method="get" action="{{url('admin/prevent')}}">
	{{csrf_field()}}
		<input name="cat" type="hidden" value="SINGLE_ACCOUNT">
		@if (env('SINGLE_ACCOUNT') == '1')
			<input name="prevent" type="hidden" value="0">
			<button type="submit" class="btna">Prevent Multi Account</button>
		@else
			<input name="prevent" type="hidden" value="1">
			<button type="submit" class="btnd">Prevent Multi Account</button>
		@endif
	</form>
	</div>
</div>
<div class="row" style="margin-top:15px">
<form role="form" method="get" action="{{url('admin/antifraud')}}">
{{csrf_field()}}
  <div class="panel panel-primary">
    <div class="panel-heading">Words are seperated by comma <span style="color:#cccccc; font-size:12px">(try to keep it short for faster loading)</span></div>
    <div class="panel-body">	
	<div class="form-group">
		<div class="col-lg-12">
			<textarea class="form-control" rows="5" name="signs">{{$fraud['fr']}}</textarea>
		</div>		
	</div>	
	</div>
    <div class="panel-footer">
		&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Submit</button>
	</div>
  </div>
</form>
</div>
</div>  
<div class="col-lg-4">
  <div class="alert alert-warning">
  <b>Note that:</b><br>
  <i>If you want to ban specific users, use member banning option from <a href="/members/users">User Management</a></i>
  </div>
  <div class="alert alert-warning">
	1) <span style="color:green">Words are seperated by comma (,)</span><br>
	2) <span style="color:green">Space between words are allowed</span><br>
	3) <span style="color:red">Do not use wildcard (*) option</span><br><br>
	
	Write only single or two words of specific <b>ID / MODEL / DISPLAY / FINGERPRINT / DEVICE TYPE / ANDROID VERSION / IMEI</b>.
	Any given word that matches with these types will be disabled.
  </div>
</div>
</div>

<div class="row">
	<div class-"col-lg-12">
	<form role="form" method="get" action="{{url('admin/prevent')}}">
	{{csrf_field()}}
		<input name="cat" type="hidden" value="SILENT_DETECT">
		<input name="cat2" type="hidden" value="VPN_BLOCK">
		@if (env('SILENT_DETECT') == '1')
			<input name="prevent" type="hidden" value="0">
			<input name="prevent2" type="hidden" value="1">
			<button type="submit" class="btna">Silent detection system of VPN users was enabled</button>
		@else
			<input name="prevent" type="hidden" value="1">
			<input name="prevent2" type="hidden" value="0">
			<button type="submit" class="btnd">Silent detection system of VPN users was disabled</button>
		@endif
	</form>
	</div>
	
	
	<div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Points</th>
                                                <th>Referred by</th>
												<th><center>VPN Attempt</center></td>
												<th><center>Action</center></td>
                                                <th><center>Action</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										@foreach($fraud['vpns'] as $user)
                                            <tr class="odd gradeX">
												<td>{{$user->name}}</td>
												<td>{{$user->email}}</td>
                                                <td>{{$user->balance}}</td>
                                                <td class="center">{{$user->referred_by}}</td>
												<td><center>{{$user->vpn}}</center></td>
												<td align="center">
													<form method="get" action="{{url('admin/ban')}}">
													{{csrf_field()}}
														<input name="clear" type="hidden" value="{{$user->email}}">
														<input name="userban" type="hidden" value="{{$user->email}}">
														<button type="submit" class="btn btn-success btn-xs">Clear</button>
													</form>
												</td>
												<td align="center">
													<form method="get" action="{{url('admin/ban')}}">
													{{csrf_field()}}
														<input name="userban" type="hidden" value="{{$user->email}}">
														<button type="submit" class="btn btn-danger btn-xs">Ban</button>
													</form>
												</td>
                                            </tr>
										@endforeach                                         
                                        </tbody>
										<tfoot>
											<tr>
												<td colspan="6" align="right">
												{!! $fraud['vpns']->render() !!}
												</td>
											</tr>
										</tfoot>
                                    </table>
                                </div>
	
	
	
</div>
  
  </div>
@endsection
