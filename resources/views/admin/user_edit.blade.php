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
                            <b> Edit User</b>
                        </h3>
                    </div>
                    <div class="card_body m-3">
                        <form action="/user_edit_post/{{$user_edit->id}}" method="post">
                            @csrf
                            <label for="exampleInputBorder">Name</label>
                                <input type="text" class="form-control" value="{{ $user_edit->name }}" name="name" placeholder="Enter Name" required>
                            <label for="exampleInputBorderWidth2"> Email Address</label>
                                <input class="form-control" type="email" value="{{ $user_edit->email }}" name="email" placeholder="Enter Email Address" required>
                           

                                <label for="exampleInputBorder">Sender Group</label>
                                
                                    <select class="custom-select mr-sm-2" name="sender_group">
                       
                                    <option value="100k" {{$user_edit->sender_group == '100k' ? 'selected' : ''}}>100k</option>
                                    <option value="200k" {{$user_edit->sender_group == '200k' ? 'selected' : ''}}>200k</option>
                                    <option value="300k" {{$user_edit->sender_group == '300k' ? 'selected' : ''}}>300k</option>
                                    </select>

                                <label for="exampleInputBorder">Limit</label>
                                <input type="text" class="form-control" value="{{ $user_edit->limit }}" name="limit" placeholder="Enter Name" required>
                                
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