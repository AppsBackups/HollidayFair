@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')
    <!-- <iframe src="{{ url('/file-manager/ckeditor') }}" style="width: 100%; height: -webkit-fill-available; overflow: hidden; border: none;"></iframe> -->
    <iframe src="{{ url('/file-manager/ckeditor') }}" style="width: 100%; height: 100vh; overflow: hidden; border: none;"></iframe>
@endsection
