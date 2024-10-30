@extends('master')
@section('title', $pageName?? env('APP_NAME'))

@section('content')
    <div class="content" id="view_form">
        <div class="page-header-title">
            <h4 class="page-title">{{ __('Manage Vendors') }}</h4>
        </div>
        @csrf
        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="m-b-10 m-t-10 float-left">{{ __('Vendors List')}}</h4>
                                <div class="float-right">
                                    <button class="btn Admin_send_button"
                                            id="upload_excel">{{ __('Upload Excel')}}</button>
                                    <button class="btn Admin_send_button"
                                            id="add_manager">{{ __('Add Vendor')}}</button>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="dataTable" class="datatable table table-striped dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Id No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Booth Number</th>
                                                <th>Phone</th>
                                                <th>Website</th>
                                                <th>Featured</th>
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
                            <h4 class="page-title">{{__('Vendor')}}</h4>
                            <div class="float-right">
                                <button class="btn Admin_send_button" id="back_order">{{__('Back')}}</button>
                            </div>
                        </div>

                        <div class="Admin_form add-vendor">

                            {!! Form::open(['method' => 'post', 'id' => 'vendorForm', 'name'=>'vendorForm','file' => true]) !!}
                            {{ Form::hidden('id', null, ['id' => 'id']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('name', 'Name :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('name', null, array_merge(['class' => 'admin_form_details', 'id' => 'name', 'placeholder'=>'Vendor Name' ,'required'=>'required'])) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('email', 'Email :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('email', null, array_merge(['class' => 'admin_form_details', 'id' => 'email', 'placeholder'=>'Vendor Email'])) }}
                                </div>

                                <div class="col-md-12">
                                    {{ Form::label('description', 'Description', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::textarea('description', null, array_merge(['class' => 'admin_form_details', 'id' => 'editor', 'placeholder'=>'Enter Vendor Description', 'rows'=>'3'])) }}

                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('booth_number', 'Booth Number :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('booth_number', null, array_merge(['class' => 'admin_form_details', 'id' => 'booth_number', 'placeholder'=>'Booth Number'])) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('booth_hall', 'Booth Hall :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('booth_hall', null, array_merge(['class' => 'admin_form_details', 'id' => 'booth_hall', 'placeholder'=>'Booth Hall'])) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('phone', 'Phone Number :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('phone', null, array_merge(['class' => 'admin_form_details', 'id' => 'phone', 'placeholder'=>'Phone Number'])) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('website', 'Website :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::text('website', null, array_merge(['class' => 'admin_form_details', 'id' => 'website', 'placeholder'=>'Website'])) }}
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('logo', 'Logo :', ['class' => 'Form_detail_padding']) }}
                                    <div class="row m-t-10 align-items-center">
                                        <span class="edit_profile_img"><img
                                                src="{{asset('uploads/images/gallary.png')}}"
                                                id="displayImage"></span>
                                        <div class="">
                                            {{ Form::file('logo', ['class' => 'custom-file-input','id' => 'uploadImage']) }}
                                            {{ Form::label('choose_file', 'Choose file :', ['class' => 'custom-file-label','for'=>'uploadImage']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    {{ Form::label('booth_map', 'Booth Map :', ['class' => 'Form_detail_padding']) }}
                                    <div class="row m-t-10 align-items-center">
                                        <span class="edit_profile_img"><img
                                                src="{{asset('uploads/images/gallary.png')}}"
                                                id="displayImage_map"></span>
                                        <div class="">
                                            {{ Form::file('booth_map', ['class' => 'custom-file-input','id' => 'upload_map']) }}
                                            {{ Form::label('choose_file', 'Choose file :', ['class' => 'custom-file-label','for'=>'upload_map']) }}
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 select-category-add-vendor">
                                    {{ Form::label('category_id', 'Select Category :', ['class' => 'Form_detail_padding']) }}
                                    {{ Form::select('category_id[]', $category , null , ['id'=>'category_id','class' => 'form-control admin_form_details select_heignt','multiple' => true]) }}
                                </div>
                                <div class="col-md-6 select-category-add-vendor">
                                    {{ Form::label('featured', 'Featured Vendor :', ['class' => 'Form_detail_padding']) }}
                                    <label
                                        style="width: 49%;">{{ Form::radio('featured', '1', '',  ['id' => 'featured_yes','checked'=>'checked']) }}
                                        Yes</label>
                                    <label
                                        style="width: 49%;">{{ Form::radio('featured', '0', '',  ['id' => 'featured_no']) }}
                                        No</label>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('photo', 'Vendor Photos :', ['class' => 'Form_detail_padding']) }}
                                    <div class="row m-t-10 align-items-center">
                                        <div class="">
                                            <div class="all-photos"></div>
                                            {{ Form::file('photos', ['class' => 'custom-file-input','id' => 'photo','multiple'=>'multiple']) }}
                                            {{ Form::label('choose_file', 'Choose file :', ['class' => 'custom-file-label','for'=>'photo','id'=>'photolable']) }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-btn text-center m-t-30">
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
            <h4 class="page-title">{{__('Vendor Detail')}}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{__('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="vendor_details">


                                    <div class="col-lg-6 text-center col_border">

                                        <div class="vendor_logo">
                                            <img src="{{asset('uploads/images/gallary.png')}}" id="data_logo">
                                        </div>
                                        <div class="vendor_name_details">
                                            <ul>
                                                <li><i class="mdi mdi-lumx"></i><span id="data_name"></span></li>
                                                <li><i class="mdi mdi-phone-in-talk"></i> <span id="data_phone"></span>
                                                </li>
                                                <li><i class="mdi mdi-link"></i> <span id="data_website"></span></li>
                                                <li><i class="mdi mdi-email"></i> <span id="data_email"></span></li>

                                            </ul>
                                        </div>


                                    </div>

                                    <div class="col-lg-6 col_border">
                                        <div class="vend_details_cat">
                                            <h2>{{__('Category')}}</h2>
                                            <ul id="data_category">

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 py-4 col_border">
                                        <div class="vend_details_cat vendor_details">
                                            <h2>{{__('Vendor Details')}}</h2>
                                            <div id="data_description">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 py-4 col_border">
                                        <div class="vendor_det_photos">
                                            <h2>{{__('Vendor Photos')}}</h2>
                                            <ul id="data_photos">
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center vendor_floor_title">
                                        <h2>{{__('Vendor Floor Plan')}}</h2>
                                        <div class="vendor_flor">
                                            <img id="data_booth_map">
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
    <!-- excel upload file -->
    <div class="content" id="upload_excel_form">
        <div class="page-header-title">
            <h4 class="page-title">{{__('File Uploads')}}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{__('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body"><h4 class="m-t-0 m-b-30">{{__('Excel Upload')}}</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="m-b-30">
                                            {!! Form::open(['method' => 'post', 'id' => 'vendorExcelForm', 'name'=>'vendorExcelForm','file' => true]) !!}
                                            <div class="fallback">
                                                <div class="form-group">
                                                    {{ Form::file('vendor_file',['class' => 'dropify'])}}
                                                </div>
                                            </div>

                                            <div class="form-btn text-center m-t-20">
                                                {!! Form::submit('Submit', ['class' => 'Save_btn Admin_send_button']) !!}
                                                {{ Form::button('Cancel',['class'=>'Close_btn Admin_send_button','type'=>'button','id'=>'formcancel']) }}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div><!-- end row --></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- excel upload file -->
@endsection

@section('page-script')
    <script type="text/javascript">
        $(function () {

            let storedFiles = [];
            $('.dropify').dropify();
            if ($('#editor').length) {
                CKEDITOR.replace('editor', { filebrowserImageBrowseUrl: '/file-manager/ckeditor' });
            }
            selDiv = $(".all-photos");
            $("body").on("click", ".selFile", removeFile);
            function handleFileSelect(e) {
                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                filesArr.forEach(function(f) {

                    if(!f.type.match("image.*")) {
                        return;
                    }
                    storedFiles.push(f);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var html = "<div class='image-container'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='Click to remove'></div>";
                        selDiv.append(html);

                    }
                    reader.readAsDataURL(f);
                });

            }
            function removeFile(e) {

                var file = $(this).data("file");
                for(var i=0;i<storedFiles.length;i++) {
                    console.log(storedFiles[i]);
                    if(storedFiles[i].name === file) {
                        storedFiles.splice(i,1);
                        break;
                    }
                }
                console.log($(this).parent().attr('id'));
                selDiv.append('<input type="hidden" name="removephoto[]" value="'+$(this).parent().attr('id')+'">');
                $(this).parent().remove();
            }

            $("#photo").on("change", handleFileSelect);

            $('#category_id').multiselect({
                nonSelectedText: 'Select Category'
            });

            $(document).on('click', '#upload_excel', function () {
                $('#add_manager').hide();
                $('#view_form').hide();
                $('#view_product_request').hide();
                $('#upload_excel_form').show();
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
                ajax: "{{ route('vendors.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'booth_number' },
                    { data: 'phone' },
                    { data: 'website' },
                    { data: 'featured' },
                    { data: 'action', orderable: false, searchable: false },
                ],

            });

            function readURLs(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#displayImage_map').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#upload_map").change(function () {
                readURLs(this);
            });

            $(document).on('submit', '#vendorExcelForm', function (event) {
                showLoader();
                event.preventDefault();

                $.ajax({
                    data: new FormData(this),
                    url: "{{ route('vendors.upload-excel')}}",
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
                            $('#vendorExcelForm').trigger("reset");
                            $('#view_form').show();
                            $('#addForm').hide();
                            $('#upload_excel_form').hide();

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

            $(document).on('submit', '#vendorForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();

                if (id) {
                    action = "{{ route('vendors.update', ['id' => ':id']) }}";
                    action = action.replace(':id', id);
                } else {
                    action = "{{ route('vendors.create') }}";
                }
                let data = new FormData(this);

                for(var i=0, len=storedFiles.length; i<len; i++) {
                    data.append('photo[]', storedFiles[i]);
                }
                $.ajax({
                    data: data,
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
                            $('#vendorForm').trigger("reset");
                            $('#displayImage').attr('src', "{{asset('uploads/images/gallary.png')}}");
                            $('#displayImage_map').attr('src', "{{asset('uploads/images/gallary.png')}}");
                            $('#view_form').show();
                            $('#addForm').hide();
                            $("#category_id").val('');
                            $("#category_id").multiselect("refresh");

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

                let url = "{{ route('vendors.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {
                    console.log(data);

                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    if (data.description) {
                        CKEDITOR.instances['editor'].setData(data.description)
                    }
                    $('#booth_number').val(data.booth_number);
                    $('#booth_hall').val(data.booth_hall);
                    $('#phone').val(data.phone);
                    $('#website').val(data.website);

                    if (data.logo) {
                        var logo = data.logo;
                        if(logo.search("http")>=0)
                            $('#displayImage').attr('src', data.logo);
                        else
                            $('#displayImage').attr('src', "{{asset('uploads/')}}/" + data.logo);
                    }
                    if (data.booth_map) {
                        var booth_map = data.booth_map;
                        if(booth_map.search("http")>=0)
                            $('#displayImage_map').attr('src', data.booth_map);
                        else
                            $('#displayImage_map').attr('src', "{{asset('uploads/')}}/" + data.booth_map);
                    }
                    if (data.featured == 1) {
                        $('#featured_yes').prop("checked", true);
                    } else {
                        $('#featured_no').prop("checked", true);
                    }
                    if (data.category_id) {
                        let dataarray = data.category_id.split(",");
                        $("#category_id").val(dataarray);
                        $("#category_id").multiselect("refresh");

                    }
                    $(data.vendor_photos)
                    {
                        $.each( data.vendor_photos, function( key, value ) {
                            html="<div class='image-container' id="+value.id+"><img src=\"" + value.photo + "\" data-file='"+value.photo+"' class='selFile' title='Click to remove'></div>";
                            $('.all-photos').append(html);
                        });
                    }

                    $('#id').val(data.id);
                });
            });

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                let id = $(this).attr("id");
                let url = "{{ route('vendors.destroy', ['id' => ':id']) }}";
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

            $(document).on('click', '.view_btn', function () {
                showLoader();

                let id = $(this).attr('id'); //alert(id);

                let url = "{{ route('vendors.show', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {

                    hideLoader();

                    // if (data.logo) {
                    //     $('#data_logo').attr('src', data.logo);
                    // } else {
                    //     $('#data_logo').attr('src', "{{asset('uploads/images/gallary.png')}}");
                    // }
                    // if (data.booth_map) {
                    //     $('#data_booth_map').attr('src', data.booth_map);
                    // } else {
                    //     $('#data_booth_map').removeAttr('src');
                    // }
                    if (data.logo) {
                        var logo = data.logo;
                        if(logo.search("http")>=0)
                            $('#data_logo').attr('src', data.logo);
                        else
                            $('#data_logo').attr('src', "{{asset('uploads/')}}/" + data.logo);
                    }
                    if (data.booth_map) {
                        var booth_map = data.booth_map;
                        if(booth_map.search("http")>=0)
                            $('#data_booth_map').attr('src', data.booth_map);
                        else
                            $('#data_booth_map').attr('src', "{{asset('uploads/')}}/" + data.booth_map);
                    }
                    
                    $('#data_name').text(data.name);
                    $('#data_phone').text(data.phone);
                    $('#data_website').text(data.website);
                    $('#data_email').text(data.email);
                    $('#data_description').html(data.description);
                    $('#data_category').html('');
                    $(data.vendor_category)
                    {
                        $.each( data.vendor_category, function( key, value ) {
                            html='<li><i class="mdi mdi-hand-pointing-right"></i>'+value.category_name+'</li>';
                            $('#data_category').append(html);
                        });
                    }
                    $('#data_photos').html('');
                    $(data.vendor_photos)
                    {
                        $.each( data.vendor_photos, function( key, value ) {
                            html='<li class="vendor_photo_view"><img src="'+value.photo+'"></li>';
                            $('#data_photos').append(html);
                        });
                    }
                });
            });
        });

    </script>
@stop
