@extends('layouts.app-master', ['activePage' => 'user', 'activeSub'=> 'user',  'titlePage' => __('All Users')])

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
                <div class="page-categories">
                    <div class="tab-content tab-space tab-subcategories">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">people_alt</i>
                                    </div>
                                    <h4 class="card-title">All Users</h4>
                                </div>
                                <div class="card-body">
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Number</th>
                                                <th>Role</th>
                                                <th>Verified</th>
                                                <th>Status</th>
                                                <th class="disabled-sorting text-right">Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Number</th>
                                                <th>Role</th>
                                                <th>Verified</th>
                                                <th>Status</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{$user->id}}</td>
                                                    <td>
                                                        <div class="picture-container">
                                                            <div class="picture">
                                                                <img src="{{asset('public/assets/img/'. $user->photo)}}" style="border-radius: 50%"  id="wizardPicturePreview" class="picture-src" width="50" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->username}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{$user->number}}</td>
                                                    <td>{{$user->role->name}}</td>
                                                    <td>
                                                        @if($user->email_verified_at != null)
                                                            <span class="badge badge-success">Verified</span>
                                                        @else
                                                            <span class="badge badge-danger">Not Verified</span>
                                                        @endif
                                                    <td>
                                                        @if($user->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="{{route('users.show', $user->id)}}" class="btn btn-link btn-success btn-just-icon like"><i class="material-icons">visibility</i></a>
                                                        <a href="{{route('users.edit', $user->id)}}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}

                                                        <button type="submit" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></button>
{{--                                                        {!! Form::submit('', ['class' => 'btn btn-link btn-danger btn-just-icon remove']) !!}--}}
{{--                                                        <i class="material-icons">close</i>--}}
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script src="{{asset('public/assets/js/mode.js')}}"></script>







@endsection
