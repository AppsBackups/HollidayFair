@extends('auth.master')
@section('title', 'Login')

@section('content')
    <div class="card card-border">
        <div class="card-body">
            <h3 class="text-center m-t-0 m-b-15">
                <a href="{{ route('home') }}" class="logo"><img src="{{asset('uploads/images/logo.png')}}" height="40"></a>

            </h3>
            <h4 class="m-t-30 m-b-0 text-center">{{ __('Log In')}}</h4>
            {!! Form::open(['route' => 'login', 'method' => 'post','class'=>'form-horizontal m-t-40']) !!}

                @csrf
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-envelope"></i></span>
                        {{ Form::email('email',old('email'), ['class' => 'form-control','placeholder'=>'Email Address','required'=>'required']) }}

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-lock"></i></span>
                        {!! Form::password('password', ['class' => 'form-control','placeholder'=>'Password']) !!}

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row m-t-20 m-b-0">
                    <div class="col-sm-12 text-right"><a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot
                            password?')}}</a></div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-12">
                        {!! Form::submit('Log In', ['class' => 'btn btn-block btn-lg waves-effect waves-light']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
