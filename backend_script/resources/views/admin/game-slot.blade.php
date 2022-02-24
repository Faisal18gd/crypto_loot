<?php use Carbon\Carbon; ?>
@extends('layouts.head')
@section('content')
<style>
	.holder {
		line-height: 35px;
		padding: 5px
	}

	.emails {
		padding: 5px 10px;
		border-radius: 3px 0px 0px 3px;
		background: #ccc
	}

	.uids {
		border-radius: 3px 0px 0px 3px;
		background: #ccc;
		padding: 5px 10px;
		margin:5px !important
	}
	.uids a {
		text-decoration: none;
		font-weight: bold;
	}
	.uids a:hover {
		text-decoration: none;
		cursor: pointer
	}

	.emails-close {
		cursor: pointer;
		padding: 5px 10px;
		border-radius: 0px 3px 3px 0px;
		background: #07c;
		color: #fff
	}
</style>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Slot Game Setup</h3>
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
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="3" />
						<input type="hidden" name="key" value="MAX_FREE_SPIN" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Max free spin:</span>
								<input name="value" class="form-control" placeholder="{{env('MAX_FREE_SPIN')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="3" />
						<input type="hidden" name="key" value="FREE_SPIN_MINS" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Free spin per:</span>
								<input name="value" class="form-control" placeholder="{{env('FREE_SPIN_MINS')}}">
								<span class="input-group-addon">mins</span>
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="5" />
						<input type="hidden" name="key" value="SPIN_COST" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Spin cost:</span>
								<input name="value" class="form-control" placeholder="{{env('SPIN_COST')}}">
								<span class="input-group-addon">tokens</span>
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="SPEED_START" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Start speed:</span>
								<input name="value" class="form-control" placeholder="{{env('SPEED_START')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="SPEED_NORMAL" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Normal speed:</span>
								<input name="value" class="form-control" placeholder="{{env('SPEED_NORMAL')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="SPEED_DELAY" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">Delay:</span>
								<input name="value" class="form-control" placeholder="{{env('SPEED_DELAY')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important; margin-top:40px">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="MATCH_3" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">3 matches:</span>
								<input name="value" class="form-control" placeholder="{{env('MATCH_3')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="MATCH_4" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">4 matches:</span>
								<input name="value" class="form-control" placeholder="{{env('MATCH_4')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="MATCH_5" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">5 matches:</span>
								<input name="value" class="form-control" placeholder="{{env('MATCH_5')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_1" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">1st item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_1')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_2" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">2nd item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_2')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_3" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">3rd item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_3')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_4" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">4th item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_4')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_5" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">5th item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_5')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_6" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">6th item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_6')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_7" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">7th item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_7')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12" style="padding:0px !important">
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_8" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">8th item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_8')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<form role="form" method="get" action="{{url('config/setint')}}">
						{{csrf_field()}}
						<input type="hidden" name="max" value="4" />
						<input type="hidden" name="key" value="ITEM_VALUE_9" />
						<div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
							<div class="form-group input-group">
								<span class="input-group-addon">9th item:</span>
								<input name="value" class="form-control" placeholder="{{env('ITEM_VALUE_9')}}">
							</div>
						</div>
						<div class="col-lg-2 form-group" style="padding:0px !important">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection