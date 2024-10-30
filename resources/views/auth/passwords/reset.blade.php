@extends('auth.master')
@section('title', 'reset-password')

@section('content')
    <div class="card card-border">
        <div class="card-body">
            <h3 class="text-center m-t-0 m-b-15">
                <a href="{{ route('home') }}" class="logo"><img src="{{ asset('uploads/images/logo.png') }}"
                                                                height="40"></a>

            </h3>
            <h4 class="m-t-30 m-b-0 text-center">{{ __('Reset Password?')}}</h4>
            <p class="text-center forgot-desc">{{ __('We Just need to you for password change')}}</p>
            {!! Form::open(['route' => 'password.update', 'method' => 'post']) !!}
                @csrf
            {{ Form::hidden('token', $token) }}
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-envelope"></i></span>
                        {{ Form::email('email', $email?? old('email'), ['class' => 'form-control','placeholder'=>'Email Address','required'=>'required','readonly'=>'readonly']) }}

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-lock"></i></span>
                        {!! Form::password('password', ['class' => 'form-control','placeholder'=>'New Password']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-lock"></i></span>
                        {!! Form::password('confirm_password', ['class' => 'form-control','placeholder'=>'Confirm Password']) !!}

                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-12">
                        {!! Form::submit('Submit', ['class' => 'btn btn-block btn-lg waves-effect waves-light']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
