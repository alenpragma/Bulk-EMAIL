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
                            <b> Add User</b>
                        </h3>
                    </div>
                    <div class="card_body m-3">
                        <form action="user_post" method="post">
                            @csrf
                            <label for="exampleInputBorder">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                            <label for="exampleInputBorderWidth2"> Email Address</label>
                                <input class="form-control" type="email" name="email" placeholder="Enter Email Address" required>
                            <label for="exampleInputBorderWidth2">Password</label>
                                <input class="form-control" type="password" name="password" placeholder="Enter password">

                                <label for="exampleInputBorder">Sender Group</label>
                                
                                    <select class="custom-select mr-sm-2" name="sender_group">
                                    <option value="100k" selected>100k</option>
                                    <option value="200k">200k</option>
                                    <option value="300k">300k</option>
                                    </select>

                                <label for="exampleInputBorder">Limit</label>
                                <input type="text" class="form-control" name="limit" placeholder="Enter Name" required>
                                <label for="exampleInputBorder">User Type</label>

                                
                                <select class="custom-select mr-sm-2" name="type">
                                    <option value="2" selected>User</option>
                                    <option value="1">Admin</option>
                                  </select>
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