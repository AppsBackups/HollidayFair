@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">

        <div class="inner-page-wrapper">
            <div class=" col-lg-6 ml-auto mr-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="contact-view-detail ">
                            <h3 class="text-center m-b-0">{{__('Contact US')}} <button href="#" class="edit_btn" id="{!! $id !!}" style="float: right;"><i class="fa fa-pencil" aria-hidden="true"></i></button></h3>
                            <div id="conact_details">
                                {!! $site_description !!}
                            </div>
                            <div class="form-btn text-center m-t-30">
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
            <h4 class="page-title">{{ __('Edit Contact Detail') }}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{ __('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['method' => 'post', 'id' => 'contactForm', 'name'=>'contactForm','file' => true]) !!}
                        {{ Form::hidden('id', $id, ['id' => 'id']) }}

                        <div class="form-group">
                            {{ Form::label('value', 'Contact Details', ['class' => 'Form_detail_padding']) }}
                            {{ Form::textarea('site_description', null, array_merge(['class' => 'admin_form_details', 'id' => 'editor', 'placeholder'=>'Enter Contact Details', 'rows'=>'3', 'required'=>'required'])) }}
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


            $(document).on('submit', '#contactForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();

                action = "{{ route('contact-us.update', ['id' => ':id']) }}";
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
                            $("#conact_details").load(location.href+" #conact_details>*","");
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

                let url = "{{ route('contact-us.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                   if (data.site_description) {
                        CKEDITOR.instances['editor'].setData(data.site_description)
                    }
                    $('#id').val(data.id);
                });
            });
        });
    </script>
@stop
