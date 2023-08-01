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
                        <h5 class="card-title">
                            <b>Insert Email Leads</b>
                        </h5>
                        <small> &nbsp;Insert Manually Leads by Input Form (1 Lead For Test) </small>
                    </div>
                    <div class="card_body m-3">
                        @if(session()->has('success'))
                            <div class="btn btn-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form action="{{ route('insert_lead.store')}}" method="post">
                            @csrf
                            <label for="exampleInputBorderWidth2"></label>
                                <input class="form-control" name="campaign" type="hidden" value="1"  required> 
                            <label for="exampleInputBorderWidth2">Emails</label>
                            <textarea type="text" class="form-control" name="emails" style="height: 100px" placeholder="Place List with comma separator"></textarea>
                            @error('emails')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-info btn-sm">Save</button>
                        </form>
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
                            <b>Insert Email Leads by Text File</b>
                        </h5>
                        <small> &nbsp;Insert Leads by Text file pls use enter (line break only)</small>
                    </div>
                    <div class="card_body m-3">
                        <form action="{{ route('insert_lead.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="exampleInputBorderWidth2"></label>
                        <input class="form-control" name="campaign" type="hidden" value="1"  required> 
                            <label for="exampleInputBorderWidth2">Emails</label>
                            <input class="form-control" type="file" name="txt_emails" requiered>
                            
                            @error('txt_emails')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-info btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection