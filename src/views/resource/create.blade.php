@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/resource">Resource</a></li>
            <li class="active">Create New</li>
        </ol>
        <div class="col-md-8 col-md-offset-2">            
            <div class="panel panel-default">
                <div class="panel-heading">New Resource</div>
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

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/resource/store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                <p class="help-block">Example: Create Resource.</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Controller</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="controller" value="{{ old('controller') }}">
                                <p class="help-block">Example: Resource.</p>                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Action</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="action" value="{{ old('action') }}">
                                <p class="help-block">Example: App\Http\Controllers\ResourceController@create.</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
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
