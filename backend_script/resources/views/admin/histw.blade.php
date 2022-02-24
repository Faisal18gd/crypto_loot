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
			<li><a href="/members/ehistory">Earning History</a></li>
			<li class="active"><a>Withdrawal History</a></li>
		</ul>
	</div>
		<div class="tab-content" style="padding-top:10px">
				<div class="panel panel-default">
					<div class="panel-heading">Withdrawals: updates in every 10 minutes</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
                                    <tr>
										<th>#</th>
										<th>User ID</th>
										<th>Currency</th>
										<th>Network</th>
										<th>Address</th>
										<th>Amount</th>
										<th>URL</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach($whists as $whist)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$whist->user}}</td>
										<td>{{$whist->currency}}</td>
										<td>{{$whist->network}}</td>
										<td>{{$whist->address}}</td>
										<td>{{$whist->points}}</td>
										<td>{{$whist->url}}</td>
										<td>{{Carbon::createFromTimestamp($whist->date)}}</td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="6" align="right">{!! $whists->render() !!}</td>
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