<?php use Carbon\Carbon; ?>
@extends('layouts.head')
@section('content')


<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">Activities History</h3>
    </div>
    <!-- /.col-lg-12 -->
  </div>
<div class="panel tabbed-panel panel-info">
	<div class="panel-heading clearfix">
		<ul class="nav nav-pills">
			<li class="active"><a>Earning History</a></li>
			<li><a href="{{url('/members/whistory')}}">Withdraw History</a></li>
		</ul>
	</div>
	<div class="tab-content" style="padding-top:10px">
				<div class="panel panel-default">
					<div class="panel-heading">System earnings: updates in every 10 minutes</div>
                    <div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
                                        <th>User ID</th>
										<th>Network</th>
                                        <th>Remarks</th>
                                        <th>IP Address</th>
										<th>Points</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach($ehists as $ehist)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$ehist->user_id}}</td>
										<td>{{$ehist->network}}</td>
										<td>{{$ehist->note}}</td>
										<td>{{$ehist->ip_address}}</td>
										<td>{{$ehist->amount}}</td>
										<td>{{$ehist->created_at}}</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="7" align="right">{!! $ehists->render() !!}</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
  
  
  
</div>
@endsection