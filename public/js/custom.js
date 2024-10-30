$(window).load(function () {
    hideLoader();
});

function showLoader() {
    $('#loader').fadeIn(); //$("#loader").removeClass("loader-hidden");
}

function hideLoader() {
    $('#loader').fadeOut(); //$("#loader").addClass("loader-hidden");
}

$(document).ready(function () {
    $('#datatable').DataTable();
});

$(document).ready(function () {
    $('#upload_excel_form').hide();
    $('#addForm').hide();
    $('#edit_manager').hide();
    $('#view_product_request').hide();
    $('#view_event_request').hide();
});
$(document).on('click', '#back_order', function (e) {
    $('.reset_pass_div').hide();
    $('.password').show();
    $("#password").prop('required', true);
    $('#displayImage').attr('src', "../uploads/images/gallary.png");
    $('form').trigger("reset");
    $('#id').val('');
    $('#old_image').val('');
    $('#addForm').hide();
    $('#view_form').show();
    $('#view_product_request').hide();
    $('#upload_excel_form').hide();
    $('.all-photos').html('');
    if($('#editor').length)
    {
        CKEDITOR.instances['editor'].setData('');
    }
});
$(document).on('click', '#formcancel', function (e) {
    $('.reset_pass_div').hide();
    $('.password').show();
    $("#password").prop('required', true);
    $('#displayImage').attr('src', "../uploads/images/gallary.png");
    $('form').trigger("reset");
    $('#id').val('');
    $('#old_image').val('');
    $('#addForm').hide();
    $('#view_form').show();
    $('#view_product_request').hide();
    $('#upload_excel_form').hide();
    $('.all-photos').html('');
    if($('#editor').length)
    {
        CKEDITOR.instances['editor'].setData('');
    }
});
$(document).on('click', '#add_manager', function () {
    $('.reset_pass_div').hide();
    $('#addForm').show();
    $('#view_form').hide();
    $('#upload_excel_form').hide();
    $('.all-photos').html('');
    if($('#editor').length)
    {
        CKEDITOR.instances['editor'].setData('');
    }
});
$(document).on('click', '.edit_btn', function () {
    $('.reset_pass_div').show();
    $('#addForm').show();
    $('#view_form').hide();
    $('.all-photos').html('');
    $('#upload_excel_form').hide();
});
$(document).on('click', '.view_btn', function () {
    $('#addForm').hide();
    $('#edit_manager').hide();
    $('#view_form').hide();
    $('.all-photos').html('');
    $('#view_product_request').show();
});
$(document).on('click', '#view_event', function () {
    $('#addForm').hide();
    $('#edit_manager').hide();
    $('#view_form').hide();
    $('#view_product_request').hide();
    $('#view_event_request').show();
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#displayImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#uploadImage").change(function () {
    readURL(this);
});

$(document).on('click', '.Close_btn', function (e) {
    $('#addForm').hide();
    $('#view_form').show();
});

