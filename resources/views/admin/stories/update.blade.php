@extends('admin.main-layout')
@section('extra_css')
    <link media="all" type="text/css" rel="stylesheet" href="/vendor/css/multi-upload-file.css">
    {{--    <link rel="stylesheet" href="/vendor/css/star.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    {{--    <link rel="stylesheet" href="/vendor/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css">--}}
@endsection
@section('extra_js')
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    {{--    <script src="/vendor/js/plugin-multi-upload-file.js" type="text/javascript"></script>--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    {{--    <script src="/vendor/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>--}}
    <script>
        $(document).ready(function(){
            CKEDITOR.replace( 'edit_description_ckeditor');
        });
        $( document ).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            console.log(`{{$story->image}}` )
            if(`{{$story->image}}` === '' ){
                $( "#upload-image" ).removeClass( "d-none" )
            }

            readURL('{{ $story->image }}')

            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
            });


        });
        //How to set a value to a file input in HTML?
        //https://stackoverflow.com/questions/1696877/how-to-set-a-value-to-a-file-input-in-html/70485949#70485949
        function loadURLToInputFiled(){
            let url = '{{ asset('/assets/images/stories/') }}'
            console.log('{{ $story->image }}' !== '')
            getImgURL(url, (imgBlob)=>{
                // Load img blob to input
                // WIP: UTF8 character error
                let fileName = '{{ $story->image }}'
                let file = new File([imgBlob], fileName,{type:"image/jpeg", lastModified:new Date().getTime()}, 'utf-8');
                let container = new DataTransfer();
                container.items.add(file);
                document.querySelector('input[name="image"]').files = container.files;
                $('#image').attr('src', '{{ asset('/assets/images/stories/'. $story->image) }}').width(200).height(200);
            })
        }
        // xmlHTTP return blob respond
        function getImgURL(url, callback){
            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                callback(xhr.response);
            };
            xhr.open('GET', url);
            xhr.responseType = 'blob';
            xhr.send();
        }
        const getBase64StringFromDataURL = (dataURL) =>
            dataURL.replace('data:', '').replace(/^.+,/, '');
        function readURL(input) {

            console.log('check ', input === `{{$story->image}}`)
            if( input !== '' && input === `{{$story->image}}`){
                loadURLToInputFiled()
            }else{
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        console.log(e.target.result);
                        $('#image').removeClass('d-none').attr('src', e.target.result).width(200).height(200);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
        $(".btn-delete-image").on('click',function(e) {
            e.preventDefault();
            const idStory = $(this).attr('data-image');
            var confirmation = confirm("Are you sure you want to delete image?");
            if (confirmation) {
                $.ajax({
                    type:'GET',
                    url:'/admin/stories/deleteImage/' + idStory,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    // data:{user_id: userId},
                    success:function(data){
                        //Refresh the grid
                        console.log($(".data-image"))
                        $(".data-image").remove();
                        $( "#upload-image" ).removeClass( "d-none" ).val('')
                        $('#image').addClass("d-none")
                        alert('delete image successfully');
                    },
                    error: function(e){
                        alert(e.error);
                    }
                });
            }
            else{
                //alert ('no');
                return false;
            }
        });
    </script>
@stop
@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Story</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Story</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('body')
    <div id="content" class="app-content" role="main">
        <div class="app-content-body ">
            <div class="hbox hbox-auto-xs hbox-auto-sm">
                <!-- main -->
                <div class="col">
                    <div class="wrapper-md">
                        <!-- stats -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if(Session::has('success_msg'))
                                    <p class="alert alert-success">{{ Session::get('success_msg') }}</p>
                                @endif
                                @if(Session::has('error_msg'))
                                    <p class="alert alert-danger">{{ Session::get('error_msg') }}</p>
                                @endif
                                @if($errors->any())
                                    <p class="alert alert-danger">
                                        @foreach($errors->getMessages() as $this_error)
                                            {{$this_error[0]}} <br>
                                        @endforeach
                                    </p>
                                @endif
                                <form role="form" method="post" action="{{route('stories.update', $story->id)}}" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ old('name', $story->name ? $story->name : '') }}" name="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Another name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ old('name', $story->another_name ? $story->another_name : '') }}" name="another_name">
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <label class="control-label ">Image</label><span class="required" style="color: red;" aria-required="true"> * </span>
                                        <a href="#" data-image="{{$story->id}}" class="btn btn-xs btn-danger pull-right btn-delete-image">Delete Image</a>
                                        <input type="file"value="#" name="image" id="upload-image" class="form-control d-none @error('image') is-invalid @enderror" onchange="readURL(this);" accept="image/x-png,image/gif,image/jpeg">
                                        <img id="image" src="#" alt="story image" class="form-control" />
                                        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status" required>
                                            <option disabled selected value="">Select</option>
                                            <option value="0" @if(old('active', $story->status) == 0) selected @endif>NEW</option>
                                            <option value="1" @if(old('active', $story->status) == 1) selected @endif>UPDATED</option>
                                            <option value="2" @if(old('active', $story->status) == 2) selected @endif>PENDING</option>
                                            <option value="3" @if(old('active', $story->status) == 3) selected @endif>DONE</option>
                                            <option value="4" @if(old('active', $story->status) == 4) selected @endif>DROP</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date</label><span class="required" style="color: red;" aria-required="true"> * </span>
                                        <input type="datetime-local" name="start_date" value="{{ $story->start_date ? $story->start_date : '' }}" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Author</label>
                                        <div>
                                            <select class="form-control" name="author_id" id="authorName" required>
                                                <option disabled selected value="">Choose option</option>
                                                @foreach($authors as $author)
                                                    <option value="{{ $author->id }}" @if(old('active', $author->id) === $story->author_id) selected @endif >{{ $author->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Categories</label>
                                        <div class="row">
                                            @foreach($categories as $category)
                                                <div class="checkbox-inline col-12 col-xs-12 col-sm-6 col-lg-4 col-xl-3">
                                                    <input id="category{{$category->id}}" type="checkbox" value="{{$category->id}}" name="category_id[]"
                                                        {{ in_array($category->id, json_decode($story->category_id)) ? 'checked' : ''  }}
                                                    >
                                                    <label for="category{{$category->id}}" style="font-weight: normal">{{$category->name}}</label><br>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="form-group">
                                            <textarea type="text" class="form-control" name="description" id="edit_description_ckeditor" required >{{ $story->description? $story->description : '' }}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a class="btn btn-sm btn-default" href="{{ route('stories.index') }}">
                                        Back
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / main -->
            </div>
        </div>
    </div>
@endsection
