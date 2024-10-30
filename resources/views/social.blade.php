@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Social Media')}}</h4>
        </div>
        <div class="inner-page-wrapper">
            <div class=" col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="m-b-10 m-t-10 float-left">{{__('Social Media List')}}</h4>
                        <div class="float-right">
                            <button class="btn Admin_send_button" data-toggle="modal"
                                    data-target="#Add_social">{{__('Add New')}}</button>
                        </div>
                        <div class="row clearfix" id="social_data">
                            @foreach ($data as $value)
                                <div class="col-lg-3 col-sm-6 py-3">
                                    <div class="social_media text-center">
                                        <img src="{{asset('uploads/'.$value->social_icon)}}">
                                        <p>{{$value->social_link}}</p>
                                        <div class="text-center action_padding">
                                            <button href="#" class="edit_btn" id="{{$value->id}}" data-toggle="modal"
                                                    data-target="#Add_social"><i class="fa fa-pencil"
                                                                                 aria-hidden="true"></i>
                                            </button>
                                            <span class="delete_btn" data-toggle="modal" data-target="#delete_record"
                                                  id="{{$value->id}}">
                                             <i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- add event detail -->
    <div id="Add_social" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="myModalLabel">{{__('Add Social')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    {!! Form::open(['method' => 'post', 'id' => 'socialForm', 'name'=>'eventForm','file' => true]) !!}
                    {{ Form::hidden('id', null, ['id' => 'id']) }}
                    {{ Form::hidden('old_image', null, ['id' => 'old_image']) }}
                    <div class="form-group">
                        {{ Form::label('social_type', 'Social Type Name :', ['class' => 'Form_detail_padding']) }}
                        {{ Form::text('social_type', null, array_merge(['class' => 'admin_form_details', 'id' => 'social_type', 'placeholder'=>'Like Facebook , Twitter etc..' ,'required'=>'required' ])) }}
                    </div>

                    {{ Form::label('social_icon', 'Social Icon :', ['class' => 'Form_detail_padding']) }}
                    <div class="row m-t-10 align-items-center">
                            <span class="edit_profile_img"><img
                                        src="{{asset('uploads/images/gallary.png')}}"
                                        id="displayImage"></span>
                        <div class="">
                            {{ Form::file('social_icon', ['class' => 'admin_form_details','id' => 'uploadImage']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('social_link', 'Add Link :', ['class' => 'Form_detail_padding']) }}
                        {{ Form::text('social_link', null, array_merge(['class' => 'admin_form_details', 'id' => 'social_link', 'placeholder'=>'Social page link' ,'required'=>'required' ])) }}
                    </div>
                    <div class="form-btn text-center m-t-20">
                        {!! Form::submit('Submit', ['class' => 'Save_btn Admin_send_button']) !!}
                        {{ Form::button('Cancel',['class'=>'Close_btn Admin_send_button','type'=>'button','id'=>'formcancel']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

        @endsection
        @section('page-script')
            <script type="text/javascript">
                $(function () {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $(document).on('submit', '#socialForm', function (event) {
                        showLoader();
                        event.preventDefault();
                        let id = $('#id').val();

                        if (id) {
                            action = "{{ route('social.update', ['id' => ':id']) }}";
                            action = action.replace(':id', id);
                        } else {
                            action = "{{ route('social.create') }}";
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
                                    $('#displayImage').attr('src', "{{asset('uploads/images/gallary.png')}}");
                                    $('#socialForm').trigger("reset");
                                    $("#social_data").load(location.href + " #social_data>*", "");
                                    $('.close').click();

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
                        $('#view_form').show();
                        let id = $(this).attr('id'); //alert(id);

                        let url = "{{ route('social.edit', ['id' => ':id']) }}";
                        url = url.replace(':id', id);

                        $.post(url, function (data) {
                            $('#social_type').val(data.social_type);
                            $('#social_link').val(data.social_link);
                            if (data.social_icon) {
                                $('#displayImage').attr('src', "{{asset('uploads/')}}/" + data.social_icon);
                                $('#old_image').val(data.social_icon);
                            }
                            $('#id').val(data.id);
                        });
                    });
                    $(document).on('click', '.delete_btn', function (e) {
                        e.preventDefault();
                        let id = $(this).attr("id");
                        let url = "{{ route('social.destroy', ['id' => ':id']) }}";
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
                                        swal('Deleted!', response.message, 'success');
                                        $("#social_data").load(location.href + " #social_data>*", "");
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
                    $(document).on('click', '#formcancel', function (e) {
                        $('.close').click();
                    });

                });
            </script>
@stop
