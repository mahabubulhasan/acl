@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/role">Role</a></li>
            <li class="breadcrumb-item active">Edit Role</li>
        </ol>
    </nav>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card">
        <div class="card-header">
            <h4>Edit Role</h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/role/update', ['id' => $id]) }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="Role name..." name="name" value="{{ ($old = old('name'))?$old:$role->name }}">
                    </div>
                </div>

                @foreach($resources as $k=>$actions)
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">{{ $k }}</label>
                        <div class="col-sm-9">
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

                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
