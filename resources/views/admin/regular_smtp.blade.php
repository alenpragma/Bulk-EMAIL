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
                            <h3>SMTP List</h3>
                                <div class="card-header">
                                    <h3 class="card-title"><a class="btn btn-success" href="{{ route('regular_smtp.create')}}">Add SMTP</a></h3>
                                    
                                    <div class="card-tools">
                                        <h3 class="card-title"><a class="btn btn-success" href="/smtpdownload">Download All Smtp</a></h3>

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
                             <div class="mail_delete text-right">
                                <div><a class="badge badge-danger btn-lg" onclick="return confirm('Do you want to delete?');" href="{{ route('deleteallSmtp')}}">Delete All Smtp</a></div>
                                <form action="{{ route('updateLimit') }}" method="POST">
                                    @csrf
                                    <label for="limit">Set Sent Count:</label>
                                    <input type="number" name="limit" id="limit">
                                    <button type="submit">Update</button>
                                </form>
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
                                                <th>Hostname</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>From Email</th>
                                                <th>Sent</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                               
                                        </thead>
                                        <tbody>
                                            @foreach ($smtps as $key=>$smtp)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $smtp->host_name }}</td>
                                                    <td>{{ $smtp->emails }}</td>
                                                    <td>********</td>
                                                       
                                                    <td>{{ $smtp->from_email }}</td> 
                                                    <td>{{ $smtp->limit }}</td>      
                                                    <td>
                                                        @if($smtp->status==1)
                                                            <a href="{{ route('status',$smtp->id)}}" class="badge badge-success btn-lg">Active</a>
                                                        @else
                                                          <a href="{{ route('status',$smtp->id)}}" class="badge badge-danger btn-lg">InActive</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                   <a href="{{ route('smtp.testSmtp',$smtp->id) }}" class="badge badge-warning">Test SMTP</a>   
                                                    <a href="{{ route('smtp.edit',$smtp->id) }}" class="badge badge-success btn-lg">Edit</a>
                                                        <a href="{{ route('smtp.delete',$smtp->id) }}"  class="badge badge-danger btn-lg" onclick="return confirm('Do you want to delete?');" class="btn btn-danger btn-sm">Delete</a>
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