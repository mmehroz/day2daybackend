@extends('layouts.app-master', ['activePage' => 'slider',  'activeSub'=> 'slider',   'titlePage' => __('Create Slider')])

@section('content')

    <section class="content">
        <div class="row">
            {{-- Add Category Page --}}
            <div class="col-md-8 col-lg-10 offset-1">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">crop_original</i>
                        </div>
                        <h4 class="card-title">Create New Slider</h4>
                    </div>
                    <a href="{{ route('slider.index') }}" class="btn btn-danger col-md-3 ml-auto">Back</a>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="slider_status" value="1">
                            <h4 class="text-warning">Slider Image Information</h4>
                            <hr><hr>
                            <div class="form-group">
                                <h5>Slider Name <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="slider_name" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                </div>
                                @error('slider_name')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h5>Slider Title <span class="text-danger"></span></h5>
                                <div class="controls">
                                    <input type="text" name="slider_title" class="form-control">
                                    <div class="help-block"></div>
                                </div>
                                @error('slider_title')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h5>Slider Link <span class="text-danger"></span></h5>
                                <div class="controls">
                                    <input type="text" name="slider_link" class="form-control">
                                    <div class="help-block"></div>
                                </div>
                                @error('slider_link')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                             <div class="form-group">
                                <h5>Slider Type <span class="text-danger"></span></h5>
                                <div class="controls">
                                    <select class="selectpicker" name="slider_type" data-size="7" data-style="btn btn-primary btn-round" title="Slider">
                                    <option value="" selected>Select Slider Type</option>
                                    <option value="1">Main</option>
                                    <option value="2">First Banner</option>
                                    <option value="3">Second Banner</option>
                                    <option value="4">Third Banner</option>
                                </select>
                                    <div class="help-block"></div>
                                </div>
                                @error('slider_type')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                                <div class="form-group">
                                    <h5>Slider Description<span class="text-danger"></span></h5>
                                    <div class="controls">
                                        <textarea name="slider_description" id="editor5" cols="30" rows="5" class="form-control"></textarea>
                                        <div class="help-block"></div>
                                    </div>
                                    @error('slider_description')
                                        <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            <h4 class="text-warning">Slider Single Image Upload</h4>
                            <hr><hr>
                            <div class="">
                                <h5>Slider Image <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="file" name="slider_image" class="form-control" required="" data-validation-required-message="This field is required"
                                    onchange="sliderShow(this)"> <div class="help-block"></div>
                                </div>
                                @error('slider_image')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                                <img src="" id="sliderImage" alt="">
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
    <script type="text/javascript">
        function sliderShow(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#sliderImage').attr('src', e.target.result).height(100);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="{{ asset('') }}assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
    <script src="{{ asset('') }}assets/vendor_components/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('') }}assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
    <script src="{{ asset('backend') }}/js/pages/editor.js"></script>
    @endsection
