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
                            <b> Add SMTP</b>
                        </h3>
                    </div>
                    <div class="card_body m-3">
                        @if(session()->has('success'))
                            <div class="btn btn-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form action="{{ route('regular_smtp.store')}}" method="post">
                            @csrf
                           



                            <label for="exampleInputBorderWidth2">Hostname</label>
                                <input class="form-control" type="text" name="host_name"  placeholder="Enter host name" required>

                                <label for="exampleInputBorderWidth2">Port</label>
                                <input class="form-control" name="imap_port" type="text"  placeholder="Enter smtp port" required>  

                                <label for="exampleInputBorderWidth2">EMAIL / UserName </label>
                                <input class="form-control" type="email" name="emails"  placeholder="Enter email Address" required>
                           
                                <label for="exampleInputBorderWidth2">Password</label>
                                <input class="form-control" type="password" name="email_pass" placeholder=" Password" required>

                                <label for="exampleInputBorder">From Email</label>
                                <input type="text" class="form-control" name="from_email"  placeholder="Enter from name" required>
                            {{-- <label for="exampleInputBorderWidth2">Smtp Sending Limit</label> --}}
                                <input class="form-control" name="limit" type="hidden" value="0" placeholder="Enter limit" required>
                            
                           
                            
                                

                            <button type="submit" class="btn btn-info btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="row">
        <!-- left column -->
          <div class="col-md-2"></div>
          <div class="col-md-8">
              <!-- general form elements -->
              <div class="card">
                  <div class="card-header">
                      <h5 class="card-title">
                          <b>Upload Smto by xlsx File</b>
                      </h5>
                     
                  </div>
                  <div class="card_body m-3">
                      <form action="{{ route('smtpimport')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <label for="exampleInputBorderWidth2"></label>
                      
                          <label for="exampleInputBorderWidth2">Emails</label>
                          <input class="form-control" type="file" name="file" requiered>
                          
                          @error('file')
                              <div class="text-danger">{{ $message }}</div>
                          @enderror
                          <button type="submit" class="btn btn-info btn-sm">Upload</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>
    </section>
 
@endsection