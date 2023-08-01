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
                            <b>Campaing Name</b>
                        </h5>
                        <small> &nbsp;Campaing</small>
                    </div>
                    <div class="card_body m-3">
                        @if(session()->has('success'))
                            <div class="btn btn-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form action="/Campaign_Name_update/{{$Campaign_Name->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                            <label for="exampleInputBorderWidth2">Campaing Name</label>
                            <input type="text" class="form-control" name="name" value = "{{$Campaign_Name->name}}" placeholder="Enter Host Name" required>
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
