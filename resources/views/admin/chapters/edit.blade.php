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
            CKEDITOR.replace( 'edit_content_ckeditor');
        });
        $( document ).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
            });
            $("#storyName").select2({
                theme: "classic"
            });
            // $('#start-date').datetimepicker();
        });

    </script>
@stop
@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Chapter {{$chapter->name}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('chapters.index')}}">Chapters</a></li>
                        <li class="breadcrumb-item active">Edit Chapter</li>
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
                                <form role="form" method="post" action="{{route('chapters.update', $chapter->id)}}" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label>Chapter</label>
                                        <div>
                                            <select class="form-control" name="story_id" id="storyName" required>
                                                <option disabled="disabled" selected value="">Choose option</option>
                                                @foreach($stories as $story)
                                                    <option value="{{ $story->id }}" @if($story->id === $chapter->story_id) selected @endif>{{ $story->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" value="{{ $chapter->name }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="content" class="form-control" id="edit_content_ckeditor" placeholder="content" value="{{ old('content',isset($chapter->content)? $chapter->content :'') }}">{{ $chapter->content ?? '' }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a class="btn btn-sm btn-default" href="{{ route('chapters.index') }}">
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
