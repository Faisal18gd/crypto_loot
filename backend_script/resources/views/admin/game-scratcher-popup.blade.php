<?php use \App\Http\Controllers\AdminController;

?>
@extends('layouts.head')
@section('content')
<script type="text/javascript">
    function sliderChange(val) {
        document.getElementById('seekbaroutput').innerHTML = val;
    }
</script>
<div id="page-wrapper">
    <div class="row" style="padding-top:60px;">
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
        <div class="alert alert-warning" style="text-align:center; font-weight:bold">Deleting this card will void user's
            purchase of this item without refund</div>
        <div class="modal-content" style="margin:auto; width:80%; background-color:#ccc">
            <div class="modal-header">
            <img style="height:30px; width:30px; margin-right:10px" src="{{$data->icon_image}}"/><b>Edit scratch card</b> (Item ID: {{$data->id}})
                <button type="button" class="close" onclick="location.href='/members/scratcher';">x</button>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="{{url('admin/updatescratchcard')}}"
                    enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input name="id" type="hidden" value="{{$data->id}}">
                    <div class="form-group">
                        <div class="col-lg-4">
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="font-weight:bold">Price:</span>
                                <input name="cost" class="form-control" placeholder="{{$data->cost}}"><br>
                                <span class="input-group-addon">token</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            @if ($data->free == 1)
                            <select class="form-control" name="free">
                                <option value=1 selected="selected">First card free </option>
                                <option value=0>Purchase only </option>
                            </select>
                            @else
                            <select class="form-control" name="free">
                                <option value=1>First card free </option>
                                <option value=0 selected="selected">Purchase only </option>
                            </select>
                            @endif
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group input-group">
                                <span class=" input-group-addon">Difficulty level:</span>
                                <input name="difficulty" class="form-control" oninput="sliderChange(this.value)"
                                    type="range" min="0" max="100" value="{{$data->difficulty}}" step="10"
                                    class="slider">
                                <span class="input-group-addon" style="font-weight:bold"><span
                                        id="seekbaroutput">{{$data->difficulty}}</span>%</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="font-weight:bold">$</span>
                                <input name="cash_reward" class="form-control" placeholder="{{$data->cash_win}}">
                                <span class="input-group-addon">Reward</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="font-weight:bold">Min reward:</span>
                                <input name="min_reward" class="form-control" placeholder="{{$data->min_win}}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="font-weight:bold">Max reward:</span>
                                <input name="max_reward" class="form-control" placeholder="{{$data->max_win}}">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <label>URL to open alongside when clicks on this card:</label>
                            <input name="link" class="form-control" placeholder="{{$data->link}}"><br>
                        </div>
                        <div class="col-lg-4">
                            <label>Background color:</label>
                            <input name="bgcolor" class="form-control" placeholder="{{$data->bgcolor}}">
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group input-group">
                                <span style="font-weight:bold">Card image:</span>
                                <input name="front_image" type="file">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group input-group">
                                <span style="font-weight:bold">Icon image:</span>
                                <input name="icon_image" type="file">
                            </div>
                        </div>
                        <div class="col-lg-12" style="border-top:1px solid #fff; padding-top:10px">
                            <button type="submit" class="btn btn-primary">Update scratcher item</button>
                            <button type="button" onclick="location.href='/members/scratcher';" class="btn btn-default"
                                style="width:120px; margin-left:10px">Cancel</button>
                            <button type="button" onclick="location.href='/admin/delscratchcard?id={{$data->id}}';"
                                class="btn btn-danger" style="width:120px; margin-left:10px">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection