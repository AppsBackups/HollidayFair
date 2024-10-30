@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Manage Interstitial Ads')}}</h4>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{__('Interstitial Ads List')}}</h4>
                                <div class="float-right">
                                    <button class="btn Admin_send_button" data-toggle="modal"
                                            data-target="#add_interstitial">{{__('Add New Interstitial Ad')}}</button>

                                </div>
                                {!! Form::open(['method' => 'post', 'id' => 'contactForm', 'name'=>'contactForm','file' => true]) !!}
                        {{ Form::hidden('id', $id, ['id' => 'id']) }}
                                <div class="row clearfix">
                                     
                                    <div class="col-lg-2 col-sm-2 col-2"></div>
                                    <div class="col-lg-3 col-sm-3 col-3">
                                        {{ Form::label('name', 'Interstitial Ads After no. of Page :', ['class' => 'Form_detail_padding']) }}
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-3">
                                        {{ Form::text('site_description', $perPageValue, array_merge(['class' => 'admin_form_details', 'id' => 'site_description', 'placeholder'=>'Interstitial Ads After no. of Page','required' ])) }}
                                    </div>
                                    <div class="col-lg-2 col-sm-2 col-2">
                                        {!! Form::submit('Submit', ['class' => 'Save_btn Admin_send_button']) !!}
                                    </div>
                                    <div class="col-lg-2 col-sm-2 col-2"></div>
                                </div>
                                {!! Form::close() !!}
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="dataTable" class="datatable table table-striped dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('Id No.')}}</th>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Image')}}</th>
                                                <th>{{__('Splash Page')}}</th>
                                                <!-- <th>{{__('Link')}}</th> -->
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
    <div id="add_interstitial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="myModalLabel">{{ __('Add Interstitial Ad')}}</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    {!! Form::open(['method' => 'post', 'id' => 'interstitialForm', 'name'=>'interstitialForm','file' => true]) !!}
                    <div class="row" id="ads">
                        <div class="col-md-6">
                            {{ Form::label('name', 'Interstitial Ad Name :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::text('name', null, array_merge(['class' => 'admin_form_details', 'id' => 'interstitialment_link', 'placeholder'=>'Interstitial Ad Name','required' ])) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('display_time', 'Interstitial Ad Time :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::text('display_time', null, array_merge(['class' => 'admin_form_details', 'id' => 'interstitialment_link', 'placeholder'=>'Interstitial Ad Time','required' ])) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('interstitialment_image', 'Image :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::file('interstitialment_image[]', ['class' => 'admin_form_details','id' => 'uploadImage', 'accept'=> "image/*"]) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('interstitialment_link', 'Advertise link :', ['class' => 'Form_detail_padding']) }}
                            {{ Form::text('interstitialment_link[]', null, array_merge(['class' => 'admin_form_details', 'id' => 'interstitialment_link', 'placeholder'=>'Advertise link','required' ])) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="addImageBtn" style="margin-top: 10px;" type="button" class="btn" onclick="addImageLink()">Add Image & Link</button>
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('interstitialment_link', 'Dedicated to Splash Page?', ['class' => 'Form_detail_padding']) }}
                            <input type="checkbox" name="is_splash_page" value="y" onclick="javascript:isSplashPage(this.checked);">
                        </div>
                    </div>
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
        function isSplashPage(checkStatus){
            if(checkStatus == true){
                $("#addImageBtn").prop('disabled',true);
                $(".newImageBlock").remove();
            }
            else{
                $("#addImageBtn").prop('disabled',false);
            }
        }
        function addImageLink() {
  
  let id = Math.random().toString(36).substring(7);
  let exercise_id = Math.random().toString(36).substring(7);
  

  

  var html = '<div class="col-md-6 newImageBlock" ><input class="admin_form_details" id="uploadImage"  accept="image/*" name="interstitialment_image[]" type="file"></div><div class="col-md-6 newImageBlock"><input class="admin_form_details" id="interstitialment_link" placeholder="Advertise link" name="interstitialment_link[]" type="text"></div>';
    
  $("#ads").append(html);
  
            
}

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
                ajax: "{{ route('interstitial.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'image', orderable: false, searchable: false },
                    { data: 'is_splash_page' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            $(document).on('submit', '#interstitialForm', function (event) {
                showLoader();
                event.preventDefault();

                action = "{{ route('interstitial.create') }}";
                $.ajax({
                    data: new FormData(this),
                    url: action,
                    type: "POST",
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function (response) {
                        hideLoader();
                        console.log(response);
                        // alert(response);
                        if (response.success === true) {
                            swal("Success", response.message, "success", {
                                button: "Ok",
                            });
                            dataTable.draw();
                            $('#interstitialForm').trigger("reset");
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
                let url = "{{ route('interstitial.destroy', ['id' => ':id']) }}";
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
            $(document).on('submit', '#contactForm', function (event) {
                showLoader();
                event.preventDefault();

                action = "{{ route('interstitial.update') }}";
                $.ajax({
                    data: new FormData(this),
                    url: action,
                    type: "POST",
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function (response) {
                        hideLoader();
                        // console.log(response);
                        // alert(response);
                        if (response.success === true) {
                            swal("Success", response.message, "success", {
                                button: "Ok",
                            });
                            dataTable.draw();
                            // $('#contactForm').trigger("reset");
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
        });
    </script>
@stop
