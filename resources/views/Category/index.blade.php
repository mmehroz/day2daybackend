@extends('layouts.app-master', ['activePage' => 'product', 'activeSub'=> 'cat',  'titlePage' => __('All Create Category')])

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">

                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">category</i>
                        </div>
                        <h4 class="card-title">All Categories</h4>
                    </div>

                    <a href="{{ route('category.create') }}" class="btn btn-primary col-md-3 ml-auto">Create New Category</a>
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
                                                    <!-- <th>Icon</th> -->
                                                    <th>Name</th>
                                                    <th>Slug</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $item)
                                                <tr role="row" class="odd">
                                                    <td>{{ $item->id }}</td>
                                                   <!--  <td>
                                                        <i class="material-icons">
                                                        {{ $item->category_icon }}
                                                        </i>
                                                    </td> -->
                                                    <td class="sorting_1">{{ $item->category_name}}</td>
                                                    <td>{{ $item->category_slug }}</td>
                                                    <td>
                                                        <img src="{{ asset( 'public/assets/img/category/'.$item->category_icon) }}" alt="" style="width: 70px; height:40px;">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <a href="{{ route('category.edit', $item) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                                            <form action="{{ route('category.destroy', $item) }}" method="post">
                                                                @method('DELETE')
                                                                @csrf
                                                                <a href="" class="btn btn-danger" title="Delete Data" id="delete" onclick="event.preventDefault();
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
