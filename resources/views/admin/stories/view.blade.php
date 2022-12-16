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
{{--                                <form role="form" enctype="multipart/form-data">--}}
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ old('name', $story->name ? $story->name : '') }}" name="name" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Another name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ old('name', $story->another_name ? $story->another_name : '') }}" name="another_name" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <label class="control-label ">Image</label>
                                        <img id="image" src="{{ asset('/assets/images/stories/'. $story->image) }}" alt="story image" class="form-control" style="width: 200px; height: 200px" />
                                        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status" disabled>
                                            <option>Select</option>
                                            <option value="0" @if(old('active', $story->status) == 0) selected @endif>NEW</option>
                                            <option value="1" @if(old('active', $story->status) == 1) selected @endif>UPDATED</option>
                                            <option value="2" @if(old('active', $story->status) == 2) selected @endif>PENDING</option>
                                            <option value="3" @if(old('active', $story->status) == 3) selected @endif>DONE</option>
                                            <option value="4" @if(old('active', $story->status) == 4) selected @endif>DROP</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="datetime-local" name="start_date" value="{{ $story->start_date ? $story->start_date : '' }}" class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Author</label>
                                        <div>
                                            <select class="form-control" name="author_id" id="authorName" disabled>
                                                <option disabled="disabled" selected>Choose option</option>
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
                                                        {{ in_array($category->id, json_decode($story->category_id)) ? 'checked' : ''  }} disabled
                                                    >
                                                    <label for="category{{$category->id}}" style="font-weight: normal">{{$category->name}}</label><br>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="form-group">
                                            <textarea type="text" class="form-control" name="description" id="edit_description_ckeditor" disabled >{{ $story->description? $story->description : '' }}</textarea>
                                        </div>
                                    </div>
                                    <a class="btn btn-sm btn-default" href="{{ route('stories.index') }}">
                                        Back
                                    </a>
{{--                                </form>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / main -->
            </div>
        </div>
    </div>
@endsection
