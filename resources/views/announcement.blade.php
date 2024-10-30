@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Announcement')}}</h4>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{__('Announcement List')}}</h4>
                                <div class="float-right">
                                    <button class="btn Admin_send_button" id="add_manager">Add New</button>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="dataTable" class="datatable table table-striped dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('Id No.')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Date & Time')}}</th>
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
    <div class="content" id="addForm">
        <div class="page-header-title">
            <h4 class="page-title">{{ __('Add Detail') }}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{ __('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['method' => 'post', 'id' => 'announcementForm', 'name'=>'announcementForm','file' => true,'novalidate'=>'novalidate']) !!}
                        <div class="row">
                            <div class="col-lg-6">
                                {{ Form::label('message_title', 'Announcement Title :', ['class' => 'Form_detail_padding']) }}
                                {{ Form::text('message_title', null, array_merge(['class' => 'admin_form_details', 'id' => 'message_title', 'placeholder'=>'Announcement Title' ,'required'=>'required' ])) }}

                            </div>
                            <div class="col-lg-6">
                                {{ Form::label('date_time', 'Date & Time :', ['class' => 'Form_detail_padding']) }}
                                {{ Form::input('dateTime-local', 'date_time','', array('class' => 'admin_form_details', 'placeholder' => 'Date and time','required'=>'required' )) }}

                            </div>
                            <div class="col-lg-12">
                                {{ Form::label('message_description', 'Announcement Description', ['class' => 'Form_detail_padding']) }}
                                {{ Form::textarea('message_description', null, array_merge(['class' => 'admin_form_details', 'id' => 'editor', 'placeholder'=>'Enter Announcement Description', 'rows'=>'3', 'required'=>'required'])) }}
                            </div>
                        </div>
                        <div class="text-center m-t-20">
                            {!! Form::submit('Submit', ['class' => 'Save_btn Admin_send_button']) !!}
                            {{ Form::button('Cancel',['class'=>'Close_btn Admin_send_button','type'=>'button','id'=>'formcancel']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- view event detail -->
    <div class="modal fade" id="view_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Announcement Detail')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="view-announcement-detail">
                        <h4><i class="ion ion-ios-megaphone"></i> <span id="view_message_title">Win a Power tool prize package!</span></h4>
                        <span><i class="mdi mdi-calendar-clock"></i><span id="view_message_date">27 September 2019, 2:00 PM </span></span>
                        <div class="view-announcement-desc" id="view_message_description">
                            <p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            </p><p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="Close_btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- view event detail -->
@endsection
@section('page-script')
    <script type="text/javascript">
        $(function () {
            if ($('#editor').length) {
                CKEDITOR.replace('editor', { filebrowserImageBrowseUrl: '/file-manager/ckeditor' });
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let dataTable = $('#dataTable').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                processing: true,
                serverSide: true,
                ajax: "{{ route('announcement.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'message_title' },
                    { data: 'date_time' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            $(document).on('submit', '#announcementForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();


                $.ajax({
                    data: new FormData(this),
                    url: "{{ route('announcement.create')}}",
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
                            $('#announcementForm').trigger("reset");
                            $('#view_form').show();
                            $('#addForm').hide();

                            CKEDITOR.instances['editor'].setData('');

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

            $(document).on('click', '.view_btn', function () {
                showLoader();
                $('#view_form').show();
                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('announcement.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    hideLoader();
                    $('#view_message_title').text(data.message_title);
                    $('#view_message_description').html(data.message_description);
                    $('#view_message_date').html(data.date_time);

                });
            });
            $(document).on('click', '.Close_btn', function (e) {
                $('#addForm').hide();
                $('#view_form').show();
            });

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let url = "{{ route('announcement.destroy', ['id' => ':id']) }}";
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
        });
    </script>
@stop
