@extends('layouts.app-master', ['activePage' => 'user', 'activeSub'=> 'user',  'titlePage' => __('Change Password')])

@section('content')

    <div class="card ">
        <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
                <i class="material-icons">fingerprint</i>
            </div>
            <h4 class="card-title">Change Password</h4>
        </div>
        <div class="card-body ">
            <form method="post" action="{{route('password.update')}}" class="form-horizontal">
                @csrf
                <div class="row">
                    <label class="col-md-3 col-form-label">New Password</label>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control">
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label">Confirm Password</label>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <button type="submit" class="btn btn-fill btn-rose">Change Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
