@extends('admin.layouts.master')
<style>
.card-header {
    padding: 0.35rem 1.25rem;
    }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>


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
                            <b>Message</b>
                        </h5>
                        <small> &nbsp;Insert Message</small>
                    </div>
                    <div class="card_body m-3">
                        @if(session()->has('success'))
                            <div class="btn btn-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                     

                        <form action="/message/store/{{$msg->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="exampleInputBorder">Subject</label>
                                <input class="form-control" name="subject" value="{{ $msg->subject??''}}" placeholder="Enter subject" required>
                            <label for="exampleInputBorderWidth2">Message Body</label>
                                <textarea name="msg_body" id="editor" style="display:none;"> {!! $msg->msg_body ?? '' !!}</textarea>

                                {{-- <div id="editor">
                                    {!! $msg->msg_body ?? '' !!}
                                </div> --}}
                            <br>
                            
                            
                            @php
                            $img = App\Models\Image::where('message_id',$msg->id)->get();
                            // dd($img);
                        @endphp
                            @foreach ($img as $img)
                            {{-- <img src="{{ isset($image->name) ? asset('backend/message/'.$image->name) : ''}}" width="20%" height="100px"><br> --}}
                            <img width="150" height="150" src="{{ asset('/backend/message/' . $img->name) }}" alt="{{ $img->name }}">
                            <a href="{{ url('deleteOldImage/' . $img->id) }}" class="btn btn-danger" role="button" >X</a>
                            @endforeach
                                
                                <br>
                            <label for="exampleInputBorder">Message Photo</label>
                                <input type="file" 
                                name="images[]" 
                                id="inputImage"
                                multiple 
                                class="form-control @error('images') is-invalid @enderror">
                                {{-- <label for="exampleInputBorderWidth2">Image show/Hide</label>
                                <select class="form-control" name="file_status">
                                <option value="show" {{$msg->file_status == 'show' ? 'selected' : ''}}>show</option>
                                <option value="hide" {{$msg->file_status == 'hide' ? 'selected' : ''}}>hide</option>
                            </select> --}}
                            <button type="submit" class="btn btn-info btn-sm">Save</button>
                        </form>
                       
                    </div>
                    <script>
                        ClassicEditor
                            .create( document.querySelector( '#editor' ) )
                            .then( editor => {
                                editor.setData( document.querySelector( '#msg_body' ).value );
                                editor.model.document.on( 'change:data', () => {
                                    document.querySelector( '#msg_body' ).value = editor.getData();
                                } );
                            } )
                            .catch( error => {
                                console.error( error );
                            } );
                        </script>
                        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
                        
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection