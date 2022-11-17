@extends('layouts.app-master', ['activePage' => 'product',  'activeSub'=> 'sub_sub_cat',   'titlePage' => __('Create Sub Sub Category')])

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
                        <h4 class="card-title">Add New Sub Sub Category</h4>
                    </div>
                    <a href="{{ route('sub_sub_category.index') }}" class="btn btn-danger col-md-3 ml-auto">Back</a>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <form action="{{ route('sub_sub_category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <h5>Sub Sub Category Name<span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="subsubcategory_name" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                </div>
                                @error('subsubcategory_name')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h5>Parent Category Name <span class="text-danger">*</span></h5>
                                <div class="col-lg-5 col-md-6 col-sm-3">
                                    <select name="category_id" class="selectpicker" data-size="7" data-style="btn btn-primary btn-round" >
                                        <option disabled selected>Select Category Name</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <h5>Parent SubCategory Name <span class="text-danger">*</span></h5>
                                <div class="col-lg-5 col-md-6 col-sm-3">
                                    <select name="subcategory_id" class="custom-select" data-size="7" data-style="btn btn-success btn-round" >
                                        <option value="" selected="" disabled="">Select SubCategory Name</option>
                                    </select>
                                </div>
                                @error('subcategory_id')
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
@section('scripts')
<script>
    $(document).ready(function() {
      $('select[name="category_id"]').on('change', function(){
          var category_id = $(this).val();
          if(category_id) {
              $.ajax({
                  url: "{{  url('/admin/category/subcategory/ajax') }}/" + category_id,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                     var d =$('select[name="subcategory_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="subcategory_id"]').append('<option value="'+ value.id +'">' + value.subcategory_name + '</option>');
                        });
                  },
              });
          } else {
              alert('danger');
          }
      });
  });
  </script>
@endsection
