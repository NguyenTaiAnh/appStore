@extends('admin.main-layout')
@section('extra_css')

<style>
    .truncate {
        max-width:800px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        border-bottom: 0 !important;
    }
</style>
@endsection
@section('extra_js')
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function(){
            var oTable = $('#chapter').DataTable({
                processing:true,
                serverSide:true,
                pageLength:10,
                sort: false,
                searching: true,
                ajax: {
                    url: '{{route('chapters.dataTable')}}',
                    data: function (d) {
                        d.keyword = $('#keyword').val()
                        d.status = $('#status').val()
                    }
                },
                columns: [
                    {data:'name', searchable:true},
                    {data:'content', searchable:true},
                    {data:'created_at', searchable:false},
                    {data:'updated_at', searchable:false},
                    {data:'action', searchable:false},
                ],
                columnDefs:[{targets:1,className:"truncate"}],
                createdRow: function(row){
                    var td = $(row).find(".truncate");
                    td.attr("title", td.html());}
            })
            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
            });

        });
    </script>
@stop
@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chapters</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chapters</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('body')
    <!-- Main row -->
    <div class="row">
        <div class="container-fluid">
            <div class="col-12">
                <!-- /.card -->
                @if(Session::has('success_msg'))
                    <p class="alert alert-success">{{ Session::get('success_msg') }}</p>
                @endif
                @if(Session::has('error_msg'))
                    <p class="alert alert-danger">{{ Session::get('error_msg') }}</p>
                @endif
                <div class="table-responsive" id="example1_length" style="margin: 20px">

                    <a href="{{ route('chapters.create') }}" class="btn-create btn btn-success align-center" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i>
                        Add
                    </a>
                </div>
                <div class="table-responsive">
                    <table style="width: 100%;" class="data-table table table-bordered table-hover" id="chapter">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Content</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
    <!-- /.row (main row) -->
@endsection
