<!DOCTYPE html>
<html lang="en">
<head>
    @include('auth.layouts.head')
</head>
<body>
<div class="wrapper-page">
        @yield('content')
</div>
@include('auth.layouts.footer-scripts')
@include('sweet::alert')
</body>
</html>
