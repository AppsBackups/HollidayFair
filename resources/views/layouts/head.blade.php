{{-- Start Head --}}
<meta charset="utf-8">
<title>@yield('title')</title>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{asset('uploads/images/favicon.png')}}">


<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/sweetalert.min.css')}}" rel="stylesheet" type="text/css">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" >
{{-- End Head --}}


<link href="{{asset('plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

@if(Request::path() == 'vendors')
    <link href="{{ asset('plugins/dropify/css/dropify.css')}}" rel="stylesheet">
@endif
<link href="{{asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" type="text/css">
