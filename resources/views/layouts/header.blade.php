<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="{{ route('admin.dashboard') }}" class="logo"><img src="{{ asset('uploads/images/logo.png')}}"
                                                                       height="28"></a>
            <a href="{{ route('admin.dashboard') }}" class="logo-sm"><img src="{{ asset('uploads/images/logo_sm.png')}}"
                                                                          height="36"></a>
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-light waves-effect"><i class="fa fa-bars"></i>
                    </button>
                </li>

            </ul>
            <ul class="nav navbar-right float-right list-inline">
                <li class="dropdown  d-sm-block">
                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box"
                       data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bell"></i> <span
                            class="badge badge-xs badge-danger"></span></a>
                    <ul class="dropdown-menu dropdown-menu-lg p-0">
                        <li class="text-center notifi-title">{{__('Notification')}}</li>
                        <li class="list-group">
                            <!-- list item-->

                            @foreach($notification as $noti)
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="media">
                                        <div class="media-heading">{{$noti['subject']}}
                                        </div>
                                        <p class="m-0"><small>{{ str_limit($noti['message'], 20) }}</small></p>
                                    </div>
                                </a>
                            @endforeach
                            <a href="{{route('web-contact.index')}}" class="text-center">
                                <button class="notifi-all-btn">See all</button>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown"
                       aria-expanded="true"><img
                            src="{{ Auth::user()->avatar === "" ? asset('uploads/images/admin.jpg') : asset('uploads/'.Auth::user()->avatar) }}"
                            alt="user-img" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.profile') }}" class="dropdown-item">Profile</a></li>
                        <li><a href={{ route('logout') }} class="dropdown-item">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
