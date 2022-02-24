<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Withdrawals</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Withdrawal requests:
            </div>
            @if (\Session::has('info'))
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{\Session::get('info')}}
            </div>
            @else
            <div class="alert alert-warning">
                If you need instant withdrawal option you can <a href="mailto:contact@mintservice.ltd">contact us</a>
                for custom quota.
            </div>
            @endif
            <!-- /.panel-heading -->
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
                                <th>Points</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wrequests as $wrqs)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <form method="get" action="{{url('admin/mailchk')}}">
                                        {{csrf_field()}}
                                        <input name="userid" type="hidden" value="{{$wrqs['user']}}">
                                        <button type="submit" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Click to get this member's email">{{$wrqs['user']}}</button>
                                    </form>
                                </td>
                                <td>{{$wrqs['currency']}}</td>
                                <td>{{$wrqs['network']}}</td>
                                <td>{{$wrqs['address']}}</td>
                                <td>{{$wrqs['points']}}</td>
                                <td>
                                    <form method="get" action="{{url('admin/wprocessed')}}">
                                        {{csrf_field()}}
                                        <input name="id" type="hidden" value="{{$wrqs['id']}}">
                                        <input name="userid" type="hidden" value="{{$wrqs['user']}}">
                                        <input name="amount" type="hidden" value="{{$wrqs['points']}}">
                                        <button type="submit" class="btn btn-primary btn-xs">Mark Processed</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" align="right">
                                    {!! $wrequests->render() !!}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>

</div>
@endsection