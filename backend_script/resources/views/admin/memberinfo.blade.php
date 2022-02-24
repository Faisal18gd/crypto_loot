<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')
<style>
	.nodec {
		margin-top: 20px;
		color: #000 !important;
		font-weight: bold !important;
		padding: 8px;
		background-color: #ccc;
		border: 1px solid #ccc;
		display: block;
		text-align: center
	}

	.nodec:hover {
		text-decoration: none
	}
</style>

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">User Management</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			@if (\Session::has('error'))
			<div class="alert alert-danger"> {{ \Session::get('error') }} </div>
			@elseif ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-green">
				<div class="panel-heading">User information</div>
				<div class="panel-body">
					<div class="col-lg-8">
						<div class="col-lg-4">
							<p style="padding:6px; background-color:#060; color:#fff">Total cash:
								{{$data['info']->c_balance}}</p>
						</div>
						<div class="col-lg-4">
							<p style="padding:6px; background-color:#060; color:#fff">Pending:
								{{$data['info']->c_pending}}</p>
						</div>
						<div class="col-lg-4">
							<p style="padding:6px; background-color:#060; color:#fff">Available:
								{{$data['info']->c_available}}</p>
						</div>
						<div class="col-lg-4">
							<p style="padding:6px; background-color:#06c; color:#fff">Total points:
								{{$data['info']->balance}}</p>
						</div>
						<div class="col-lg-4">
							<p style="padding:6px; background-color:#06c; color:#fff">Pending:
								{{$data['info']->pending}}</p>
						</div>
						<div class="col-lg-4">
							<p style="padding:6px; background-color:#06c; color:#fff">Available:
								{{$data['info']->available}}</p>
						</div>
						<div class="col-lg-6">
							<p style="padding:6px; background-color:#900; color:#fff">Referral earnings:
								{{$data['info']->ref_earn}}</p>
						</div>
						<div class="col-lg-6">
							<p style="padding:6px; border:1px solid #ccc"><b>User banned? :</b>
								{{$data['info']->banned == null ? 'No': $data['info']->banned}}</p>
						</div>
						<div class="col-lg-5">
							<p style="padding:4px; border:1px solid #ccc"><b>Name:</b> {{$data['info']->name}}
						</div>
						<div class="col-lg-7">
							<p style="padding:4px; border:1px solid #ccc"><b>Email:</b> {{$data['info']->email}}
						</div>
						<div class="col-lg-6">
							<p style="padding:4px; border:1px solid #ccc"><b>User / Ref ID:</b> {{$data['info']->refid}}
						</div>
						<div class="col-lg-6">
							<p style="padding:4px; border:1px solid #ccc"><b>Referred by:</b>
								{{$data['info']->referred_by}}
						</div>
						<div class="col-lg-12"><a class="nodec" href="/members/users"> BACK </a> </div>
					</div>
					<div class="col-lg-4">
						<p style="padding:4px; border:1px solid #ccc"><b>Country:</b>&nbsp;&nbsp;
							@php
							try {
							echo json_decode(file_get_contents("i2c.json"), true)[strtoupper($data['info']->country)];
							} catch (Exception $e) {
							echo 'None';
							}
							@endphp
						</p>
						<p style="padding:4px; border:1px solid #ccc"><b>Registered IP:</b>&nbsp;&nbsp;
							{{$data['info']->ip}}</p>
						@if($data['device'] != '0')
						{!! $data['device']->userinfo !!}
						@else
						No device information
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th colspan="6" style="background-color:#996">Tokens history:</th>
						</tr>
						<tr>
							<th>Remarks</th>
							<th>Network</th>
							<th>IP address</th>
							<th>Amount</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data['thistory'] as $h)
						<tr class="odd gradeX">
							<td>{{$h->note}}</td>
							<td>{{$h->network}}</td>
							<td>{{$h->ip_address}}</td>
							<td>{{$h->amount}}</td>
							<td>{{$h->created_at}}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5" align="right">{{ $data['thistory']->appends($_GET)->links() }}</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th colspan="3" style="background-color:#070; color:#fff">Points history:</th>
								</tr>
								<tr>
									<th>Remarks</th>
									<th>Amount</th>
									<th>Date / Time</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data['phistory'] as $gh)
								<tr class="odd gradeX">
									<td>{{$gh->note}}</td>
									<td>{{$gh->amount}}</td>
									<td>{{$gh->created_at}}</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5" align="right">{{ $data['phistory']->appends($_GET)->links() }}</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection