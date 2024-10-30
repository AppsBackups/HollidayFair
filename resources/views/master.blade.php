<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body class="fixed-left">
<div id="loader"></div>
<div id="wrapper">
    @include('layouts.header')
    @include('layouts.sidebar-nav')
    <div class="content-page">
        <div class="content">
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

</div>
@include('layouts.footer-scripts')
@include('sweet::alert')
@yield('page-script')
</body>
</html>
