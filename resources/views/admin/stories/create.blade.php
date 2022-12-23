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
            CKEDITOR.replace( 'description_ckeditor');
        });
        $( document ).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            $("#authorName").select2({
                theme: "classic"
            });
            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
            });
            $(function(){
                var requiredCheckboxes = $(':checkbox[required]');
                requiredCheckboxes.change(function(){
                    if(requiredCheckboxes.is(':checked')) {
                        requiredCheckboxes.removeAttr('required');
                    } else {
                        requiredCheckboxes.attr('required', 'required');
                    }
                });
            });
            // $('#start-date').datetimepicker();
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image').attr('src', e.target.result).width(200).height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

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
                                <form role="form" method="post" action="{{route('stories.store')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Another name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="another_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label ">Image</label><span class="required" style="color: red;" aria-required="true"> * </span>
                                        <input type="file" name="image" class="form-control" onchange="readURL(this);" required>
                                        <img id="image" src="#" alt="story image" class="form-control" />
                                        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status" required>
                                            <option disabled selected value="">Select</option>
                                            <option value="0">NEW</option>
                                            <option value="1">UPDATED</option>
                                            <option value="2">PENDING</option>
                                            <option value="3">DONE</option>
                                            <option value="4">DROP</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date</label><span class="required" style="color: red;" aria-required="true"> * </span>
                                        <input type="datetime-local" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Author</label>
                                        <div>
                                            <select class="form-control" name="author_id" id="authorName" required>
                                                <option disabled selected value="">Choose option</option>
                                                @foreach($authors as $author)
                                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Categories</label>
                                        <div class="row">
                                            @foreach($categories as $category)
                                                <div class="checkbox-inline col-12 col-xs-12 col-sm-6 col-lg-4 col-xl-3">
                                                    <input id="category{{$category->id}}" type="checkbox" value="{{$category->id}}" name="category_id[]" id="checkCategories" required>
                                                    <label for="category{{$category->id}}" style="font-weight: normal">{{$category->name}}</label><br>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="form-group">
                                            <textarea type="text" class="form-control" id="description_ckeditor" name="description" required></textarea>
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
