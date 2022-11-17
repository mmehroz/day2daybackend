@extends('layouts.app-master', ['activePage' => 'product',  'activeSub'=> 'sub_cat',   'titlePage' => __('Edit Sub Category')])

@section('content')

    <section class="content">
        <div class="row">
            {{-- Add Category Page --}}
            <div class="col-md-8 col-lg-10 offset-1">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Edit Sub Category</h4>
                    </div>
                    <a href="{{ route('sub_category.index') }}" class="btn btn-danger col-md-3 ml-auto">Back</a>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <form action="{{ route('sub_category.update', $subCategory) }}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <h5>Sub Category Name<span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" value="{{ old('subcategory_name', $subCategory->subcategory_name) }}" name="subcategory_name" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                </div>
                                @error('subcategory_name')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h5>Category Name <span class="text-danger">*</span></h5>

                                <div class="col-lg-5 col-md-6 col-sm-3">
                                    <select class="selectpicker" data-size="7" data-style="btn btn-primary btn-round"  name="category_id" title="Single Select">
                                        <option disabled selected>Select Category Name</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $subCategory->category_id ? 'selected': ''}}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
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
@endsection
