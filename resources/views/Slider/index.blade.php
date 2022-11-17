@extends('layouts.app-master', ['activePage' => 'slider',  'activeSub'=> 'slider',   'titlePage' => __('All Slider')])
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">crop_original</i>
                        </div>
                        <h4 class="card-title">All Slider</h4>
                    </div>
                    <a href="{{ route('slider.create') }}" class="btn btn-primary col-md-3 ml-auto">Create New Slider</a>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1" class="table table-bordered table-striped dataTable"
                                            role="grid" aria-describedby="example1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>#</th>
                                                    <th>Slider Image</th>
                                                    <th>Slider Name</th>
                                                    <th>Slider Title</th>
                                                    <th>Slider Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sliders as $item)
                                                <tr role="row" class="odd">
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>
                                                        <img src="{{ url('public/assets/img/sliders/' , $item->slider_image) }}" alt="" style="width: 70px; height:40px;">
                                                    </td>
                                                    <td class="sorting_1">{{ $item->slider_name }}</td>
                                                    <td>{{ $item->slider_title }}</td>
                                                    <td>                                                        <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->slider_status ? 'checked' : '' }}>
                                                    </td>
                                                    <td>

                                                        <div class="input-group">
                                                            <a href="{{ route('slider.edit', $item) }}" class="btn btn-round btn-success btn-fab" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                                            <form action="{{ route('slider.destroy', $item) }}" method="post">
                                                                @method('DELETE')
                                                                @csrf
                                                                <a href="" class="btn btn-round btn-danger btn-fab" title="Delete Data" id="delete" onclick="event.preventDefault();
                                                                this.closest('form').submit();"><i class="fa fa-trash"></i></a>
                                                            </form>
                                                        </div>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection
    @section('scripts')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var slider_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/changesliderstatus',
                    data: {'status': status, 'slider_id': slider_id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
    @endsection
