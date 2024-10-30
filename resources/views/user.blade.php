@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{ __('Manage User') }}</h4>
        </div>
        @csrf
        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{ __('Users List')}}</h4>
                                <div class="float-right">
                                    <button class="btn Admin_send_button" id="add_manager">{{ __('Add User')}}</button>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="dataTable" class="datatable table table-striped dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id No.</th>
                                                <th>Image</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>City</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add user detail -->

    <div class="content" id="addForm">
        <div class="inner-page-wrapper">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-header-title m-b-20">
                            <h4 class="page-title">{{__('User')}}</h4>
                            <div class="float-right">
                                <button class="btn Admin_send_button" id="back_order">{{__('Back')}}</button>
                            </div>
                        </div>

                        <div class="Admin_form add-user">

                            {!! Form::open(['method' => 'post', 'id' => 'userForm', 'name'=>'userForm','file' => true]) !!}
                            {{ Form::hidden('id', null, ['id' => 'id']) }}
                            {{ Form::hidden('old_image', null, ['id' => 'old_image']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('first_name', 'First Name :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('first_name', null, array_merge(['class' => 'admin_form_details', 'id' => 'first_name', 'placeholder'=>'First Name' ,'required'=>'required'])) }}
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('last_name', 'Last Name :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('last_name', null, array_merge(['class' => 'admin_form_details', 'id' => 'last_name', 'placeholder'=>'Last Name' ,'required'=>'required'])) }}
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('email', 'Email Address :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::email('email', null, array_merge(['class' => 'admin_form_details', 'id' => 'email', 'placeholder'=>'Email' ,'required'=>'required'])) }}

                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('job_title', 'Job Title :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('job_title', null, array_merge(['class' => 'admin_form_details', 'id' => 'job_title', 'placeholder'=>'Job Title' ])) }}
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('company_name', 'Company Name :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('company_name', null, array_merge(['class' => 'admin_form_details', 'id' => 'company_name', 'placeholder'=>'Company Name' ])) }}
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('city', 'City :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('city', null, array_merge(['class' => 'admin_form_details', 'id' => 'city', 'placeholder'=>'City' ,'required'=>'required' ])) }}
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('avatar', 'Avatar :', ['class' => 'Form_detail_padding']) }}
                                    <div class="row m-t-10 align-items-center">
                                        <span class="edit_profile_img"><img src="{{asset('uploads/images/gallary.png')}}"
                                                                            id="displayImage"></span>
                                        <div class="">
                                            {{ Form::file('avatar', ['class' => 'admin_form_details','id' => 'uploadImage']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <br>
                                    <div class="reset_pass_div">
                                        <label>
                                            {!! Form::checkbox('rest_password', '1', null,  ['id' => 'rest_password']) !!}
                                            Reset Password
                                        </label>
                                    </div>
                                    <div class="password">
                                        {{ Form::label('password', 'Password :', ['class' => 'Form_detail_padding']) }}
                                        {{ Form::password('password', array_merge(['class' => 'admin_form_details', 'id' => 'password', 'placeholder'=>'Password' ,'required'=>'required' ])) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-btn text-center m-t-10">
                                {!! Form::submit('Submit', ['class' => 'Save_btn Admin_send_button']) !!}
                                {{ Form::button('Cancel',['class'=>'Close_btn Admin_send_button','type'=>'button','id'=>'formcancel']) }}
                            </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add user detail -->


    <!-- view user detail -->

    <div class="content" id="view_product_request">
        <div class="page-header-title">
            <h4 class="page-title">{{__('User Profile')}}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{__('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <h4 class="view_title mb-0">{{__('Personal Detail')}}</h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-xl-2  py-2 text-center">
                                        <div class="View_user_profile">
                                            <div class="user-profile-img">
                                                <div class="profile_picc">
                                                    <img src="{{asset('uploads/images/gallary.png')}}" id="user_avatar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-xl-10 py-2">
                                        <div class="usre-detail-content">
                                            <label><span>{{__('Full-Name : ')}}</span><label id="user_name">demo</label></label>
                                            <label><span>{{__('Email : ')}}</span><label
                                                    id="user_email">demo</label></label>
                                            <label><span>{{__('City : ')}}</span><label
                                                    id="user_city">demo</label></label>
                                            <label><span>{{__('Job Title : ')}}</span><label
                                                    id="user_job_title">demo</label></label>
                                            <label><span>{{__('Company Name : ')}}</span><label id="user_company_name">demo</label></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">


                        <ul class="nav nav-tabs nav-justified m-t-20" role="tablist">
                            <li class="nav-item user_tab"><a class="nav-link active" id="home-tab-2" data-toggle="tab"
                                                             href="#home-2" role="tab" aria-controls="home-2"
                                                             aria-selected="false"> <span
                                        class=" d-sm-block">{{__('Shopping Planner')}}</span></a></li>
                        </ul>


                        <div class="tab-content bg-light p-0">


                            <div class="tab-pane fade show active" id="home-2" role="tabpanel"
                                 aria-labelledby="home-tab-2">
                                <div class="card">
                                    <div class="card-body user_content_max_height">
                                        <div class="user-vendor-content" id="user_vendor">
                                            <li>
                                                <div class="my_vendor_detail">
                                                    <div class="my_vendor_content">
                                                        <span>Agworld</span>
                                                        <span class="text-muted">768</span>
                                                    </div>
                                                    <div class="my_vendor_image">
                                                        <img src="assets/images/b-3.png">
                                                    </div>

                                                </div>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- view user detail -->

@endsection

@section('page-script')
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let dataTable = $('#dataTable').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'image', orderable: false, searchable: false, className: 'user_profile' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'city' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            $(document).on('submit', '#userForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();

                if (id) {
                    action = "{{ route('users.update', ['id' => ':id']) }}";
                    action = action.replace(':id', id);
                } else {
                    action = "{{ route('users.create') }}";
                }

                $.ajax({
                    data: new FormData(this),
                    url: action,
                    type: "POST",
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function (response) {
                        hideLoader();
                        if (response.success === true) {
                            swal("Success", response.message, "success", {
                                button: "Ok",
                            });
                            dataTable.draw();
                            $('#userForm').trigger("reset");
                            $('#displayImage').attr('src', "{{asset('uploads/images/gallary.png')}}");
                            $('#view_form').show();
                            $('#addForm').hide();

                        } else {
                            swal("Error", response.message, "error", {
                                button: "Ok",
                            });
                        }
                    },
                    error: function (data) {
                        hideLoader();
                        swal("Error", data, "error", {
                            button: "Ok",
                        });
                    }
                });
            });

            $(document).on('click', '.edit_btn', function () {
                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('users.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#email').val(data.email);
                    $('#city').val(data.city);
                    $('#job_title').val(data.job_title);
                    $('#company_name').val(data.company_name);
                    $('.password').hide();
                    $('#password').removeAttr('required');
                    if (data.avatar) {
                        $('#displayImage').attr('src', "{{asset('uploads/')}}/" + data.avatar);
                        $('#old_image').val(data.avatar);
                    }
                    $('#id').val(data.id);
                });
            });

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let url = "{{ route('users.destroy', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                swal({
                    title: 'Are you sure?',
                    text: "It will be deleted permanently!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }, function () {
                    $.ajax({
                        url: url,
                         type: 'delete',
                        dataType: 'json',
                        success: function (response) {

                            if (response.success === true) {
                                dataTable.draw();
                                swal('Deleted!', response.message, 'success');


                            } else {
                                swal("Error", response.message, "error", {
                                    button: "Ok",
                                });
                            }
                        },
                        error: function (data) {

                            swal("Error", data, "error", {
                                button: "Ok",
                            });
                        }
                    })
                });

            });

            $('#rest_password').change(function () {
                if ($(this).is(":checked")) {
                    $('.password').show();
                    $("#password").prop('required', true);
                } else {
                    $('.password').hide();
                    $('#password').removeAttr('required');
                }

            });

            $(document).on('click', '.view_btn', function () {
                showLoader();

                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('users.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    hideLoader();
                    $('#user_name').text(data.first_name+' '+data.last_name);
                    $('#user_email').text(data.email);
                    $('#user_city').text(data.city);
                    $('#user_job_title').text(data.job_title);
                    $('#user_company_name').text(data.company_name);
                    if (data.avatar) {
                        $('#user_avatar').attr('src', "{{asset('uploads/')}}/" + data.avatar);
                    }
                    else{
                        $('#user_avatar').attr('src', "{{asset('uploads/images/gallary.png')}}");
                    }
                    $('#user_vendor').html(data.shopping_planner)
                });
            });
        });

    </script>
@stop
