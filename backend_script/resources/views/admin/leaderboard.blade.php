<?php use \App\Http\Controllers\AdminController;

?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Leaderboard</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>


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
    <div class="panel panel-green">
        <div class="panel-heading">Reward by rank: <small>(enter amount only)</small></div>
        <div class="panel-body">
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_1" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">1st rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_1')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_2" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">2nd rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_2')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_3" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">3rd rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_3')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_4" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">4th rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_4')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_5" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">5th rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_5')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_6" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">6th rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_6')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_7" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">7th rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_7')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_8" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">8th rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_8')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_9" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">9th rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_9')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <form role="form" method="get" action="{{url('config/setint')}}">
                {{csrf_field()}}
                <input type="hidden" name="max" value="9" />
                <input type="hidden" name="key" value="LWR_10" />
                <div class="col-lg-4" style="padding:0px 15px 0px 0px !important">
                    <div class="form-group input-group">
                        <span class="input-group-addon">10th rank</span>
                        <input name="value" class="form-control" placeholder="{{env('LWR_10')}}">
                        <span class="input-group-addon">points</span>
                    </div>
                </div>
                <div class="col-lg-2 form-group" style="padding:0px !important">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th colspan="6" style="background-color:#f00; color:#fff">Upcoming rank <small>(in
                                progress)</small>:</th>
                    </tr>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>User ID</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['today'] as $t)
                    <tr class="odd gradeX">
                        <td>{{$loop->iteration}}</td>
                        <td><a href="/admin/action?user={{$t->userid}}&type=info"
                                style="margin-right:10px; font-weight:bold">{{$t->name}}</a></td>
                        <td>{{$t->userid}}</td>
                        <td>{{$t->amount_cur}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th colspan="6" style="background-color:#00f; color:#fff">Yesterday's rank
                            <small>(delivered)</small>:</th>
                    </tr>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>User ID</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['yesterday'] as $y)
                    <tr class="odd gradeX">
                        <td>{{$loop->iteration}}</td>
                        <td><a href="/admin/action?user={{$y->userid}}&type=info"
                                style="margin-right:10px; font-weight:bold">{{$y->name}}</a></td>
                        <td>{{$y->userid}}</td>
                        <td>{{$y->amount_prv}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection