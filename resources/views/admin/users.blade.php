@if (auth()->user()->type==1)
@extends('admin.layouts.master')
<style>
.card-header {
    padding: 0.35rem 1.25rem;
    }
</style>
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <h3>User List</h3>
                                <div class="card-header">
                                    <h3 class="card-title"><a class="btn btn-success" href="{{ route('user_make')}}">Add User</a></h3>
                                    
                                    <div class="card-tools">
                                        

                                        {{-- <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                            <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- /.card-header -->
                                    @if(session()->has('danger'))
                                        <div class="btn btn-danger">
                                            {{ session()->get('danger') }}
                                        </div>
                                    @endif
                                    @if(session()->has('status'))
                                        <div class="btn btn-info">
                                            {{ session()->get('status') }}
                                        </div>
                                    @endif
                                <div class="card-body table-responsive p-0">
                            
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Limit</th>
                                                <th>Sender Group</th>
                                                <th>Action</th>
                                               
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key=>$user)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email  }}</td>
                                                    <td>******</td>
                                                    <td>{{ $user->limit  }}</td>
                                                    <td>{{ $user->sender_group  }}</td>
                                                    <td>
                                                   
                                                    <a href="{{ route('user_edit',$user->id) }}" class="badge badge-success btn-lg">Edit</a>
                                                        <a href="{{ route('delete_user',$user->id) }}"  class="badge badge-danger btn-lg" onclick="return confirm('Do you want to delete?');" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

@endsection
@endif