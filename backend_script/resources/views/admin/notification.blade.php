@extends('layouts.head')
@section('content')

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">Notification</h3>
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
@endif

@if (\Session::has('success'))
	<div class="alert alert-success">
    {{ \Session::get('success') }}
	</div>
@elseif (\Session::has('error'))
	<div class="alert alert-danger">
    {{ \Session::get('error') }}
	</div>
@endif
  <div class="row">
  <div class="col-lg-7">
  <div class="panel panel-green">
    <div class="panel-heading">Send push notification</div>
    <div class="panel-body">
      <form role="form" method="get" action="{{url('admin/snotif')}}">
	  {{csrf_field()}}
        <div class="form-group">
		<div class="form-group">
          <label>Message title</label>
          <input class="form-control" name="message_title" placeholder="Write a short title...">
		</div>
		<div class="row">
		<div class="col-lg-8">
		<div class="form-group">
              <label>Member's email:</label>
			  <input class="form-control" name="member_email" placeholder="example@domain.com">
			</div>
			  
			  </div>
			  <div class="col-lg-4">
			  <div class="form-group">
              <label>Sound:</label>
              <select class="form-control">
                <option>Default</option>
              </select>
			  </div>
			  </div>
			  </div>
			  
            <label>Message body:</label>
<textarea class="form-control" rows="3" name="message_body"></textarea>
            <div class="panel-footer">
			<button type="submit" class="btn btn-success">Send notification</button>
<button type="reset" class="btn btn-default">Reset</button>
			</div>
        </div>
      </form>
    </div>
  </div>
  </div>
  
  
  
  
  <div class="col-lg-5">
  
	@if (!$sett['GCM_KEY'])
	<div class="alert alert-info">
		Add Google Cloud Messaging key to send push notification.
	</div>
	@elseif ($sett['EARNING_NOTIFICATION']=='yes' && $sett['GCM_KEY'])
	<div class="alert alert-success">
		Notification on new earnings <b>turned on</b>. Whenever member complete a new task, system will send push notification with the amount that member earned.
	</div>
	@elseif ($sett['EARNING_NOTIFICATION']!='yes')
	<div class="alert alert-danger">
		Notification on new earnings <b>turned off</b>.
	</div>
	@endif		
  <div class="panel panel-primary">
    <div class="panel-heading">Notification settings</div>
    <div class="panel-body">
	<div class="form-group">
      <form role="form" method="get" action="{{url('admin/apsett')}}">
	  {{csrf_field()}}
        <div class="col-lg-12">
          <label>GCM Key</label>
          <input class="form-control" name="GCM_KEY" placeholder="{{$sett['GCM_KEY']}}"><br>
		</div>
		<div class="col-lg-7">
            <label>Earning notification:</label>
			<select class="form-control" name="EARNING_NOTIFICATION">
				<option value="yes">Enable</option>
				<option value="no">Disable</option>
			</select>
		</div>
		<div class="col-lg-5">
          <button style="float:right; margin-top:25px" type="submit" class="btn btn-info">Change settings</button>
		</div>
      </form>
	  </div>
    </div>
	<div style="height:20px"></div>
  </div>
  </div>
  
</div>

</div>

@endsection