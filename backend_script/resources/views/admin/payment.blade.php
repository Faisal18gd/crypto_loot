<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')


<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Payment setup</h3>
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
				<li class="active" style="color:#000; font-weight:bold"><a>Payment Settings</a></li>
				<li><a href="/members/gcreward" style="color:#0f0">Tokens withdrawal</a></li>
				<li><a href="/members/cashreward" style="color:#0f0">Points withdrawal</a></li>
			</ul>
		</div>
		<div class="panel-body">
			<div class="tab-content">
				<div class="row">
					<form role="form" method="get" action="{{url('admin/refsett')}}">
						{{csrf_field()}}
						<div class="col-lg-5">
							<div class="panel panel-primary">
								<div class="panel-heading">Referral system:</div>
								<div class="panel-body">
									<div class="form-group">
									<div class="col-lg-12">
											<label>Pay to referrer:</label>
											<div class="form-group input-group">
												<input name="REF_FIXED_AMOUNT" class="form-control"
													placeholder="{{$payset['REF_FIXED_AMOUNT']}}">
												<span class="input-group-addon">points</span>
											</div>
										</div>
										<div class="col-lg-12">
											<label>Pay who entered code:</label>
											<div class="form-group input-group">
												<input name="PAY_TO_ENTER_REF" class="form-control"
													placeholder="{{$payset['PAY_TO_ENTER_REF']}}">
												<span class="input-group-addon">points</span>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Change
										Settings</button>
								</div>
							</div>
						</div>
					</form>




					<form role="form" method="get" action="{{url('admin/payoutsett')}}">
						{{csrf_field()}}
						<div class="col-lg-7">
							<div class="panel panel-green">
								<div class="panel-heading">Payout settings:</div>
								<div class="panel-body">

									<div class="form-group">
										<div class="col-lg-6">
											<label>CPA 1 USD =</label>
											<div class="form-group input-group">
												<input name="CASHTOPTS" class="form-control"
													placeholder="{{$payset['CASHTOPTS']}}">
												<span class="input-group-addon">points</span>
											</div>
										</div>
										<div class="col-lg-6">
											<label>CPV 1 UNIT =</label>
											<div class="form-group input-group">
												<input class="form-control" placeholder="NETWORK EQUAL"
													disabled>
												<span class="input-group-addon">points</span>
											</div>
										</div>
										<div class="col-lg-4">
											<label>Payout:</label>
											<div class="form-group input-group">
												<input name="PAY_PCT" class="form-control"
													placeholder="{{$payset['PAY_PCT']}}">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-lg-8">
											<label>Min daily check-in (points):</label>
											<div class="form-group input-group col-lg-6"
												style="float:left; padding-right:10px">
												<span class="input-group-addon">Min</span>
												<input name="CHECK_IN_MIN" class="form-control"
													placeholder="{{$payset['CHECK_IN_MIN']}}">
											</div>
											<div class="form-group input-group col-lg-6"
												style="float:right; padding-left:10px">
												<span class="input-group-addon">Max</span>
												<input name="CHECK_IN_MAX" class="form-control"
													placeholder="{{$payset['CHECK_IN_MAX']}}">
											</div>
										</div>


									</div>
								</div>
								<div class="panel-footer">
									&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Change
										Settings</button>
									&nbsp;&nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection