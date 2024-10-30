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
                            <h3 class="text-center m-b-0">{{__('Floor Plan')}} <button href="#"  data-toggle="modal"
                                                                                       data-target="#Add_floor" class="edit_btn" id="{!! $id !!}" style="float: right;"><i class="fa fa-pencil" aria-hidden="true"></i></button></h3>
                            <div id="floore_Image">
                                <img src="{{asset('uploads/'.$floor_image)}}" width="100%">
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
    <div id="Add_floor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="myModalLabel">{{__('Add Floor Image')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    {!! Form::open(['method' => 'post', 'id' => 'floorForm', 'name'=>'floorForm','file' => true]) !!}
                    {{ Form::hidden('id', null, ['id' => 'id']) }}
                    {{ Form::hidden('old_image', null, ['id' => 'old_image']) }}

                    {{ Form::label('floor_image', 'Image :', ['class' => 'Form_detail_padding']) }}
                    <div class="row m-t-10 align-items-center">
                            <span class="edit_profile_img"><img
                                        src="{{asset('uploads/images/gallary.png')}}"
                                        id="displayImage"></span>
                        <div class="">
                            {{ Form::file('floor_image', ['class' => 'admin_form_details','id' => 'uploadImage']) }}
                        </div>
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


            $(document).on('submit', '#floorForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();


                    action = "{{ route('floor-plan.update', ['id' => ':id']) }}";
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
                            $('#displayImage').attr('src', "{{asset('uploads/images/gallary.png')}}");
                            $('#floorForm').trigger("reset");
                            $("#floore_Image").load(location.href + " #floore_Image>*", "");
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

                let url = "{{ route('floor-plan.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {

                    if (data.floor_image) {
                        $('#displayImage').attr('src', "{{asset('uploads/')}}/" + data.floor_image);
                        $('#old_image').val(data.floor_image);
                    }
                    $('#id').val(data.id);
                });
            });

            $(document).on('click', '#formcancel', function (e) {
                $('.close').click();
            });
        });
    </script>
@stop
