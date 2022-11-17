@extends('layouts.app-master', ['activePage' => 'user', 'activeSub'=> 'user',  'titlePage' => __('View User')])

@section('content')


    <div class="card">
        <div class="card-header card-header-rose card-header-text">
            <div class="card-text">
                <h4 class="card-title">View User</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <img class="mr-auto ml-auto" src="{!! url('public/assets/img/' . $user->photo) !!}" style="border-radius: 50%" width="100px" alt="...">
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <label style="color: black" class="col-form-label">{{$user->name}}</label>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <label style="color: black" class="col-form-label">{{$user->username}}</label>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <label style="color: black" class="col-form-label">{{$user->email}}</label>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Number</label>
                <div class="col-sm-10">
                    <label style="color: black" class="col-form-label">{{$user->number}}</label>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-2">
                    <label style="color: black" class="col-form-label">{{$user->role->name}}</label>
                </div>
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-2">
                    <label style="color: black" class="col-form-label">
                        @if($user->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </label>
                </div>
                <label class="col-sm-2 col-form-label">Verified</label>
                <div class="col-sm-w">
                    <label style="color: black" class="col-form-label">
                        @if($user->email_verified_at != null)
                            <span class="badge badge-success">Verified</span>
                        @else
                            <span class="badge badge-danger">Not Verified</span>
                        @endif
                    </label>
                </div>
            </div>
            <div class="card-footer ">
                <a href="{{route('users.edit', $user->id)}}" class="btn btn-rose ml-auto mr-auto btn-round">
                    <i class="material-icons">done</i> Edit
                    <div class="ripple-container"></div>
                </a>
            </div>
        </div>
    </div>

    <script src="{{asset('public/assets/js/mode.js')}}"></script>

@endsection
