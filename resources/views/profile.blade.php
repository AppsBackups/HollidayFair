@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')
    <div class="page-header-title">
        <h4 class="page-title">Admin Profile</h4>
    </div>
    <div class="container-fluid">
        <div class="admin-profile-page">
            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <div class="card text-center">
                        <div class="card-heading admin_profile_heading text-center">
                            <h4 class="card-title mb-0">{{ __('Profile Details') }}</h4>
                        </div>
                        <div class="Admin_form  text-center">

                            <div class="admin_profile_pic">
                                <label for="profile_picc">

                                    <img
                                        src="{{ $admin_info['avatar'] === "" ? asset('uploads/images/admin.jpg') : asset('uploads/'.$admin_info['avatar']) }}"
                                        id="profile-img-tag">
                                </label>

                            </div>
                            <div class="admin-profile-detail">
                                <label><span class="icon"><i
                                            class="fa fa-user"></i></span><span>{{ $admin_info['first_name'].' '.$admin_info['last_name'] }}</span></label>
                                <label><span class="icon"><i
                                            class="fa fa-envelope"></i></span><span>{{ $admin_info['email'] }}</span></label>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-4">
                    <div class="card text-center">
                        <div class="card-heading admin_profile_heading">
                            <h4 class="card-title mb-0 ">Update Profile</h4>
                        </div>
                        <div class="Admin_form">
                            {!! Form::open(['route' => 'admin.edit-profile', 'method' => 'post','enctype'=>'multipart/form-data']) !!}


                            {{ Form::label('first_name', 'First Name :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::text('first_name',  $admin_info['first_name'], ['class' => 'admin_form_details','placeholder'=>'First Name','required'=>'required']) }}

                            <br>

                            {{ Form::label('last_name', 'Last Name :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::text('last_name', $admin_info['last_name'], ['class' => 'admin_form_details','placeholder'=>'Last Name','required'=>'required']) }}
                            <br>

                            {{ Form::label('email', 'Email :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::email('email', $admin_info['email'], ['class' => 'admin_form_details','placeholder'=>'Email Address','required'=>'required']) }}
                            <br>

                            {{ Form::label('avatar', 'Update Avatar :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::file('avatar', ['class' => 'admin_form_details']) }}
                            <br>
                            <div class="Form_detail_padding"></div>
                            {!! Form::submit('Submit', ['class' => 'btn float-right Admin_send_button']) !!}
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-4">
                    <div class="card text-center">
                        <div class="card-heading admin_profile_heading">
                            <h4 class="card-title mb-0 ">Change Password</h4>
                        </div>
                        <div class="Admin_form">

                            {!! Form::open(['route' => 'admin.change-password', 'method' => 'post']) !!}

                            {{ Form::label('old_password', 'Current Password :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::password('old_password', ['class' => 'admin_form_details','placeholder'=>'Current Password','required'=>'required']) }}
                            <br>

                            {{ Form::label('password', 'New Password :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::password('password', ['class' => 'admin_form_details','placeholder'=>'New Password','required'=>'required']) }}
                            <br>

                            {{ Form::label('confirm_password', 'Confirm Password :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::password('confirm_password', ['class' => 'admin_form_details','placeholder'=>'Confirm Password','required'=>'required']) }}
                            <br>


                            <div class="Form_detail_padding"></div>
                            {!! Form::submit('Save', ['class' => 'btn float-right Admin_send_button']) !!}
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
@endsection


