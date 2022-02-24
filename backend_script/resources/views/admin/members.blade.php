<?php use \App\Http\Controllers\AdminController; ?>
@extends('layouts.head')
@section('content')


<div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
					
					
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                User Management
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
							@if (\Session::has('error'))
								<div class="alert alert-danger">
									{{ \Session::get('error') }}
								</div>
							@elseif ($errors->any())
								<div class="alert alert-danger">
									<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
									</ul>
								</div>
							@endif
							<form role="form" method="get" action="{{url('admin/smemb')}}">
								{{csrf_field()}}
								<div class="col-lg-9"><input class="form-control" name="email_search" placeholder="Search by email or User ID..."></div>
								<div class="col-lg-3"><button type="submit" class="btn btn-default">Get User</button></div>										
							</form><br><br><br>
							
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Points</th>
                                                <th>Referred by</th>
												<th><center>Reward</center></td>
                                                <th><center>Banned</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										@foreach($users as $user)
                                            <tr class="odd gradeX">
												<td><a href="/admin/action?user={{$user->refid}}&type=info" style="margin-right:10px; font-weight:bold">{{$user->name}}</a></td>
												<td>{{$user->email}}</td>
                                                <td>{{$user->balance}}</td>
                                                <td class="center">{{$user->referred_by}}</td>
												<td><center><a href="/admin/action?user={{$user->refid}}&type=reward" style="color:green; margin-right:10px"><i class="fa fa-plus-square fa-fw"></i></a> <a href="/admin/action?user={{$user->refid}}&type=penalty" style="color:red"><i class="fa fa-minus-square danger fa-fw"></i></a></center></td>
												<td align="center">
													<form method="get" action="{{url('admin/ban')}}">
													{{csrf_field()}}
														<input name="userban" type="hidden" value="{{$user->email}}">
														<button type="submit" class="btn btn-primary btn-xs">{{$user->banned}}</button>
													</form>
												</td>
                                            </tr>
										@endforeach                                         
                                        </tbody>
										<tfoot>
											<tr>
												<td colspan="6" align="right">
												{!! $users->render() !!}
												</td>
											</tr>
										</tfoot>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                
</div>
                            <!-- /.panel-body -->
                        </div>

</div>

</div></div>


@endsection