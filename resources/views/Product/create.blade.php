@extends('layouts.app-master', ['activePage' => 'product',  'activeSub'=> 'product',   'titlePage' => __('Create Product')])

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12 col-12 mr-auto ml-auto">
                <div class="wizard-container">
                    <div class="card card-wizard" data-color="rose" id="wizardProfile">
                        <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h3 class="card-title">
                                    Add New Product
                                </h3>
                                <h5 class="card-description">This information will let us know more about you.</h5>
                            </div>
                            <div class="wizard-navigation">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link " href="#info" data-toggle="tab" role="tab">
                                            Product Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#variant" data-toggle="tab" role="tab">
                                            Product Variant
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#price" data-toggle="tab" role="tab">
                                            Pricing
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#desc" data-toggle="tab" role="tab">
                                            Description
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#images" data-toggle="tab" role="tab">
                                            Images
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#add" data-toggle="tab" role="tab">
                                            Additional Info
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="info">
                                        <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-4">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img src="{{url('assets/img/image_placeholder.jpg')}}" alt="...">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                          <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new">Select thumbnail</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="product_thumbnail" />
                                                          </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">inventory_2</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Product Name</label>
                                                        <input type="text" class="form-control" id="exampleInput1" required="" name="product_name" >
                                                    </div>
                                                </div>
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">category</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Product SKU</label>
                                                        <input type="text" class="form-control" required id="exampleInput2" name="product_sku" >
                                                    </div>
                                                </div>
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text required">
                                                          <i class="material-icons">qr_code_2</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Product BarCode</label>
                                                        <input type="text" class="form-control" id="exampleInput3" name="product_code" required >
                                                    </div>
                                                </div>
                                                  <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text required">
                                                          <i class="material-icons">qr_code_2</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Product Quantity</label>
                                                        <input type="number" class="form-control" id="exampleInput3" name="product_qty" required >
                                                    </div>
                                                </div>
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">style</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput11" class="bmd-label-floating">Tags</label>
                                                        <input type="text"  id="exampleInput4" name="product_tags" class="form-control tagsinput" data-role="tagsinput" data-color="info">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="col-lg-5 col-md-6 col-sm-3">
                                                        <select class="selectpicker" name="brand_id" data-size="7" data-style="btn btn-primary btn-round" title="Brand Select">
                                                            <option disabled selected>Select Brand</option>
                                                            @foreach ($brands as $brand)
                                                                <option  value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-5 col-md-6 col-sm-3">
                                                        <select class="selectpicker" name="category_id"  data-size="7" data-style="btn btn-primary btn-round" title="Category Select">
                                                            @foreach ($categories as $category)
                                                                <option required value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <br><br><br>
                                                    <div class="col-lg-5 col-md-6 col-sm-3">
                                                        <select class="custom-select" name="subcategory_id"  data-size="7" data-style="btn btn-primary btn-round" title="Sub Category Select">
                                                            {{--                                                        <select class="custom-select" name="subcategory_id" aria-label="Default select example">--}}
                                                            <option value="" selected="" disabled="">Select Sub Category</option>
                                                        </select>
                                                        @error('subcategory_id')
                                                        <span class="alert text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-5 col-md-6 col-sm-3">
                                                        <select class="custom-select" name="sub_subcategory_id" data-size="7" data-style="btn btn-primary btn-round" title="Sub Sub Category Select">
                                                            {{--                                                            <select class="custom-select" name="subcategory_id" aria-label="Default select example">--}}
                                                            <option value="" selected="" disabled="">Select Sub Sub Category</option>
                                                        </select>
                                                        @error('sub_subcategory_id')
                                                        <span class="alert text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="variant">
                                        <h5 class="info-text"> Now Create the Variants of the Product</h5>
                                        <button type="button" onclick="Variant()" class="btn btn-primary btn-round">Add Variant</button>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12 mt-3" id="cdiv">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row"  id="sq">
                                                            <div class="row col-lg-12">
                                                                <div class="col-md-2">
                                                                    <div class="form-group bmd-form-group">
                                                                        <input type="text" name="variant[]" class="form-control" placeholder="Variant Name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class=" bmd-form-group">
                                                                        <input type="file" class="form-control" name="var_img[0]" value="" placeholder="Choose image" id="image">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group bmd-form-group">
                                                                        <input type="text" name="size[0][]" class="form-control" placeholder="Size">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group bmd-form-group">
                                                                        <input type="number" name="quantity[0][]" class="form-control" placeholder="Quantity">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group bmd-form-group">
                                                                        <input type="number" name="variantprice[0][]" class="form-control" placeholder="Variant Price">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1 td-actions text-right">
                                                                    <a style="color: aliceblue" type="button" onclick="SizeQ(event, 0)" class="btn btn-success btn-round btn-fab">
                                                                        +
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="price">
                                        <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">payments</i>
                                </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="selling_price" class="bmd-label-floating">Selling Price</label>
                                                        <input required type="number" class="form-control" id="selling_price" name="selling_price">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">storefront</i>
                                </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="purchase_price" class="bmd-label-floating">Purchase Price</label>
                                                        <input required type="number" class="form-control" id="purchase_price" name="purchase_price">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">discount</i>
                                </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="discount_price" class="bmd-label-floating">Discounted Price</label>
                                                        <input type="number" class="form-control" id="discount_price" name="discount_price">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">discount</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tier1_price" class="bmd-label-floating">Tier 1 Price</label>
                                                        <input type="number" class="form-control" id="tier1_price" name="tier1_price">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">discount</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tier2_price" class="bmd-label-floating">Tier 2 Price</label>
                                                        <input type="number" class="form-control" id="tier2_price" name="tier2_price">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">discount</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tier3_price" class="bmd-label-floating">Tier 3 Price</label>
                                                        <input type="number" class="form-control" id="tier3_price" name="tier3_price">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">discount</i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tier4_price" class="bmd-label-floating">Tier 4 Price</label>
                                                        <input type="number" class="form-control" id="tier4_price" name="tier4_price">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="desc">
                                        <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">edit_note</i>
                                </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="short_description" class="bmd-label-floating">Short Describtion</label>
                                                        <input type="text" class="form-control" id="short_description" name="short_description">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">description</i>
                                                        </span>
                                                        <br><br>
                                                        <h3 >Long Description</h3>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <textarea class="form-control offset-1" id="long_description" name="long_description" ></textarea>
                                                        <script>
                                                            CKEDITOR.replace( 'long_description' );
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-10 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="material-icons">description</i>
                                                        </span>
                                                        <br><br>
                                                        <h3 >Additional Info</h3>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <textarea class="form-control offset-1" id="additional_info" name="additional_info" ></textarea>
                                                        <script>
                                                            CKEDITOR.replace( 'additional_info' );
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="images">
                                        <h5 class="info-text"> Upload Product Images </h5>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <div class="input-images"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="add">
                                        <div class="row justify-content-center">

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="hot_deals">
                                                        <div class="icon">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </div>
                                                        <h6>Hot Deals</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="featured">
                                                        <div class="icon">
                                                            <i class="fa fa-feed"></i>
                                                        </div>
                                                        <h6>Featured</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="new_arrival">
                                                        <div class="icon">
                                                            <i class="fa fa-puzzle-piece"></i>
                                                        </div>
                                                        <h6>New Arrival</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="special_offer">
                                                        <div class="icon">
                                                            <i class="fa fa-space-shuttle"></i>
                                                        </div>
                                                        <h6>Special Offer</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="special_deals">
                                                        <div class="icon">
                                                            <i class="fa fa-level-up"></i>
                                                        </div>
                                                        <h6>Special Deals</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="status">
                                                        <div class="icon">
                                                            <i class="fa fa-unlock-alt"></i>
                                                        </div>
                                                        <h6>Status</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="mr-auto">
                                    <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
                                </div>
                                <div class="ml-auto">
                                    <input type="button" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
                                    <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="submit" style="display: none;">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- wizard container -->
            </div>
        </div>
        <!-- /.row -->
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category_id"]').on('change', function(){
                var category_id = $(this).val();
                if(category_id) {
                    $.ajax({
                        url: "{{  url('/admin/category/subcategory/ajax') }}/" + category_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            $('select[name="sub_subcategory_id"]').html('');
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
            $('select[name="subcategory_id"]').on('change', function(){
                var subcategory_id = $(this).val();
                if(subcategory_id) {
                    $.ajax({
                        url: "{{  url('/admin/category/subsubcategory/ajax') }}/" + subcategory_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('select[name="sub_subcategory_id"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="sub_subcategory_id"]').append('<option value="'+ value.id +'">' + value.subsubcategory_name + '</option>');
                            });
                        },
                    });
                } else {
                    alert('danger');
                }
            });
        });
    </script>
    <script type="text/javascript">
        function mainThumbnailShow(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#mainThumbnail').attr('src', e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $('.input-images').imageUploader();
        $(document).ready(function() {
            // Initialise the wizard
            demo.initMaterialWizard();
            setTimeout(function() {
                $('.card.card-wizard').addClass('active');
            }, 600);
        });
        function strhtml (str) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(str, 'text/html');
            return doc.body.firstChild;
        };
        var count = 1;
        function SizeQ(event, num){
            var div = event.target.parentNode.parentNode.parentNode;
            var content = strhtml('<div class="row col-lg-12">'+
                '   <div class="col-lg-2  offset-4">'+
                '  <div class="form-group bmd-form-group">'+
                '   <input type="text" name="size[' + num + '][]" class="form-control" placeholder="Size">'+
                '    </div>'+
                '  </div>'+
                '   <div class="col-lg-2">'+
                '    <div class="form-group bmd-form-group">'+
                '        <input type="number" name="quantity[' + num + '][]" class="form-control" placeholder="Quantity">'+
                '   </div>'+
                '</div>'+
                '   <div class="col-lg-2">'+
                '    <div class="form-group bmd-form-group">'+
                '        <input type="number" name="variantprice[' + num + '][]" class="form-control" placeholder="Variant Price">'+
                '   </div>'+
                '</div>'+
                '<div class="col-lg-2 td-actions text-right">'+
                '    <button type="button" onclick="RemoveSize(event)" class="btn btn-danger btn-round   btn-fab">'+
                '      x'+
                '  </button>'+
                '  </div>'+
                '  </div>');
            div.appendChild(content);
        }
        function RemoveSize(event){
            const divremove = event.target.parentNode.parentNode;
            divremove.remove();
        }
        function RemoveVar(event){
            const divremove = event.target.parentNode.parentNode.parentNode.parentNode;
            divremove.remove();
        }
        function Variant(){
            var content = strhtml('<div class="row">'+
                ' <div class="col-lg-12" id="cdiv2">'+
                '     <div class="row"  id="sq">'+
                '       <div class="row col-lg-12">'+
                '           <div class="col-md-2">'+
                '               <div class="form-group bmd-form-group">'+
                '                   <input type="text" class="form-control" name="variant[]" placeholder="Variant Name">'+
                '               </div>'+
                '           </div>'+

            '    <div class="col-md-2">'+
             '       <div class=" bmd-form-group">'+
               '     <input type="file" class="form-control" name="var_img[' + count + ']" value="" placeholder="Choose image" id="image">'+
                   ' </div>'+
               ' </div>'+
                '           <div class="col-md-2">'+
                '               <div class="form-group bmd-form-group">'+
                '                   <input type="text" name="size[' + count + '][]" class="form-control" placeholder="Size">'+
                '               </div>'+
                '           </div>'+
                '           <div class="col-md-2">'+
                '               <div class="form-group bmd-form-group">'+
                '                   <input type="number" name="quantity[' + count + '][]" class="form-control" placeholder="Quantity">'+
                '               </div>'+
                '           </div>'+
                '           <div class="col-md-2">'+
                '               <div class="form-group bmd-form-group">'+
                '                   <input type="number" name="variantprice[' + count + '][]" class="form-control" placeholder="Variant Price">'+
                '               </div>'+
                '           </div>'+
                '           <div class="col-md-2 td-actions text-right">'+
                '    <button type="button" onclick="SizeQ(event, ' + count + ')" class="btn btn-success btn-round btn-fab">'+
                '      +'+
                '  </button>'+
                '    <button type="button" onclick="RemoveVar(event, ' + count + ')" class="btn btn-danger btn-round btn-fab">'+
                '      x'+
                '  </button>'+
                '           </div>'+
                '       </div>'+
                '   </div>'+
                '</div>'+
                ' </div>');
            document.getElementById('cdiv').appendChild(content);
            count++;
        }
    </script>
@endsection


