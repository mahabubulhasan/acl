@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/resource')}}">Resource</a></li>
            <li class="breadcrumb-item active">Create New</li>
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
            <h4>New Resource</h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/resource/store') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group row">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        <small class="form-text text-muted">Example: Create Resource.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label">Controller</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="controller" value="{{ old('controller') }}" required>
                        <small class="form-text text-muted">Example: Resource.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label">Action</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="action" value="{{ old('action') }}" required>
                        <small class="form-text text-muted">Example: App\Http\Controllers\ResourceController@create.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-10 offset-md-2">
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection