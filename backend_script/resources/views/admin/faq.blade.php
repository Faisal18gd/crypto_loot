<?php use \App\Http\Controllers\AdminController;

?>
@extends('layouts.head')
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Customer Support</h4>
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
    <form role="form" method="get" action="{{url('admin/addfaq')}}">
        {{csrf_field()}}
        <div class="col-lg-12">
            <div class="panel panel-danger">
                <div class="panel-heading">Add FAQ:</div>
                <div class="panel-body">

                    <div class="form-group">
                        <div class="col-lg-6">
                            <label>Question:</label>
                            <input name="question" class="form-control" placeholder="This is a question..."><br>
                        </div>
                        <div class="col-lg-6">
                            <label>Answer:</label><input name="answer" class="form-control"
                                placeholder="This is an answer..."><br>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    &nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-danger">Add FAQ</button>
                    &nbsp;&nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
                </div>
            </div>
        </div>
    </form>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    @foreach($faqs as $faq)
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td><i class="text-danger">Question {{$loop->iteration}}:</i>
                                    {{$faq->question}}
                                    <a href="/admin/delfaq?id={{$faq->id}}"
                                        style="color:#000; float:right; text-decoration:none">X</a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="text-primary"> Answer:</i> {{$faq->answer}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                    <div style="height:10px"></div>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
@endsection