@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/resource">Resource</a></li>
            <li class="active">List</li>
        </ol>
        @if($msg = session('msg'))
        <div class="alert alert-success" role="alert">{{ $msg }}</div>
        @endif
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">Resource List</div>
                    <div class="pull-right"><a class="btn btn-xs btn-primary" href="/resource/create">Create New</a></div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Controller</th>
                                    <th>Action</th>
                                    <th style="width:100px">Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = row_serial_start($rows)?>
                                @forelse($rows as $r)
                                <tr>
                                    <td>{{$index++}}.</td>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->controller }}</td>
                                    <td>{{ $r->action }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{url('/resource/edit',['id' => $r->resource_id ])}}">Edit</a>
                                        <a class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{url('/resource/destroy',['id' => $r->resource_id ])}}">Del</a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5">No data found!</td></tr>
                                @endforelse                               
                            </tbody>
                        </table>
                    </div>
                    <div>{!! $rows->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection