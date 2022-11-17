@extends('layouts.app-master', ['activePage' => 'product', 'activeSub'=> 'brand',   'titlePage' => __('Edit Brand')])

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <section class="content">
                            <div class="row">
                                {{-- Add Brand Page --}}
                                <div class="col-md-8 col-lg-8 m-auto">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Edit Brand</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <form action="{{ route('brands.update', $brand) }}" method="post" enctype="multipart/form-data">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group">
                                                    <h5>Brand Name EN <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="brand_name" value="{{ $brand->brand_name }}" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
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
                                                        <!-- <div class="col-md-12 widget-user-image">
                                                            <img  id="show-image"  src="{{ !empty($brand->brand_image) ? asset('public/assets/img/brands/'.$brand->brand_image) : url('public/assets/img/image_placeholder.jpg') }}"  style="float: right" width="200px" height="100px">
                                                        </div> -->
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                              <!-- <span class="btn btn-rose btn-round btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span> -->
                                                                <label class="btn btn-rose btn-round btn-file" style="color: white" for="brand_image">Select Image</label>
                                                                <input id="brand_image" name="brand_image" type="file" style="visibility: hidden;" />
                                                              </span>
                                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                        </div>
                                                    </div>
{{--                                                    <div class="controls">--}}
{{--                                                        <input type="file" name="brand_image" id="brand_image" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>--}}
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

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#brand_image').change(function(e){
                let reader = new FileReader();
                reader.onload = function(e){
                    $('#show-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
