@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Manage Web Contact')}}</h4>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{__('Web Contact List')}}</h4>
                                {{--                                <div class="float-right">--}}
                                {{--                                    <button class="btn Admin_send_button" id="add_manager">Add Event</button>--}}
                                {{--                                </div>--}}
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="dataTable" class="datatable table table-striped dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('Id No.')}}</th>
                                                <th>{{__('Full Name')}}</th>
                                                <th>{{__('Subject')}}</th>
                                                <th>{{__('Reply')}}</th>
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


    <!-- view event detail -->
    <div class="modal fade " id="view_contact" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="information-content">
                    <h4 class="view_title p-0 text-center" id="page_title">{{__('Contact Message')}}</h4>
                    <div class="border-bottom m-b-10"></div>
                    <div id="page_description">
                        <div class="usre-detail-content">
                            <label><span>{{__('Full-Name : ')}}</span><label id="full_name">demo</label></label>
                            <label><span>{{__('Email : ')}}</span><label
                                    id="email">demo</label></label>
                            <label><span>{{__('Subject : ')}}</span><label
                                    id="subject">demo</label></label>
                            <label><span>{{__('Message : ')}}</span><label
                                    id="message">demo</label></label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="Close_btn" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="reply_answer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="myModalLabel">{{__('Replay Message')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'post', 'id' => 'contactForm', 'name'=>'eventForm','file' => true]) !!}
                   {{ Form::hidden('id',  null, ['id' => 'id']) }}
                   {{ Form::hidden('full_name',  null, ['id' => 'c_full_name']) }}
                    <div class="form-group">
                        {{ Form::label('email', 'Email :', ['class' => 'Form_detail_padding']) }}
                        {{ Form::email('email', null, array_merge(['class' => 'admin_form_details', 'id' => 'c_email', 'placeholder'=>'Email' ,'required'=>'required','readonly'=>'readonly' ])) }}
                    </div>
                    <div class="form-group">
                        {!! Form::textarea('message_data', '', ['class' => 'admin_form_details','placeholder' => 'Message','required'=>'required']) !!}
                    </div>
                    <div class="form-btn text-center m-t-20">
                        {!! Form::submit('Reply', ['class' => 'Save_btn Admin_send_button']) !!}
                        {{ Form::button('Cancel',['class'=>'Close_btn Admin_send_button','type'=>'button','id'=>'formcancel']) }}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>

        </div>
    </div>
    </div>
    <!-- view event detail -->
@endsection
@section('page-script')
    <script type="text/javascript">
        $(function () {
            $(document).on('click', '#formcancel', function (e) {
                $('.close').click();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let dataTable = $('#dataTable').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                processing: true,
                serverSide: true,
                ajax: "{{ route('web-contact.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'full_name' },
                    { data: 'subject' },
                    { data: 'reply' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            $(document).on('submit', '#contactForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();

                action = "{{ route('web-contact.reply', ['id' => ':id']) }}";
                action = action.replace(':id', id);


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
                            $('#contactForm').trigger("reset");
                            $('#view_form').show();
                            $('.Close_btn').click();

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
                showLoader();
                $('#view_form').show();
                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('web-contact.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    hideLoader();
                    $('#c_email').val(data.email);
                    $('#id').val(data.id);
                    $('#c_full_name').val(data.full_name);
                });
            });


            $(document).on('click', '.view_btn', function () {
                showLoader();
                $('#view_form').show();
                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('web-contact.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    hideLoader();
                    $('#full_name').text(data.full_name);
                    $('#email').text(data.email);
                    $('#subject').text(data.subject);
                    $('#message').html(data.message);

                });
            });
            $(document).on('click', '.Close_btn', function (e) {
                $('#addForm').hide();
                $('#view_form').show();
            });


            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let url = "{{ route('web-contact.destroy', ['id' => ':id']) }}";
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

        });
    </script>
@stop
