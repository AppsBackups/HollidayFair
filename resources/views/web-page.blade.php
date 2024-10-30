@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Manage Web Pages')}}</h4>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{__('Web Page List')}}</h4>
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
                                                <th>{{__('Page Title')}}</th>
                                                <th>{{__('Date')}}</th>
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
            <h4 class="page-title">{{ __('Edit Detail') }}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{ __('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['method' => 'post', 'id' => 'webForm', 'name'=>'infoForm','file' => true]) !!}
                        {{ Form::hidden('id', null, ['id' => 'id']) }}
                        <div class="form-group">
                            {{ Form::label('title', 'Page Title :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::text('title', null, array_merge(['class' => 'admin_form_details', 'id' => 'title', 'placeholder'=>'Page Title' ,'required'=>'required' ])) }}

                        </div>
                        <div class="form-group">
                            {{ Form::label('description', 'Page Description', ['class' => 'Form_detail_padding']) }}
                            {{ Form::textarea('description', null, array_merge(['class' => 'admin_form_details', 'id' => 'editor', 'placeholder'=>'Enter Page Description', 'rows'=>'3', 'required'=>'required'])) }}
                        </div>

                        <div class="form-btn text-center m-t-20">
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="information-content">
                    <h4 class="view_title p-0 text-center" id="page_title">{{__('Page Content')}}</h4>
                    <div class="border-bottom m-b-10"></div>
                    <div id="page_description">
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="Close_btn" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- view event detail -->
@endsection
@section('page-script')
    <script type="text/javascript">
        $(function () {
            if($('#editor').length)
            {
                CKEDITOR.replace( 'editor', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
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
                ajax: "{{ route('web-page.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'title' },
                    { data: 'created_at' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            $(document).on('submit', '#webForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();

                action = "{{ route('web-page.update', ['id' => ':id']) }}";
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
                            $('#webForm').trigger("reset");
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

                let url = "{{ route('web-page.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    $('#title').val(data.title);
                    if (data.description) {
                        CKEDITOR.instances['editor'].setData(data.description)
                    }
                    $('#id').val(data.id);
                });
            });

            $(document).on('click', '.view_btn', function () {
                showLoader();
                $('#view_form').show();
                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('web-page.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    hideLoader();
                    $('#page_title').text(data.title);
                    $('#page_description').html(data.description);

                });
            });
            $(document).on('click', '.Close_btn', function (e) {
                $('#addForm').hide();
                $('#view_form').show();
            });


        });
    </script>
@stop
