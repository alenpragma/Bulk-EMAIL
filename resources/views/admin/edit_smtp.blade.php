@extends('admin.layouts.master')
<style>
.card-header {
    padding: 0.35rem 1.25rem;
    }
</style>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header text-left">
                        <h3 class="card-title">
                            <b> Edit SMTP</b>
                        </h3>
                    </div>
                    <div class="card_body m-3">
                        @if(session()->has('success'))
                            <div class="btn btn-info">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form action="{{ route('smtp.update',$smtp->id)}}" method="post">
                            @csrf
                            <label for="exampleInputBorderWidth2">Hostname</label>
                            <input class="form-control" type="text" name="host_name"  value="{{ $smtp->host_name}}" requiered>

                            <label for="exampleInputBorderWidth2">Port</label>
                                <input class="form-control" name="imap_port" type="number" value="{{ $smtp->imap_port}}"  requiered>

                            <label for="exampleInputBorder">From Email</label>
                                <input type="text" class="form-control" name="from_email" value="{{ $smtp->from_email}}" requiered>
                            <label for="exampleInputBorderWidth2">EMAIL / UserName</label>
                                <input class="form-control" type="email" name="emails" value="{{ $smtp->emails}}" requiered>
                            <label for="exampleInputBorderWidth2">Password</label>
                                <input class="form-control" type="password" name="email_pass"  value="{{ $smtp->email_pass}}" requiered>
                            
                            
                            <label for="exampleInputBorderWidth2">Smtp Sending Limit</label>
                                <input class="form-control" name="limit" type="number"  value="{{ $smtp->limit}}" requiered>
                                <label for="exampleInputBorder"></label>
                                
                            <button type="submit" class="btn btn-info btn-sm">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection