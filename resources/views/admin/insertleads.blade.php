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
                        <h3>Insert Leads</h3>
                            <div class="card-header">
                                <h3 class="card-title"><a class="btn btn-info" href="{{ route('insert_leads.create')}}">Create Insert Leads</a></h3>
                                <div class="text-right"><a class="btn btn-info" href="{{ route('mail_send')}}">Mail Send</a></div>
                            </div>

                            <div class="mail_delete text-right">
                                <div><a class="badge badge-danger btn-lg" onclick="return confirm('Do you want to delete?');" href="{{ route('mail_all.delete')}}"> All Delete</a></div>
                            </div>
                            <!-- /.card-header -->
                            @if(session()->has('danger'))
                                <div class="btn btn-danger">
                                    {{ session()->get('danger') }}
                                </div>
                            @endif
                            @if(session()->has('success'))
                                <div class="btn btn-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            
        
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($insert_leads as $key=>$lead)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                    
                                                <td>{{ $lead->emails }}</td> 
                                                <td>
                                                    @if($lead->status==0)
                                                        <span class="badge badge-info btn-lg">Send</span>
                                                    @else
                                                        <span  class="badge badge-danger btn-lg">Pending</span> 
                                                    @endif
                                                </td>
                                                <td><a onclick="return confirm('Do you want to delete?');" href="{{ route('mail.delete',$lead->id)}}" class="badge badge-danger">Delete</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                     
                                </table>
                                    {!! $insert_leads->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection