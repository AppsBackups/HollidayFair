@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Manage Advertise')}}</h4>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{__('Advertisement List')}}</h4>
                                <div class="float-right">
                                    <button class="btn Admin_send_button" data-toggle="modal"
                                            data-target="#add_advertise">{{__('Add New Advertise')}}</button>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="dataTable" class="datatable table table-striped dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('Id No.')}}</th>
                                                <th>{{__('Image')}}</th>
                                                <th>{{__('Link')}}</th>
                                                <th>{{__('Action')}}</th>
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

    <!-- add event detail -->
    <div id="add_advertise" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="myModalLabel">{{ __('Add Advertise')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    {!! Form::open(['method' => 'post', 'id' => 'advertiseForm', 'name'=>'advertiseForm','file' => true]) !!}
                    {{ Form::label('advertisement_image', 'Image :', ['class' => 'Form_detail_padding']) }}
                    <div class="row m-t-10 align-items-center">
                            <span class="edit_profile_img"><img
                                    src="{{asset('uploads/images/gallary.png')}}"
                                    id="displayImage"></span>
                        <div class="">
                            {{ Form::file('advertisement_image', ['class' => 'admin_form_details','id' => 'uploadImage']) }}
                        </div>
                    </div>

                    {{ Form::label('advertisement_link', 'Advertise link :', ['class' => 'Form_detail_padding']) }}
                    {{ Form::text('advertisement_link', null, array_merge(['class' => 'admin_form_details', 'id' => 'advertisement_link', 'placeholder'=>'Advertise link' ])) }}


                    <div class="form-btn text-center m-t-20">
                        {!! Form::submit('Submit', ['class' => 'Save_btn Admin_send_button']) !!}
                        {{ Form::button('Cancel',['class'=>'Close_btn Admin_send_button','type'=>'button','id'=>'formcancel']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
            let dataTable = $('#dataTable').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                processing: true,
                serverSide: true,
                ajax: "{{ route('advertise.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'image', orderable: false, searchable: false },
                    { data: 'advertisement_link' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            $(document).on('submit', '#advertiseForm', function (event) {
                showLoader();
                event.preventDefault();

                action = "{{ route('advertise.create') }}";
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
                            $('#advertiseForm').trigger("reset");
                            $('#displayImage').attr('src', "{{asset('uploads/images/gallary.png')}}");

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

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let url = "{{ route('advertise.destroy', ['id' => ':id']) }}";
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
                                dataTable.draw();

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
