<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Holly Day Fair</title>
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
</head>
<body class="blog-page">
<div id="home"></div>
<!--  header area start -->
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
<!--  bradcam area start -->
<div class="broadcamp-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>{{$site_title}}</h2>
            </div>
        </div>
    </div>
</div>
<!--  bradcam area start -->
<!--  blog area start -->
<div class="blog-area cta" id="single-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-12 wow fadeInLeft">
                <div class="single-blog-left">
                    <div class="single-blog-content">
                        {!! $site_description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  blog area end -->
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
</html>
