@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Dashboard')}}</h4>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row m-b-15">
                <div class="col-sm-6 col-lg-6 col-xl-3">
                    <div class="card text-center desh-top-box-wraper">
                        <div class="card-body desh-top-box">
                            <span class="desh-top-icon"><i class="fa fa-users" aria-hidden="true"></i></span>
                            <h2 class="m-t-0 m-b-10"><b>{{$total_user}}</b></h2>
                            <p class="m-b-0 m-t-10">{{__('Register Users')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xl-3">
                    <div class="card text-center desh-top-box-wraper">
                        <div class="card-body desh-top-box">
                            <span class="desh-top-icon"><i class="fa fa-th-large" aria-hidden="true"></i></span></span>
                            <h2 class="m-t-0 m-b-10"><b>{{$total_category}}</b></h2>
                            <p class="m-b-0 m-t-10">{{__('Total Category')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xl-3">
                    <div class="card text-center desh-top-box-wraper">
                        <div class="card-body desh-top-box">
                            <span class="desh-top-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <h2 class="m-t-0 m-b-10"><b>{{$total_vendor}}</b></h2>
                            <p class="m-b-0 m-t-10">{{__('Vendors')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xl-3">
                    <div class="card text-center desh-top-box-wraper">
                        <div class="card-body desh-top-box">
                            <span class="desh-top-icon"><i class="fa fa-flag" aria-hidden="true"></i></i></span>
                            <h2 class="m-t-0 m-b-10"><b>{{$total_event}}</b></h2>
                            <p class="m-b-0 m-t-10">{{__('Total Events')}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end row -->
            <div class="row">
                <div class="col-lg-12 col-xl-8">
                    <div class="card">
                        <div class="card-body desh-event">
                            <h3 class="m-b-30 m-t-0">{{__('Latest Events')}}</h3>
                            @foreach($latest_event as $event)
                                <div class="desh-event-box">
                                    <img src="{{asset('uploads/'.$event['event_icon'])}}">
                                    <div class="event-content">
                                        <h4 class="m-t-0">{{$event['event_name']}}</h4>
                                        <span class="text-muted"><span class="icon"><i class="fa fa-calendar"
                                                                                       aria-hidden="true"></i>
</span><span>{{ date('M d, Y', strtotime($event['created_at']))}}</span></span>
                                        <p class="m-t-5 text-muted"></p>
                                    </div>
                                </div>

                            @endforeach

                            <a href="{{route('event.index')}}">
                                <button class="btn btn-view-more float-right m-t-15">{{__('Add Event')}}</button>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-12 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="m-b-20 m-t-0">{{__('Featured Vendors')}}</h3>
                            @foreach($latest_vendor as $vendor)
                                <div class="desh-msg-box">
                                    <div class="msg-content">
                                        <p>{{$vendor['name']}}</p>
                                        <div class="msg-content-img">
                                            @if($vendor['logo'])
                                                @if (substr($vendor['logo'], 0, 6) == 'vendor')
                                                    <img src="{{env('MEDIA_URL') . $vendor['logo']}}">
                                                @endif
                                            @else
                                                <img src="{{asset('uploads/images/favicon.png')}}">

                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- container -->
        </div>
        <!-- Page content Wrapper -->
    </div>
@endsection
