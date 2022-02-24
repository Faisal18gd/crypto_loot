<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h4 class="page-header">MintReward to {{env('APP_NAME')}} update checker:</h4>
    </div>
    <div class="col-lg-12"><b>Current App version: {{$data['app']}}</b><br>{!! $data['new_app'] !!}</div>
    @if(isset($data['new_app_ver']))
    <form role="form" method="get" action="{{url('config/setint')}}">
      {{csrf_field()}}
      <input type="hidden" name="max" value="4" />
      <input type="hidden" name="numeric" value="true" />
      <input type="hidden" name="key" value="APP_VER" />
      <input type="hidden" name="value" value="{{$data['new_app_ver']}}" />
      <div class="col-lg-12" style="margin-top:10px"><button type="submit" class="btn btn-success">I have received the latest App source code</button></div>
    </form>
    @endif
    <div class="col-lg-12" style="margin-top:20px"><b>Current Backend version: {{$data['backend']}}</b><br>{!!
      $data['new_backend'] !!}</div>
  </div>

  <div class="row" style="margin-top:50px">
    <div class="col-lg-12">
      <h4 class="page-header">{{env('APP_NAME')}} to your App:</h4>
    </div>
    @if (\Session::has('error'))
    <div class="alert alert-danger">
      {{ \Session::get('error') }}
    </div>
    @elseif (\Session::has('success'))
    <div class="alert alert-success">
      {{ \Session::get('success') }}
    </div>
    @endif

    <form role="form" method="get" action="{{url('admin/updateclientapp')}}">
      {{csrf_field()}}
      <div class="col-lg-12">
        <div class="col-lg-6">
          <div class="form-group input-group">
            <label>Latest version code of your app from PlayStore:</label><br>
            <input style="display:block; margin-bottom:10px" name="value" class="form-control" placeholder="{{$data['client_app']}}">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </div>
    </form>

    <form role="form" method="get" action="{{url('admin/clientupdateforce')}}">
      {{csrf_field()}}
      <div class="col-lg-12">
        <div class="col-lg-6">
          <label>Update delivery type:</label><br>
          <select style="display:block; margin-bottom:10px" class="form-control" name="value">
            @if($data['app_force_update'] == 1)
            <option value="0">Optional update</option>
            <option value="1" selected="selected">Compulsory update</option>
            @else
            <option value="0" selected="selected">Optional update</option>
            <option value="1">Compulsory update</option>
            @endif
          </select>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>


  <div class="col-lg-12" style="margin-top:40px">
    <div class="row">
      <b style="color:#0f0">Optional update:</b> Users will be notified to update their outdated app version but it
      won't block the service. Users can ignore this notification.
      <br><br>
      <b style="color:#f00">Compulsory update:</b> Users will be forced to update the app with the version code that
      you added in latest version code input field. User cannot avail your service by the app which is lower than
      mentioned version code.
    </div>
  </div>

</div>
@endsection