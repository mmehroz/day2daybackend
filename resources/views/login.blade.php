@extends('layouts.app-master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                <form method="post" action="{{ route('login.perform') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="card card-login card-hidden">
                        <div class="card-header card-header-rose text-center">
                            <i class="material-icons">lock</i>
                            <h4 class="card-title">Admin Login</h4>
                        </div>
                        <div class="card-body ">
                            <span class="bmd-form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="material-icons">person</i>
                                        </span>
                                    </div>
                                    <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Username/Email..." required="required" autofocus>
                                    @if ($errors->has('username'))
                                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                            </span>
                            <span class="bmd-form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password..." required="required">
                                    @if ($errors->has('password'))
                                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </span>
{{--                            <span class="bmd-form-group">--}}
{{--                                <div class="form-check">--}}
{{--                                      <label class="form-check-label">--}}
{{--                                            <input class="form-check-input" type="checkbox" name="remember" value="1"> Remember me--}}
{{--                                            <span class="form-check-sign">--}}
{{--                                                <span class="check"></span>--}}
{{--                                            </span>--}}
{{--                                      </label>--}}
{{--                                </div>--}}
{{--                            </span>--}}
                        </div>
                        <div class="card-footer justify-content-center">
                            <button type="submit" class="btn btn-rose">
                                 <span class="btn-label">
                                     <i class="material-icons">check</i>
                                </span>
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
