@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/role">Role</a></li>
            <li class="breadcrumb-item active">Create Role</li>
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
            <h4>Create Role</h4>
        </div>
        <div class="card-body">
            <form role="form" method="POST" action="{{ url('/role/store') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Role name...">
                    </div>
                </div>

                @foreach($resources as $k=>$actions)
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">{{ $k }}</label>
                        <div class="col-sm-9">
                            @foreach($actions as $act)
                                <div class="checkbox">
                                    <label>
                                        <input name="resource[]" value="{{ $act['id'] }}" type="checkbox"> {{ $act['name'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="form-group row">
                    <div class="offset-sm-3 col-sm-9">
                        <button type="submit" class="btn btn-sm btn-primary">
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
