@extends('acl::layouts.acl')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/resource')}}">Resource</a></li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </nav>

        @if($msg = session('msg'))
            <div class="alert alert-success" role="alert">{{ $msg }}</div>
        @endif

        <div class="card my-4">
            <div class="card-header col-12">
                <div class="row">
                    <h4 class="mr-auto pl-2">Resource List</h4>
                    <div>
                        <form action="" method="get">
                            <div class="input-group pr-2">
                                <input type="text" name="q" value="{{old('q', request('q'))}}"
                                       class="form-control form-control-sm" placeholder="Search..."
                                       aria-label="Search..." aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">Find</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="pr-2">
                        <a class="btn btn-sm btn-primary" href="{{url('/resource/create')}}">Create New</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Controller</th>
                            <th>Action</th>
                            <th style="width:130px">Operation</th>
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
                                    <a class="btn btn-sm btn-primary"
                                       href="{{url('/resource/edit',['id' => $r->resource_id ])}}">Edit</a>
                                    <a class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete?')"
                                       href="{{url('/resource/destroy',['id' => $r->resource_id ])}}">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No data found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div>{!! $rows->render() !!}</div>
            </div>
        </div>
    </div>
@endsection