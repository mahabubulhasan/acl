@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/role">Role</a></li>
            <li class="active">Edit</li>
        </ol>
        <div class="col-md-8 col-md-offset-2">            
            <div class="panel panel-default">
                <div class="panel-heading">Edit Role</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/role/update', ['id' => $id]) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ ($old = old('name'))?$old:$role->name }}">
                            </div>
                        </div>
                        
                        @foreach($resources as $k=>$actions)
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ $k }}</label>
                            <div class="col-md-6">
                                @foreach($actions as $act)
                                <div class="checkbox">
                                    <label>
                                        <input name="resource[]" value="{{ $act['id'] }}" type="checkbox" {{ (in_array($act['id'], $permissions))?'checked="checked"':'' }}> {{ $act['name'] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
