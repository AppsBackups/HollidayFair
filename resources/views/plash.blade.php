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
                            <h3 class="text-center m-b-0">{{__('Splash')}}
                                <button href="#" class="edit_btn" id="{!! $id !!}" style="float: right;"><i
                                        class="fa fa-pencil" aria-hidden="true"></i></button>
                            </h3>
                            <div id="plash_description" >

                                <h4>First Screen logo :</h4>
                                <div id="plash_logo">
                                    <img src="{{asset('uploads/'.$logo)}}" width="150px">
                                </div>
                                <br>
                                <h4>Second Screen Images :</h4>
                                <div class="plash_images vendor_det_photos">
                                    <ul id="data_photos">
                                        @foreach($images as $img)
                                            <li class="vendor_photo_view">
                                                <img src="{{asset('uploads/images/'.$img)}}">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <br>
                                <h4>Title :</h4>
                                <div class="plash_title">
                                    {!! $title !!}
                                </div>
                                <br>
                                <h4>Description :</h4>
                                <div class="plash_title">
                                    {!! $description !!}
                                </div>
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
            <h4 class="page-title">{{ __('Edit Detail') }}</h4>
            <div class="float-right">
                <button class="btn Admin_send_button" id="back_order">{{ __('Back')}}</button>
            </div>
        </div>

        <div class="inner-page-wrapper">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['method' => 'post', 'id' => 'plashForm', 'name'=>'contactForm','file' => true]) !!}
                        {{ Form::hidden('id', $id, ['id' => 'id']) }}
                        <div class="row">
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
                                {{ Form::label('images', 'Slider Images :', ['class' => 'Form_detail_padding']) }}
                                <div class="row m-t-10 align-items-center">
                                    <div class="">
                                        <div class="all-photos"></div>
                                        {{ Form::file('images', ['class' => 'custom-file-input','id' => 'images','multiple'=>'multiple']) }}
                                        {{ Form::label('choose_file', 'Choose file :', ['class' => 'custom-file-label','for'=>'photo','id'=>'imageslable']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('title', 'Title :', ['class' => 'Form_detail_padding']) }}
                                {{ Form::text('title', null, array_merge(['class' => 'admin_form_details', 'id' => 'title', 'placeholder'=>'Title' ,'required'=>'required'])) }}
                            </div>
                            <div class="col-md-12">
                                {{ Form::label('value', 'Description', ['class' => 'Form_detail_padding']) }}
                                {{ Form::textarea('description', null, array_merge(['class' => 'admin_form_details', 'id' => 'editor', 'placeholder'=>'Enter Contact Details', 'rows'=>'3', 'required'=>'required'])) }}
                            </div>
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
            let storedFiles = [];

            if ($('#editor').length) {
                CKEDITOR.replace('editor', { filebrowserImageBrowseUrl: '/file-manager/ckeditor' });
            }
            selDiv = $(".all-photos");
            $("body").on("click", ".selFile", removeFile);

            function handleFileSelect(e) {
                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                filesArr.forEach(function (f) {

                    if (!f.type.match("image.*")) {
                        return;
                    }
                    storedFiles.push(f);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var html = "<div class='image-container'><img src=\"" + e.target.result + "\" data-file='" + f.name + "' class='selFile' title='Click to remove'></div>";
                        selDiv.append(html);

                    }
                    reader.readAsDataURL(f);
                });

            }

            function removeFile(e) {

                var file = $(this).data("file");
                for (var i = 0; i < storedFiles.length; i++) {
                    console.log(storedFiles[i]);
                    if (storedFiles[i].name === file) {
                        storedFiles.splice(i, 1);
                        break;
                    }
                }

                selDiv.append('<input type="hidden" name="removephoto[]" value="' + file + '">');
                $(this).parent().remove();
            }

            $("#images").on("change", handleFileSelect);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $(document).on('submit', '#plashForm', function (event) {
                showLoader();
                event.preventDefault();
                let id = $('#id').val();

                action = "{{ route('splash.update', ['id' => ':id']) }}";
                action = action.replace(':id', id);

                let data = new FormData(this);

                for (var i = 0, len = storedFiles.length; i < len; i++) {
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
                            $("#plash_description").load(location.href + " #plash_description>*", "");
                            $('#view_form').show();
                            $('#addForm').hide();
                            $('#displayImage').attr('src', "{{asset('uploads/images/gallary.png')}}");

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

                let url = "{{ route('splash.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.post(url, function (data) {

                    if (data.description) {
                        CKEDITOR.instances['editor'].setData(data.description)
                    }
                    if (data.logo) {
                        $('#displayImage').attr('src', "{{asset('uploads/')}}/" + data.logo);
                    }
                    $(data.photos)
                    {   let img=data.images.split(',');
                        let i=0;

                        $.each(data.photos, function (key, value) {
                            html = "<div class='image-container' id=" + value.id + "><img src=\"" + value + "\" data-file='" + img[i] + "' class='selFile' title='Click to remove'></div>";
                            $('.all-photos').append(html);
                            i++;
                        });
                    }
                    $('#title').val(data.title);

                    $('#id').val(data.id);
                });
            });
        });
    </script>
@stop
