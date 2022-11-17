@extends('layouts.app-master', ['activePage' => 'product',  'activeSub'=> 'lookup',   'titlePage' => __('All Products')])

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Product Lookup</h4>
                    </div>
                    <form action="{{route('products.submitlookup')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-10 col-lg-10">
                            <input type="text" class="form-control" name="search">
                        </div>
                        <div class="col-md-2 col-lg-2">
                             <input type="submit" value="Find Product" class="btn btn-finish btn-fill btn-rose btn-wd" name="submit">
                        </div>
                    </div>
                    </form>
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
                                                    <th>Image</th>
                                                    <th>Product Name</th>
                                                    <th>Product Qty</th>
                                                    <th>Purchase Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $item)
                                                <tr role="row" class="odd">
                                                    <td>{{ $item->id }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/img/products/thumb/' . $item->product_thumbnail) }}" alt=""  style="width: 70px;">
                                                    </td>
                                                    <td class="sorting_1">{{ $item->product_name }}</td>
                                                    <td>{{ $item->variant_size->sum('quantity') }}</td>
                                                    <td>{{ $item->purchase_price }}</td>
                                                    <td>{{ $item->selling_price }}</td>
                                                    <td>
                                                         @if ($item->status)
                                                            <span class="badge rounded-pill badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-danger">InActive</span>
                                                        @endif
{{--                                                        <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>--}}
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <a href="{{ route('products.show', $item) }}" class="btn btn-round btn-success btn-fab" title="View Data"><i class="fa fa-eye"></i></a>
                                                            <a href="{{ route('products.edit', $item) }}" class="btn btn-round btn-info btn-fab" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                                            <form action="{{ route('products.destroy', $item) }}" method="post">
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
                var product_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/admin/changestatus',
                    data: {'status': status, 'product_id': product_id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
@endsection
