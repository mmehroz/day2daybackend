@extends('layouts.app-master', ['activePage' => 'slider',  'activeSub'=> 'slider',   'titlePage' => __('Edit Slider')])
@section('content')
    <section class="content">
        <div class="row">
            {{-- Add Category Page --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">crop_original</i>
                        </div>
                        <h4 class="card-title">Edit Slider</h4>
                    </div>
                    <a href="{{ route('slider.index') }}" class="btn btn-danger col-md-3 ml-auto">Back</a>
                    <!-- /.box-header -->
                    <div class="card-body">

                        <form action="{{ route('slider.update', $slider) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input class="form-check-input" type="checkbox"
                                   id="status" name="slider_status" value="1" {{ $slider->slider_status == 1 ? 'checked': '' }} hidden>
                            <h4 class="text-warning">Slider Image Information</h4>
                            <hr><hr>
                            <div class="form-group">
                                <h5>Slider Name <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="slider_name" value="{{ old('slider_name', $slider->slider_name) }}"
                                    class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                </div>
                                @error('slider_name')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h5>Slider Title <span class="text-danger"></span></h5>
                                <div class="controls">
                                    <input type="text" name="slider_title" value="{{ old('slider_title', $slider->slider_title) }}"
                                    class="form-control">
                                    <div class="help-block"></div>
                                </div>
                                @error('slider_title')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                             <div class="form-group">
                                <h5>Slider Link <span class="text-danger"></span></h5>
                                <div class="controls">
                                    <input type="text" name="slider_link" value="{{ old('slider_link', $slider->slider_link) }}"
                                    class="form-control">
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
                                    <option value="1" {{ $slider->slider_type == 1 ? 'selected': '' }}>Main</option>
                                    <option value="2" {{ $slider->slider_type == 2 ? 'selected': '' }}>First Banner</option>
                                    <option value="3" {{ $slider->slider_type == 3 ? 'selected': '' }}>Second Banner</option>
                                    <option value="4" {{ $slider->slider_type == 4 ? 'selected': '' }}>Third Banner</option>
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
                                        <textarea name="slider_description" id="editor5" cols="30" rows="5" class="form-control" value="{{ old('slider_description', $slider->slider_description) }}">{{ old('slider_description', $slider->slider_description) }}</textarea>
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
                                    <input type="file" name="slider_image" class="form-control"  data-validation-required-message="This field is required"
                                    onchange="sliderShow(this)"> <div class="help-block"></div>
                                </div>
                                @error('slider_image')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                                <img src="{{ url('assets/img/sliders/' , $slider->slider_image) }}" width="100" id="sliderImage" alt="">
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
                    $('#sliderImage').attr('src', e.target.result).width(100);
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
