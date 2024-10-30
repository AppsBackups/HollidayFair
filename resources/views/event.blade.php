@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')

    <!-- Start content -->
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Manage Events')}}</h4>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{__('Events List')}}</h4>
                                <div class="float-right">
                                    <button class="btn Admin_send_button" id="add_manager">{{__('Add Event')}}</button>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="dataTable" class="datatable table table-striped dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('Id No.')}}</th>
                                                <th>{{__('Event Name')}}</th>
                                                {{--                                                <th>{{__('Location')}}</th>--}}
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
            <h4 class="page-title">{{ __('Add Detail') }}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{ __('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['method' => 'post', 'id' => 'eventForm', 'name'=>'eventForm','file' => true]) !!}
                        {{ Form::hidden('id', null, ['id' => 'id']) }}
                        {{ Form::hidden('old_image', null, ['id' => 'old_image']) }}
                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::label('event_name', 'Event Name :', ['class' => 'Form_detail_padding']) }}
                                {{ Form::text('event_name', null, array_merge(['class' => 'admin_form_details', 'id' => 'event_name', 'placeholder'=>'Event Name' ,'required'=>'required' ])) }}
                            </div>

                            <div class="col-md-6">
                                {{ Form::label('event_icon', 'Event Icon :', ['class' => 'Form_detail_padding']) }}
                                <div class="row m-t-10 align-items-center">
                                        <span class="edit_profile_img"><img
                                                src="{{asset('uploads/images/gallary.png')}}"
                                                id="displayImage"></span>
                                    <div class="">
                                        {{ Form::file('event_icon', ['class' => 'admin_form_details','id' => 'uploadImage']) }}
                                    </div>
                                </div>
                            </div>
                            {{--                            <div class="col-md-12">--}}
                            {{--                                {{ Form::label('event_address', 'Event Location :', ['class' => 'Form_detail_padding']) }}--}}
                            {{--                                {{ Form::text('event_address', null, array_merge(['class' => 'admin_form_details', 'id' => 'event_address', 'placeholder'=>'Event Location'])) }}--}}
                            {{--                                {{  Form::hidden('latitude', null, array_merge([ 'id' => 'latitude' ])) }}--}}
                            {{--                                {{  Form::hidden('longitude', null, array_merge([ 'id' => 'longitude' ])) }}--}}

                            {{--                            </div>--}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('value', 'Event Description', ['class' => 'Form_detail_padding']) }}
                            {{ Form::textarea('event_description', null, array_merge(['class' => 'admin_form_details', 'id' => 'editor', 'placeholder'=>'Enter Event Description', 'rows'=>'3', 'required'=>'required'])) }}
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
    <div class="content" id="view_product_request">
        <div class="page-header-title">
            <h4 class="page-title">{{__('Event Details')}}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{__('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="col-lg-12">
                    <div class="card event_view_detail">
                        <h4 class="view_title mb-0 text-center p-0" id="event_name_data">{{__('A Networking Event That
                            Rocks ')}}</h4>
                        <div class="event-info-wraper" id="event_description_data">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- view event detail -->
@endsection
@section('page-script')
    {{--    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places"></script>--}}
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
                ajax: "{{ route('event.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'event_name' },
                    // { data: 'event_address' },
                    { data: 'created_at' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            $(document).on('submit', '#eventForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();

                if (id) {
                    action = "{{ route('event.update', ['id' => ':id']) }}";
                    action = action.replace(':id', id);
                } else {
                    action = "{{ route('event.create') }}";
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
                            $('#eventForm').trigger("reset");
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

                let url = "{{ route('event.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    $('#event_name').val(data.event_name);
                    $('#event_description').val(data.event_description);
                    $('#event_address').val(data.event_address);
                    $('#latitude').val(data.latitude);
                    $('#longitude').val(data.longitude);
                    if (data.event_icon) {
                        $('#displayImage').attr('src', "{{asset('uploads/')}}/" + data.event_icon);
                        $('#old_image').val(data.event_icon);
                    }
                    if (data.event_description) {
                        CKEDITOR.instances['editor'].setData(data.event_description)
                    }
                    $('#id').val(data.id);
                });
            });

            $(document).on('click', '.view_btn', function () {
                showLoader();

                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('event.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    hideLoader();
                    $('#event_name_data').text(data.event_name);
                    $('#event_description_data').html(data.event_description);

                });
            });


            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let url = "{{ route('event.destroy', ['id' => ':id']) }}";
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

        // google.maps.event.addDomListener(window, 'load', function () {
        //     var places = new google.maps.places.Autocomplete(document.getElementById('event_address'));
        //
        //     google.maps.event.addListener(places, 'place_changed', function () {
        //         var place = places.getPlace();
        //         document.getElementById('latitude').value = place.geometry.location.lat();
        //         document.getElementById('longitude').value = place.geometry.location.lng();
        //
        //     });
        // });
    </script>


@stop
