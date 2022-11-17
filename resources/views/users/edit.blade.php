@extends('layouts.app-master', ['activePage' => 'user', 'activeSub'=> 'user',  'titlePage' => __('Edit User')])

@section('content')


    <div class="card">
        <div class="card-header card-header-rose card-header-text">
            <div class="card-text">
                <h4 class="card-title">Edit User</h4>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('users.update', $user->id) }}" class="form-horizontal">
                @method('patch')
                @csrf
                <div class="row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle">
                            <img src="{!! url('public/assets/img/'. $user->photo) !!}" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                        <div>
                          <span class="btn btn-round btn-rose btn-file">
                            <span class="fileinput-new">Add Photo</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="photo" />
                          </span>
                            <br />
                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input value="{{ $user->name }}" type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input value="{{ $user->username }}" type="text" class="form-control" name="username" placeholder="username" required>
                        </div>
                        @if ($errors->has('username'))
                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input value="{{ $user->email }}" type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Number</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="text" value="{{ $user->number }}" class="form-control" name="number" placeholder="Number" required>
                        </div>
                        @if ($errors->has('number'))
                            <span class="text-danger text-left">{{ $errors->first('number') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label label-checkbox">Role</label>
                    <div class="col-lg-2 col-md-6 col-sm-3">
                        <select class="selectpicker" data-size="7" name="role_id" data-style="btn btn-rose btn-round" title="Select Role" required>
                            <option disabled selected>Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ ($role->id == $user->role_id) ? 'selected' : '' }}
                                       >{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label label-checkbox">Status</label>
                    <div class="col-lg-2 col-md-6 col-sm-3">
                        <select class="selectpicker" data-size="7" name="status" data-style="btn btn-rose btn-round" title="Select Role" required>
                            <option disabled selected>Select Status</option>
                            <option value="1" {{ ($user->status) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ ($user->status) ? '' : 'selected' }}>Non Active</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label label-checkbox">Select Tier</label>
                    <div class="col-lg-2 col-md-6 col-sm-3">
                        <select class="selectpicker" data-size="7" name="tier" data-style="btn btn-rose btn-round" title="Select Tier" required>
                            <option value="0" {{ ($user->tier) == 0 ? 'selected' : '' }}>No Tier</option>
                            <option value="1" {{ ($user->tier) == 1 ? 'selected' : '' }}>Tier 1</option>
                            <option value="2" {{ ($user->tier) == 2 ? 'selected' : '' }}>Tier 2</option>
                            <option value="3" {{ ($user->tier) == 3 ? 'selected' : '' }}>Tier 3</option>
                            <option value="4" {{ ($user->tier) == 4 ? 'selected' : '' }}>Tier 4</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label label-checkbox"></label>
                    <div class="col-sm-2 checkbox-radios">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" name="verify" {{ ($user->email_verified_at != null) ? 'checked' : '' }} type="checkbox" value="1"> Verified
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif

                    @if ($errors->has('status'))
                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                    @endif

                    @if ($errors->has('verify'))
                        <span class="text-danger text-left">{{ $errors->first('verify') }}</span>
                    @endif
                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-rose ml-auto mr-auto btn-round">
                        <i class="material-icons">done</i> Submit
                        <div class="ripple-container"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
