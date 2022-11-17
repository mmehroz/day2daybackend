@extends('layouts.app-master', ['activePage' => 'product',  'activeSub'=> 'sub_cat',   'titlePage' => __('All Sub Category')])

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">All Sub Category</h4>
                    </div>
                    <a href="{{ route('sub_category.create') }}" class="btn btn-danger col-md-3 ml-auto">Create New SubCategory</a>
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
                                                    <th>Sub Category Name</th>
                                                    <th>Sub Category Slug</th>
                                                    <th>Parent Category Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subCategories as $item)
                                                <tr role="row" class="odd">
                                                    <td>{{ $item->id }}</td>
                                                    <td class="sorting_1">{{ $item->subcategory_name }}</td>
                                                    <td>{{ $item->subcategory_slug }}</td>
                                                    <td>{{ $item->category_name }}</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <a href="{{ route('sub_category.edit', $item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                                            <form action="{{ route('sub_category.destroy', $item->id) }}" method="post">
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
