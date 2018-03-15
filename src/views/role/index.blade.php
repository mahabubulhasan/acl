@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/role">Role</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>

    @if($msg = session('msg'))
        <div class="alert alert-success" role="alert">{{ $msg }}</div>
    @endif

    <div class="card my-4">
        <div class="card-header col-12" >
            <div class="row">
                <h4 class="mr-auto pl-2">Role List</h4>
                <div class="pr-2">
                    <a class="btn btn-sm btn-primary" href="/role/create">Create New</a>
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
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index = row_serial_start($rows)?>
                    @forelse($rows as $r)
                        <tr>
                            <td>{{$index++}}.</td>
                            <td>{{ $r->name }}</td>
                            <td>
                                @if($r->name!=='Developer')
                                    <a class="btn btn-sm btn-primary" href="{{url('role/edit', [ 'id'=>$r->role_id ])}}">Edit</a>
                                    <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{url('/role/destroy',['id' => $r->role_id ])}}">Delete</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3">No data found!</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div>{!! $rows->render() !!}</div>
        </div>
    </div>
</div>
@endsection


