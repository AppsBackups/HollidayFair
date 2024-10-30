@extends('auth.master')

@section('content')
    <div class="card card-border">
        <div class="card-body">
            <h3 class="text-center m-t-0 m-b-15">
                <a href="{{ route('home') }}" class="logo"><img src="{{ asset('uploads/images/logo.png') }}" height="40"></a>

            </h3>
            <h4 class="m-t-30 m-b-0 text-center">{{ __('Reset Password?')}}</h4>
            <p class="text-center forgot-desc">{{ __('We Just need to you for password change')}}</p>
            <form method="POST" class="form-horizontal m-t-40" action="{{ route('user.reset') }}">
                <input type="hidden" name="token" value="{{ $token }}">
                @csrf
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-envelope"></i></span>
                        <input id="email" type="email" class="form-control" name="email" value="{{$email?? old('email') }}" required autocomplete="email" autofocus placeholder="Email"                         <input id="email" type="email" class="form-control" name="email" value="{{$email?? old('email') }}" required autocomplete="email" autofocus placeholder="Email" readonly>


                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-lock"></i></span>
                        <input id="password" placeholder="New Password" type="password" class="form-control" name="password" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12 input-group">
                        <span><i class="fa fa-lock"></i></span>
                        <input id="password" placeholder="Confirm Password" type="password" class="form-control" name="confirm_password" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-12">
                        <button class="btn btn-block btn-lg waves-effect waves-light" type="submit">Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
