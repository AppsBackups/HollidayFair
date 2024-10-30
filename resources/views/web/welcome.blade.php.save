<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Holly Day Fair</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="shortcut icon" href="{{asset('uploads/images/favicon.png')}}">
    <link href="{{asset('web/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- font-awesome.min.css -->
    <link href="{{asset('web/css/material-design-iconic-font.min.css')}}" rel="stylesheet">
    <!-- slicknav.min.css -->
    <link href="{{asset('web/css/slicknav.min.css')}}" rel="stylesheet">
    <!-- magnific popup.css -->
    <link href="{{asset('web/css/magnific-popup.css')}}" rel="stylesheet">
    <!-- owl.css -->
    <link href="{{asset('web/css/owl.carousel.css')}}" rel="stylesheet">
    <!-- animate.min.css -->
    <link href="{{asset('web/css/animate.min.css')}}" rel="stylesheet">
    <!-- style.css -->
    <link href="{{asset('web/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/media_query.css')}}" rel="stylesheet">
    <link href="{{asset('css/sweetalert.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body class="home1">
<div id="home"></div>


<div class="header-area white-background">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="logo">
                    <a href="{{route('/')}}"><img src="{{asset('web/img/web-logo.png')}}" alt="logo"></a>
                </div>
            </div>
            <div class="col-md-10 text-right">
                <div class="responsive_menu"></div>
                <div class="mainmenu">
                    <ul id="nav" class="mt-2">
                        <li><a href="{{route('/')}}#home">Home</a></li>
                        <li><a href="{{route('/')}}#about">About</a></li>
                        <li><a href="{{route('/')}}#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  header area end -->
<!--  hero area start -->

<div class="main-hero-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="hero-txt">
                    {!! $data['home_slider_section']['description']  !!}
                    <!-- <a class="home1-download-btn" target="_blank" href="{--!! $data['ios_link']['description']  !!--}"></a>
                    <a class="home1-download-btn2"  target="_blank" href="{--!! $data['android_link']['description']  !!--}"></a> -->
                    <a href="https://play.google.com/store/apps/details?id=com.hollydayfair" target="_blank"><img class="store-icon" src="{{asset('web/img/playstore.svg')}}" alt="logo"></a>
                    <a target="_blank" href="https://apps.apple.com/us/app/holly-day-fair/id1483443661"><img class="store-icon" src="{{asset('web/img/appstore.svg')}}" alt="logo"></a>
                </div>

            </div>
            <div class="col-md-6">
                <div class="home1-hero-mobile wow fadeInDown">
                    <img src="{{asset('web/img/home1-hero-mobile-img.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!--  hero area start -->
<!--  about area start -->
<div class="about-area" id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title z-index1 wow fadeInUp">
                    {!! $data['home_about_section']['description']  !!}

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="about-single-item">
                    <div class="about-single-icon">
                        <span style="background: url({{asset('web/img/icon_support.png')}})"></span>
                    </div>
                    <div class="about-single-content">
                        <h4>{!! $data['sponsor']['title']  !!}</h4>
                        {!! $data['sponsor']['description']  !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="about-single-item">
                    <div class="about-single-icon">
                        <span style="background: url({{asset('web/img/icon_privacy.png')}});"></span>
                    </div>
                    <div class="about-single-content">
                        <h4>{!! $data['floore_plan']['title']  !!}</h4>
                        {!! $data['floore_plan']['description']  !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="about-single-item">
                    <div class="about-single-icon cta">
                        <span style="background: url({{asset('web/img/icon_code.png')}});"></span>
                    </div>
                    <div class="about-single-content">
                        <h4>{!! $data['shopping_planner']['title']  !!}</h4>
                        {!! $data['shopping_planner']['description']  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  about area end -->
<!--  featured area start -->
<div class="Section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 wow fadeInLeft align-self-center">
                <div class="featured-mobile">
                    <img src="{{asset('web/img/featured-mobile.png')}}" alt="">
                </div>
            </div>
            <div class="col-lg-8 offset-lg-1 col-md-12 wow fadeInRight margin-left-30 align-self-center">
                <div class="about_app">
                    <h2>{!! $data['app_description']['title']  !!}</h2>
                    <div class="border_btn"></div>
                    {!! $data['app_description']['description']  !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!--  featured area end -->


<!--  contact area start -->
<div class="contact-area" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title ctas1">
                    <h2>Contact Us</h2>
                    <p>Interested in advertising and/or sponsoring the<br> 2019 Holly Day Fair</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-lg-1 wow fadeInLeft">
                <div class="contact-form">
                    {!! Form::open(['route' => 'contact-us', 'method' => 'post','enctype'=>'multipart/form-data']) !!}
                        <div class="row">
                            <div class="col-lg-6">
                                {{ Form::text('full_name','', ['placeholder'=>'Full Name','required'=>'required']) }}
                            </div>
                            <div class="col-lg-6">
                                {{ Form::email('email', '', ['placeholder'=>'Email Address','required'=>'required']) }}
                            </div>
                            <div class="col-lg-12">
                                {{ Form::text('subject','', ['placeholder'=>'Subject','required'=>'required']) }}
                            </div>
                            <div class="col-lg-12">
                                {!! Form::textarea('message', '', ['placeholder' => 'Message']) !!}
                            </div>
                            <div class="col-lg-12">
                                {!! Form::submit('Send message', []) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <br>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif


                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInRight">
                <div class="contact-form-right">
                    <div class="contact-form-right-single">
                        <h5>{!! $data['phone']['title']  !!}</h5>
                        <p>{!! $data['phone']['description']  !!}</p>
                    </div>
                    <div class="contact-form-right-single">
                        <h5>{!! $data['email']['title']  !!}</h5>
                        <p>{!! $data['email']['description']  !!}</p>
                    </div>
                    <div class="contact-form-right-single">
                        <h5>{!! $data['address']['title']  !!}</h5>
                        <p>{!! $data['address']['description']  !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  contact area end -->
<!--  footer area start -->
<div class="footer-area wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="footer-menu">
                    <ul id="footer-list">
                        <li><a href="{{route('/')}}">Home</a></li>
                        <li><a href="{{route('faq')}}">FAQ's</a></li>
                        <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                        <li><a href="{{route('term-condition')}}">Terms of Use</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <div class="footer-title">
                    <p>&copy; 2019 All Right Revervd by <a href="{{route('/')}}">Holly Day Fair</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{asset('web/js/jquery.js')}}"></script>
<!-- jquery.popper.min.js -->
<script src="{{asset('web/js/popper.min.js')}}"></script>
<!-- bootstrap.min.js -->
<script src="{{asset('web/js/bootstrap.min.js')}}"></script>
<!-- jquery.slicknav.min.js -->
<script src="{{asset('web/js/jquery.slicknav.min.js')}}"></script>
<!-- jquery.magnific.min.js -->
<script src="{{asset('web/js/jquery.magnific-popup.min.js')}}"></script>
<!-- jquery.is sticky.min.js -->
<script src="{{asset('web/js/jquery.sticky.js')}}"></script>
<!-- jquery.owl.min.js -->
<script src="{{asset('web/js/owl.carousel.min.js')}}"></script>
<!-- jquery.wow.min.js -->
<script src="{{asset('web/js/wow.min.js')}}"></script>
<!-- main.js -->
<script src="{{asset('web/js/main.js')}}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
</html>
@include('sweet::alert')
