@extends('layouts.app-master', ['activePage' => 'nav',  'activeSub'=> 'nav',   'titlePage' => __('Web Navigation')])

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
                                                <i class="material-icons">Web Navigation</i>
                                            </div>
                                            <h4 class="card-title">Main Nav</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr role="row">
                                                        <th>Nav Name</th>
                                                        <th>Nav Slug</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($parentnav as $parentnav)
                                                        <tr>
                                                            <td>{{ $parentnav->parentnav_name }}</td>
                                                            <td>{{ $parentnav->parentnav_slug }}</td>
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
                                            <form action="{{ url('submitnav') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <h5>Nav Name<span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="parentnav_name" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                                    </div>
                                                    @error('parentnav_name')
                                                    <span class="alert text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <h5>Nav Slug<span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="parentnav_slug" class="form-control" required="" data-validation-required-message="This field is required"> <div class="help-block"></div>
                                                    </div>
                                                    @error('parentnav_slug')
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
