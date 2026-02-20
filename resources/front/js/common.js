$(function() {
    "use strict";


    $("#homeLoginForm").validate({
        ignore: [],
        rules: {
            "username": {
                required: true,
            },
            "user_password": {
                required: true,
            },

        },
        messages: {
            username: {
                required: "User ID is required.",
            },
            user_password: {
                required: "Password is required.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#homeLoginForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url + "/login_check",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    $('#login_btn').html('Please Wait...');
                    $('#login_btn').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.status == 1) {

                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });

                        $('#login_btn').html('Login');
                        $("#login_btn").prop("disabled", false);
                        form.reset();
                        if (data.user_type == 'user') {
                            window.location.href = base_url + "/user/inventry-check";
                        }else if (data.user_type == 'admin') {
                            window.location.href = base_url + "/admin/inventry-details";
                        }

                    } else if (data.status == 0) {

                        $('#login_btn').html('Login');
                        $("#login_btn").prop("disabled", false);

                        Swal.fire({
                            title: 'Error',
                            text: data.msg,
                            icon: 'warning',
                        });

                    }
                }
            });
        }
    });


    $("#forgotpasswordForm").validate({
        ignore: [],
        rules: {
            "user_email": {
                required: true,
            },
        },
        messages: {
            user_email: {
                required: "Este campo es obligatorio.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#forgotpasswordForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user_resetpassword",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    $('#forgot_btn').html('Please Wait...');
                    $('#forgot_btn').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.status == 1) {

                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });

                        $('#forgot_btn').html('Reset');
                        $("#forgot_btn").prop("disabled", false);
                        form.reset();

                    } else if (data.status == 0) {

                        $('#forgot_btn').html('Reset');
                        $("#forgot_btn").prop("disabled", false);

                        Swal.fire({
                            title: 'Error',
                            text: data.msg,
                            icon: 'warning',
                        });

                    }
                }
            });
        }
    });

    $("#inventryUploadForm").validate({
        ignore: [],
        rules: {
           
        },
        messages: {
            
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#inventryUploadForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/admin/upload-inventry",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    $('#forgot_btn').html('Please Wait...');
                    $('#forgot_btn').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.status == 1) {

                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });

                        $('#forgot_btn').html('Reset');
                        $("#forgot_btn").prop("disabled", false);
                        form.reset();

                    } else if (data.status == 0) {

                        $('#forgot_btn').html('Reset');
                        $("#forgot_btn").prop("disabled", false);

                        Swal.fire({
                            title: 'Error',
                            text: data.msg,
                            icon: 'warning',
                        });

                    }
                }
            });
        }
    });


    $('#type').change(function () {

        resetBelow('type');

        $('.loader-wrap').show();

        $.post('/user/inventory/models', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: $(this).val()
        }, function (data) {

            $('#model').append('<option value="">Select Model</option>');

            $.each(data, function (key, value) {
                if(value != ''){
                    $('#model').append('<option value="' + value + '">' + value + '</option>');
                }
            });
        }).always(function () {
           $('.loader-wrap').hide();
        });
    });

    // $('#model').change(function () {

    //     resetBelow('model');

    //     $('.loader-wrap').show();

    //     $.post('/user/inventory/finishes', {
    //         _token: $('meta[name="csrf-token"]').attr('content'),
    //         type: $('#type').val(),
    //         model: $(this).val()
    //     }, function (data) {

    //         $('#finish').append('<option value="">Select Finish</option>');

    //         $.each(data, function (key, value) {
    //             if(value != ''){
    //                 $('#finish').append('<option value="' + value + '">' + value + '</option>');
    //             }   
    //         });
    //     }).always(function () {
    //        $('.loader-wrap').hide();
    //     });
    // });

    $('#model').change(function () {

        resetBelow('model');

        $('.loader-wrap').show();

        $.post('/user/inventory/finishes', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: $('#type').val(),
            model: $(this).val()
        }, function (response) {

            // Clear finish dropdown
            $('#finish').empty().append('<option value="">Select Finish</option>');

            // Add finishes
            $.each(response.finishes, function (key, value) {
                if (value !== '') {
                    $('#finish').append(
                        '<option value="' + value + '">' + value + '</option>'
                    );
                }
            });

            // Show description
            if (response.description) {
                $('#modelDescription').html(
                    '<span class="desc-box">' + response.description + '</span>'
                );
            } else {
                $('#modelDescription').html('');
            }

        }).always(function () {
            $('.loader-wrap').hide();
        });
    });


    $('#finish').change(function () {

        resetBelow('finish');

        $('.loader-wrap').show();

        $.post('/user/inventory/designs', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: $('#type').val(),
            model: $('#model').val(),
            finish: $(this).val()
        }, function (data) {

            $('#design').append('<option value="">Select Design</option>');

            $.each(data, function (key, value) {
                if(value != ''){
                    $('#design').append('<option value="' + value + '">' + value + '</option>');
                }
            });
        }).always(function () {
           $('.loader-wrap').hide();
        });
    });

    $('#design').change(function () {

        resetBelow('design');

        $('.loader-wrap').show();

        $.post('/user/inventory/shades', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: $('#type').val(),
            model: $('#model').val(),
            finish: $('#finish').val(),
            design: $(this).val()
        }, function (data) {

            $('#shade').append('<option value="">Select Shade</option>');

            $.each(data, function (key, value) {
                if(value != ''){
                    $('#shade').append('<option value="' + value + '">' + value + '</option>');
                }
            });
        }).always(function () {
           $('.loader-wrap').hide();
        });
    });


    $('#shade').change(function () {

        resetBelow('shade');

        $('.loader-wrap').show();

        $.post('/user/inventory/sizes', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: $('#type').val(),
            model: $('#model').val(),
            finish: $('#finish').val(),
            design: $('#design').val(),
            shade: $(this).val()
        }, function (data) {

            $('#size').empty().append('<option value="">Select Size</option>');

            $.each(data, function (key, value) {
                $('#size').append(
                    '<option value="' + value + '">' +
                    value +
                    '</option>'
                );
            });
        }).always(function () {
           $('.loader-wrap').hide();
        });
    });






  

   
    $('#stockCheckBtn').click(function(e){

        e.preventDefault();

        $('.loader-wrap').show();

        $.post('/user/inventory/stock', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: $('#type').val(),
            model: $('#model').val(),
            finish: $('#finish').val(),
            design: $('#design').val(),
            shade: $('#shade').val(),
            size: $('#size').val()
        }, function(data){

            if(data.status == 1){
                $('.loginForm').hide();
                $('.result-section').show();
                // alert("TSPL: " + data.tspl +
                //     "\nALL: " + data.all_stock +
                //     "\nUltimate: " + data.ultimate);
                    $('.d_alhada').text(data.d_alhada);
                    $('.d_tspl').text(data.d_tspl);
                    $('.d_ultimate').text(data.d_ultimate);
                    $('.d_gmp').text(data.d_gmp);
                    $('.h_alhada').text(data.h_alhada);
                    $('.h_tspl').text(data.h_tspl);
                    $('.h_ultimate').text(data.h_ultimate);
                    $('.h_gmp').text(data.h_gmp);
            } else {
                alert("No Stock Found");
            }
        }).always(function () {
           $('.loader-wrap').hide();
        });
    });

    $('#previous_btn').click(function(e){
        e.preventDefault();
        $('.result-section').hide();
        $('.loginForm').show();
    });


    


    function resetBelow(level) {

        if (level === 'type') {
            $('#model, #finish, #design, #shade, #size').empty();
        }

        if (level === 'model') {
            $('#finish, #design, #shade, #size').empty();
        }

        if (level === 'finish') {
            $('#design, #shade, #size').empty();
        }

        if (level === 'design') {
            $('#shade, #size').empty();
        }

        if (level === 'shade') {
            $('#size').empty();
        }
    }


    


    $(".isnumber").keydown(function(e) {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || 65 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || 67 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || 88 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || e.keyCode >= 35 && e.keyCode <= 39 || (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.preventDefault()
    });


   

  


    

   


    



});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



window.lang_select = function() {
    $(".account-login").slideToggle();
}





























