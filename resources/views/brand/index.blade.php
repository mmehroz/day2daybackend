@extends('layouts.app-master', ['activePage' => 'product',  'activeSub'=> 'brand',   'titlePage' => __('All Brand')])

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-8 col-lg-8">
                                    <div class="card">
                                        <div class="card-header card-header-rose card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">assignment</i>
                                            </div>
                                            <h4 class="card-title">All Brands</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr role="row">
                                                        <th>ID</th>
                                                        <th>Brand Name</th>
                                                        <th>Brand slug</th>
                                                        <th>Brand Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($brands as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $item->id }}</td>
                                                            <td>{{ $item->brand_name }}</td>
                                                            <td>{{ $item->brand_slug }}</td>
                                                            <td>
                                                                <img src="{{ asset('public/assets/img/brands/' . $item->brand_image) }}" alt=""
                                                                     height="60px">
                                                            </td>
                                                            <td class="td-actions text-right">

                                                                <a href="{{ route('brands.edit', $item) }}" rel="tooltip" class="btn btn-success">
                                                                    <i class="material-icons">edit</i>
                                                                </a>
                                                                <form action="{{ route('brands.destroy', $item) }}" method="post">
                                                                    @method('DELETE')
                                                                    @csrf

                                                                    <a href="" rel="tooltip" class="btn btn-danger" title="Delete Data" id="delete" onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                                        <i class="material-icons">close</i>
                                                                    </a>
                                                                </form>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Add Brand Page --}}
                                <div class="col-md-4 col-lg-4">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Add New Brand</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <form action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <h5>Brand Name<span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="brand_name" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                                    </div>
                                                    @error('brand_name')
                                                    <span class="alert text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <h5>Brand Image <span class="text-danger">*</span></h5>
                                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="{{asset('public/assets/img/image_placeholder.jpg')}}" alt="...">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                              <!-- <span class="btn btn-rose btn-round btn-file"> -->
                                                                <!-- <span class="fileinput-new">Select image</span> -->
                                                                <!-- <span class="fileinput-exists">Change</span> -->
                                                                <label class="btn btn-rose btn-round btn-file" style="color: white" for="file">Select Image</label>
                                                                <input name="brand_image" type="file" id="file" style="visibility: hidden;" />
                                                              </span>
                                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                        </div>
                                                    </div>
{{--                                                    <div class="controls">--}}
{{--                                                        <input type="file" name="brand_image" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>--}}
{{--                                                    </div>--}}
                                                    @error('brand_image')
                                                    <span class="alert text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="text-xs-right">
                                                    <button type="submit" class="btn btn-rounded btn-info">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
