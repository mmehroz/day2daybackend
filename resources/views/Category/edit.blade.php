@extends('layouts.app-master', ['activePage' => 'product',  'activeSub'=> 'cat',   'titlePage' => __('Create Category')])

@section('content')

    <section class="content">
        <div class="row">
            {{-- Add Category Page --}}
            <div class="col-md-8 col-lg-10 offset-1">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">category</i>
                        </div>
                        <h4 class="card-title">Create Categories</h4>
                    </div>
                    <a href="{{ route('category.index') }}" class="btn btn-danger col-md-3 ml-auto">Back</a>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <form action="{{ route('category.update', $category) }}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <h5>Category Name<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" value="{{ old('category_name', $category->category_name) }}" name="category_name" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                        </div>
                                        @error('category_name')
                                        <span class="alert text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <h5>Category Icon <span class="text-danger"></span></h5>
                                        <div class="controls">
                                            <input type="text" name="category_icon"  value="{{ old('category_icon', $category->category_icon) }}" class="form-control"> <div class="help-block"></div>
                                        </div>
                                        @error('category_icon')
                                        <span class="alert text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Category Image <span class="text-danger">*</span></h5>
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="{{asset('public/assets/img/image_placeholder.jpg')}}" alt="...">
                                            </div>
                                            <div class="col-md-12 widget-user-image">
                                                <img  id="show-image"  src="{{ !empty($category->category_icon) ? asset('public/assets/img/category/'.$category->category_icon) : url('assets/img/image_placeholder.jpg') }}"  style="float: right" width="200px" height="100px">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <label class="btn btn-rose btn-round btn-file" style="color: white" for="category_image">Change Image</label>
                                                                <input id="category_image" name="category_image" type="file" style="visibility: hidden;" />
                                                                       <!--    <span class="btn btn-rose btn-round btn-file">
                                                                            <span class="fileinput-new">Select image</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            <input name="category_image" type="file" />
                                                                          </span> -->
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                            @error('category_image')
                                            <span class="alert text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="text-xs-right">
                                            <button type="submit" class="btn btn-rounded btn-info">Submit</button>
                                        </div>
                                    </div>
                                </div>
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
