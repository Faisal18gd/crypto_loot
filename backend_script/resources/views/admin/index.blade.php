<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{AIndex::newmembers()}}</div>
                                        <div>New members</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users">
                                <div class="panel-footer">
                                    <span class="pull-left">Update in every 5 minutes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-usd fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{AIndex::newearnings()}}</div>
                                        <div>Earnings today</div>
                                    </div>
                                </div>
                            </div>
                            <a href="ehistory">
                                <div class="panel-footer">
                                    <span class="pull-left">Update in every 5 minutes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-usd fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{AIndex::totalearnings()}}</div>
                                        <div>Total earnings</div>
                                    </div>
                                </div>
                            </div>
                            <a href="ehistory">
                                <div class="panel-footer">
                                    <span class="pull-left">Update in every 1 hour</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{AIndex::totalmembers()}}</div>
                                        <div>Total members</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users">
                                <div class="panel-footer">
                                    <span class="pull-left">Update in every 20 minutes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
<!-- /.row -->

<div class="row">

<div class="col-lg-7">
@if ($data['wreq'])
<div class="alert alert-info alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
There are <a href="{{ url('/members/withdrawals')}}" class="alert-link"><b>{{ $data['wreq'] }}</b> withdrawal request(s)</a> pending.
</div>
@endif
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bar-chart-o fa-fw"></i> Users Online in past 24 hours <small>(5 mins interval)</small>:
		<a href="{{ url('/admin/resetonline')}}" style="float:right; font-size:11px; cursor:pointer; text-decoration:none">Reset Counter</a>
	</div>
	<div class="panel-body">
		<div id="pop-div"  style="height:350px"></div>
		{!! $data['online']->render('GeoChart', 'Popularity', 'pop-div') !!}
	</div>
</div>
</div>


<div class="col-lg-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-tasks fa-fw"></i> Latest earnings from networks 
								<span style="font-size:11px">(10 mins interval)</span>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="list-group">
								@foreach(AIndex::latestleads()['res'] as $lead)
                                    <p class="list-group-item">
                                        <i class="fa fa-money fa-fw"></i>
										<span class="text-primary">{{$lead['user']}}</span> brought <b style="color:green">${{$lead['payout']}}</b>
                                            <span class="pull-right text-muted small"><em>{{$lead['times']}}</em>
                                            </span>
                                    </p>
								@endforeach
                                </div>
                                <!-- /.list-group -->
                                <a href="{{ url('/members/ehistory')}}" class="btn btn-default btn-block">View details</a>
                            </div>
                            <!-- /.panel-body -->
</div>


</div>
</div>
</div>

@endsection