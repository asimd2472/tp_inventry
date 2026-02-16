$(function() {
    "use strict";


    $("#loginForm").validate({
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
                required: "Este campo es obligatorio.",
            },
            user_password: {
                required: "Este campo es obligatorio.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#loginForm')[0];
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
                        if (data.redrict == 'default') {
                            window.location.href = base_url + "/user/course-list";
                        }else if (data.redrict == 'payment_method') {
                            window.location.href = base_url + "/user/payment-methods";
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

    $("#user_changepassword").validate({
        ignore: [],
        rules: {
            "user_password": {
                required: true,
            },
            "confirm_user_password": {
                required: true,
                equalTo: "#user_password"
            },
        },
        messages: {
            "confirm_user_password": {
                equalTo: "Passwords do not match"
            }
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#user_changepassword')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user_changepassword",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    $(".page-loader").show();
                },
                success: function(data) {
                    if (data.status == 1) {

                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });

                        $(".page-loader").hide();
                        form.reset();

                    } else if (data.status == 0) {

                        $(".page-loader").hide();

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


    $("#step_one").validate({
        ignore: [],
        rules: {
            "access_fee": {
                required: true,
            },
            "invoice_period": {
                required: true,
            },
            "imp_electrico": {
                required: true,
            },
            "iva_number": {
                required: true,
            },
            "total_invoice_now": {
                required: true,
            },
            "annual_consumption": {
                required: true,
            },

        },
        messages: {
            access_fee: {
                required: "Este campo es obligatorio.",
            },
            invoice_period: {
                required: "Este campo es obligatorio.",
            },
            imp_electrico: {
                required: "Este campo es obligatorio.",
            },
            iva_number: {
                required: "Este campo es obligatorio.",
            },
            total_invoice_now: {
                required: "Este campo es obligatorio.",
            },
            annual_consumption: {
                required: "Este campo es obligatorio.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#step_one')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user/comparissor/step_one",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    // Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#progressBar .progress-bar').css('width', percentComplete + '%');
                            $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                            $('#progressBar .progress-bar').text(percentComplete + '%');
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: function () {
                    $('#progressBar .progress-bar').css('width', '0%');
                    $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                    $('#progressBar .progress-bar').text('0%');

                    $('#progressBar').show();
                },
                success: function(data) {
                    if (data.status == 1) {

                        $("#step_one").addClass("d-none")
                        $("#step_two").removeClass("d-none")
                        $(".append_table").html(data.comparissor_step_two_html);

                        $('#progressBar').hide();

                    } else if (data.status == 0) {

                        $(".page-loader").hide();

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

    $("#step_two").validate({
        ignore: [],
        rules: {

        },
        messages: {

        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#step_two')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            if($("#price_id").val()==''){
                Swal.fire({
                    title: 'Alerta',
                    text: 'Por favor seleccione oferta',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }else{
                $.ajax({
                    url: base_url + "/user/comparissor/step_two",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();

                        // Upload progress
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $('#progressBar .progress-bar').css('width', percentComplete + '%');
                                $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                                $('#progressBar .progress-bar').text(percentComplete + '%');
                            }
                        }, false);

                        return xhr;
                    },
                    beforeSend: function () {
                        $('#progressBar .progress-bar').css('width', '0%');
                        $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                        $('#progressBar .progress-bar').text('0%');

                        $('#progressBar').show();
                    },
                    success: function(data) {
                        if (data.status == 1) {

                            $("#step_two").addClass("d-none")
                            $("#step_three").removeClass("d-none")
                            $(".step_three").html(data.comparissor_step_two_html);

                            $('#progressBar').hide();

                        } else if (data.status == 0) {

                            $(".page-loader").hide();

                            Swal.fire({
                                title: 'Error',
                                text: data.msg,
                                icon: 'warning',
                            });

                        }
                    }
                });
            }


        }
    });


    $("#index_step_one").validate({
        ignore: [],
        rules: {
            "index_invoice_period": {
                required: true,
            },
            "year": {
                required: true,
            },
        },
        messages: {
            index_invoice_period: {
                required: "Este campo es obligatorio.",
            },
            year: {
                required: "Este campo es obligatorio.",
            },

        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#index_step_one')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user/comparissor/index_step_one",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    // Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#progressBar .progress-bar').css('width', percentComplete + '%');
                            $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                            $('#progressBar .progress-bar').text(percentComplete + '%');
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: function () {
                    $('#progressBar .progress-bar').css('width', '0%');
                    $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                    $('#progressBar .progress-bar').text('0%');

                    $('#progressBar').show();
                },
                success: function(data) {
                    if (data.status == 1) {

                        $("#index_step_one").addClass("d-none")
                        $("#index_step_two").removeClass("d-none")
                        $(".index_step_two").html(data.index_step_two_html);

                        $('#progressBar').hide();

                    } else if (data.status == 0) {

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


    $("#index_step_two").validate({
        ignore: [],
        rules: {
            "access_fee": {
                required: true,
            },
            "invoice_period": {
                required: true,
            },
            "imp_electrico": {
                required: true,
            },
            "iva_number": {
                required: true,
            },
            "total_invoice_now": {
                required: true,
            },
            "annual_consumption": {
                required: true,
            },
        },
        messages: {
            access_fee: {
                required: "Este campo es obligatorio.",
            },
            invoice_period: {
                required: "Este campo es obligatorio.",
            },
            imp_electrico: {
                required: "Este campo es obligatorio.",
            },
            iva_number: {
                required: "Este campo es obligatorio.",
            },
            total_invoice_now: {
                required: "Este campo es obligatorio.",
            },
            annual_consumption: {
                required: "Este campo es obligatorio.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#index_step_two')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user/comparissor/index_step_two",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    // Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#progressBar .progress-bar').css('width', percentComplete + '%');
                            $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                            $('#progressBar .progress-bar').text(percentComplete + '%');
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: function () {
                    $('#progressBar .progress-bar').css('width', '0%');
                    $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                    $('#progressBar .progress-bar').text('0%');

                    $('#progressBar').show();
                },
                success: function(data) {
                    if (data.status == 1) {

                        $("#index_step_two").addClass("d-none");
                        $("#index_step_three").removeClass("d-none");
                        $(".append_table").html(data.index_step_three_html);

                        $('#progressBar').hide();

                    } else if (data.status == 0) {

                        $('#progressBar').hide();

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

    $("#index_step_three").validate({
        ignore: [],
        rules: {

        },
        messages: {

        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#index_step_three')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            if($("#price_id").val()==''){
                Swal.fire({
                    title: 'Alerta',
                    text: 'Por favor seleccione oferta',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }else{
                $.ajax({
                    url: base_url + "/user/comparissor/index_step_three",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();

                        // Upload progress
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $('#progressBar .progress-bar').css('width', percentComplete + '%');
                                $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                                $('#progressBar .progress-bar').text(percentComplete + '%');
                            }
                        }, false);

                        return xhr;
                    },
                    beforeSend: function () {
                        $('#progressBar .progress-bar').css('width', '0%');
                        $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                        $('#progressBar .progress-bar').text('0%');

                        $('#progressBar').show();
                    },
                    success: function(data) {
                        if (data.status == 1) {

                            $("#index_step_three").addClass("d-none")
                            $("#index_step_four").removeClass("d-none")
                            $(".index_step_four").html(data.index_step_three_html);

                            $('#progressBar').hide();

                        } else if (data.status == 0) {

                            $(".progressBar").hide();

                            Swal.fire({
                                title: 'Error',
                                text: data.msg,
                                icon: 'warning',
                            });

                        }
                    }
                });
            }


        }
    });


    $("#quoteForm").validate({
        ignore: [],
        rules: {

        },
        messages: {

        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#quoteForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url + "/user/quote_store",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function () {
                    $('#categoryBtn').html('Espere por favor...');
                    $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data) {
                    if (data.status == 1) {

                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });

                        $('#categoryBtn').html('Tramitar Contrato');
                        $("#categoryBtn").prop("disabled", false);

                        window.location.href = base_url+"/user/quote-history";

                    } else if (data.status == 0) {

                        Swal.fire({
                            title: 'Error',
                            text: data.msg,
                            icon: 'warning',
                        });

                        $('#categoryBtn').html('Tramitar Contrato');
                        $("#categoryBtn").prop("disabled", false);

                    }
                }
            });

        }
    });

    $("#user-update-form").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
            },
            street: {
                required: true,
            },
            city: {
                required: true,
            },
            state: {
                required: true,
            },
            zip_code: {
                required: true,
            },
            user_id: {
                required: true,
            },
            admin_img: {
                // required: true,
                extension: "png,jpg,jpeg,gif",
                maxsize: 1024 * 1024
            },
        },
        messages: {
            name: {
                required: "Este campo es obligatorio.",
            },
            phone: {
                required: "Este campo es obligatorio.",
            },
            street: {
                required: "Este campo es obligatorio.",
            },
            city: {
                required: "Este campo es obligatorio.",
            },
            state: {
                required: "Este campo es obligatorio.",
            },
            zip_code: {
                required: "Este campo es obligatorio.",
            },
            user_id: {
                required: "Este campo es obligatorio.",
            },
            admin_img: {
                // required: "Este campo es obligatorio.",
                extension: "Solo se permiten archivos .png, .jpg, .jpeg, .gif.",
                maxsize: "El tamaño máximo permitido es 1MB.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#user-update-form')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url + "/user/update-account-data",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    $('#apy_btn').html('Espere por favor...');
                    $('#apy_btn').attr('disabled', 'disabled');
                },
                success: function(data) {
                    console.log("object", data);
                    if (data.status == 1) {

                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });

                        $('#apy_btn').html('Actualizar');
                        $("#apy_btn").prop("disabled", false);
                        form.reset();

                        window.location.href = base_url + "/user/my-account";

                    } else if (data.status == 0) {

                        $('#apy_btn').html('Actualizar');
                        $("#apy_btn").prop("disabled", false);

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


    // gas start

    $("#step_one_fixed").validate({
        ignore: [],
        rules: {
            "access_fee": {
                required: true,
            },
            "invoice_period": {
                required: true,
            },
            "imp_electrico": {
                required: true,
            },
            "iva_number": {
                required: true,
            },
            "total_invoice_now": {
                required: true,
            },
            "annual_consumption": {
                required: true,
            },

        },
        messages: {
            access_fee: {
                required: "Este campo es obligatorio.",
            },
            invoice_period: {
                required: "Este campo es obligatorio.",
            },
            imp_electrico: {
                required: "Este campo es obligatorio.",
            },
            iva_number: {
                required: "Este campo es obligatorio.",
            },
            total_invoice_now: {
                required: "Este campo es obligatorio.",
            },
            annual_consumption: {
                required: "Este campo es obligatorio.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#step_one_fixed')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user/comparissor/gas/step_one_fixed",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    // Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#progressBar .progress-bar').css('width', percentComplete + '%');
                            $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                            $('#progressBar .progress-bar').text(percentComplete + '%');
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: function () {
                    $('#progressBar .progress-bar').css('width', '0%');
                    $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                    $('#progressBar .progress-bar').text('0%');

                    $('#progressBar').show();
                },
                success: function(data) {
                    if (data.status == 1) {

                        $("#step_one_fixed").addClass("d-none")
                        $("#step_two_fixed").removeClass("d-none")
                        $(".append_table").html(data.comparissor_step_two_html);

                        $('#progressBar').hide();

                    } else if (data.status == 0) {

                        $(".page-loader").hide();

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

    $("#step_two_fixed").validate({
        ignore: [],
        rules: {

        },
        messages: {

        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#step_two_fixed')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            if($("#price_id").val()==''){
                Swal.fire({
                    title: 'Alerta',
                    text: 'Por favor seleccione oferta',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }else{
                $.ajax({
                    url: base_url + "/user/comparissor/gas/step_two_fixed",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();

                        // Upload progress
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $('#progressBar .progress-bar').css('width', percentComplete + '%');
                                $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                                $('#progressBar .progress-bar').text(percentComplete + '%');
                            }
                        }, false);

                        return xhr;
                    },
                    beforeSend: function () {
                        $('#progressBar .progress-bar').css('width', '0%');
                        $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                        $('#progressBar .progress-bar').text('0%');

                        $('#progressBar').show();
                    },
                    success: function(data) {
                        if (data.status == 1) {

                            $("#step_two_fixed").addClass("d-none")
                            $("#step_three_fixed").removeClass("d-none")
                            $(".step_three_fixed").html(data.comparissor_step_two_html);

                            $('#progressBar').hide();

                        } else if (data.status == 0) {

                            $(".page-loader").hide();

                            Swal.fire({
                                title: 'Error',
                                text: data.msg,
                                icon: 'warning',
                            });

                        }
                    }
                });
            }


        }
    });

    // gas index start

    $("#gas_index_step_one").validate({
        ignore: [],
        rules: {
            "index_invoice_period": {
                required: true,
            },
            "year": {
                required: true,
            },
        },
        messages: {
            index_invoice_period: {
                required: "Este campo es obligatorio.",
            },
            year: {
                required: "Este campo es obligatorio.",
            },

        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#gas_index_step_one')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user/comparissor/gas/index_step_one",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    // Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#progressBar .progress-bar').css('width', percentComplete + '%');
                            $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                            $('#progressBar .progress-bar').text(percentComplete + '%');
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: function () {
                    $('#progressBar .progress-bar').css('width', '0%');
                    $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                    $('#progressBar .progress-bar').text('0%');

                    $('#progressBar').show();
                },
                success: function(data) {
                    if (data.status == 1) {

                        $("#gas_index_step_one").addClass("d-none")
                        $("#gas_index_step_two").removeClass("d-none")
                        $(".gas_index_step_two").html(data.index_step_two_html);

                        $('#progressBar').hide();

                    } else if (data.status == 0) {

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

    $("#gas_index_step_two").validate({
        ignore: [],
        rules: {
            "access_fee": {
                required: true,
            },
            "invoice_period": {
                required: true,
            },
            "imp_electrico": {
                required: true,
            },
            "iva_number": {
                required: true,
            },
            "total_invoice_now": {
                required: true,
            },
            "annual_consumption": {
                required: true,
            },
        },
        messages: {
            access_fee: {
                required: "Este campo es obligatorio.",
            },
            invoice_period: {
                required: "Este campo es obligatorio.",
            },
            imp_electrico: {
                required: "Este campo es obligatorio.",
            },
            iva_number: {
                required: "Este campo es obligatorio.",
            },
            total_invoice_now: {
                required: "Este campo es obligatorio.",
            },
            annual_consumption: {
                required: "Este campo es obligatorio.",
            },
        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#gas_index_step_two')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            $.ajax({
                url: base_url + "/user/comparissor/gas/index_step_two",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();

                    // Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#progressBar .progress-bar').css('width', percentComplete + '%');
                            $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                            $('#progressBar .progress-bar').text(percentComplete + '%');
                        }
                    }, false);

                    return xhr;
                },
                beforeSend: function () {
                    $('#progressBar .progress-bar').css('width', '0%');
                    $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                    $('#progressBar .progress-bar').text('0%');

                    $('#progressBar').show();
                },
                success: function(data) {
                    if (data.status == 1) {

                        $("#gas_index_step_two").addClass("d-none");
                        $("#gas_index_step_three").removeClass("d-none");
                        $(".append_table").html(data.index_step_three_html);

                        $('#progressBar').hide();

                    } else if (data.status == 0) {

                        $('#progressBar').hide();

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

    $("#gas_index_step_three").validate({
        ignore: [],
        rules: {

        },
        messages: {

        },
        errorElement: 'span',
        submitHandler: function(form) {

            var form = $('#gas_index_step_three')[0];
            var formData = new FormData(form);
            event.preventDefault();

            console.log(formData);

            if($("#price_id").val()==''){
                Swal.fire({
                    title: 'Alerta',
                    text: 'Por favor seleccione oferta',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }else{
                $.ajax({
                    url: base_url + "/user/comparissor/gas/index_step_three",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();

                        // Upload progress
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $('#progressBar .progress-bar').css('width', percentComplete + '%');
                                $('#progressBar .progress-bar').attr('aria-valuenow', percentComplete);
                                $('#progressBar .progress-bar').text(percentComplete + '%');
                            }
                        }, false);

                        return xhr;
                    },
                    beforeSend: function () {
                        $('#progressBar .progress-bar').css('width', '0%');
                        $('#progressBar .progress-bar').attr('aria-valuenow', '0');
                        $('#progressBar .progress-bar').text('0%');

                        $('#progressBar').show();
                    },
                    success: function(data) {
                        if (data.status == 1) {

                            $("#gas_index_step_three").addClass("d-none")
                            $("#gas_index_step_four").removeClass("d-none")
                            $(".gas_index_step_four").html(data.index_step_three_html);

                            $('#progressBar').hide();

                        } else if (data.status == 0) {

                            $(".progressBar").hide();

                            Swal.fire({
                                title: 'Error',
                                text: data.msg,
                                icon: 'warning',
                            });

                        }
                    }
                });
            }


        }
    });


    $(".isnumber").keydown(function(e) {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || 65 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || 67 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || 88 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || e.keyCode >= 35 && e.keyCode <= 39 || (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.preventDefault()
    });


    $('.hired_potency_section').on('keyup', '.hired_potencyp1, .hired_potencyp2, .hired_potencyp3, .hired_potencyp4, .hired_potencyp5, .hired_potencyp6', function() {
        var index = $(this).index('.hired_potency_section .calculate-box .value-box .input-group input');
        index++;
        var hired_potencyp = parseFloat($(this).val());
        if (isNaN(hired_potencyp)) {
            hired_potencyp = 0;
        }
        var total_days = $("#total_days").val();
        if(total_days==''){
            total_days = 0;
        }
        var price_potencyp = parseFloat($('.price_potencyp' + index).text());
        var potency_amount_offer = hired_potencyp * price_potencyp * total_days;
        $('.potency_amount_offerp' + index).text(potency_amount_offer.toFixed(2));

        potencyAmountOfferSum();
        energyAmountOfferSum();
        totalSimulatedInvoice();
        estimatedAnualSave();
    });

    $('.energy_consumed_section').on('keyup', '.energy_consumedp1, .energy_consumedp2, .energy_consumedp3, .energy_consumedp4, .energy_consumedp5, .energy_consumedp6', function() {
        var index = $(this).index('.energy_consumed_section .calculate-box .value-box .input-group input');
        index++;
        var energy_consumed = parseFloat($(this).val());
        if (isNaN(energy_consumed)) {
            energy_consumed = 0;
        }
        var price_energyp = parseFloat($('.price_energyp' + index).text());
        var energy_amount_offer = energy_consumed * price_energyp;
        $('.energy_amount_offerp' + index).text(energy_amount_offer.toFixed(2));

        potencyAmountOfferSum();
        energyAmountOfferSum();
        totalSimulatedInvoice();
        estimatedAnualSave();
    });

    $('.imp_electrico').on('keyup', function() {
        var imp_electrico = parseFloat($(this).val());
        if (isNaN(imp_electrico)) {
            imp_electrico = 0;
        }
        var total_potency_amount_offer = parseFloat($('#total_potency_amount_offer').val());
        var total_energy_amount_offer = parseFloat($('#total_energy_amount_offer').val());
        var total_sum = total_potency_amount_offer + total_energy_amount_offer;
        var result = total_sum / 100 * imp_electrico;
        $("#imp_electrico_input").val(result.toFixed(2));
        $(".imp_electrico_show").html(result.toFixed(2)+ ' €');
        totalSimulatedInvoice();
        estimatedAnualSave();
    });

    $('.iva_number').on('keyup', function() {
        var iva = parseFloat($(this).val());
        if (isNaN(iva)) {
            iva = 0;
        }
        var total_potency_amount_offer = parseFloat($('#total_potency_amount_offer').val());
        var total_energy_amount_offer = parseFloat($('#total_energy_amount_offer').val());
        var imp_electrico_input = parseFloat($('#imp_electrico_input').val());
        var total_sum = total_potency_amount_offer + total_energy_amount_offer + imp_electrico_input;
        var result = total_sum / 100 * iva;
        $("#iva_input").val(result.toFixed(2));
        $(".iva_show").html(result.toFixed(2)+ ' €');
        totalSimulatedInvoice();
        estimatedAnualSave();
    });

    $('.other_number').on('keyup', function() {
        var other_number = parseFloat($(this).val());
        if (isNaN(other_number)) {
            other_number = 0;
        }
        $("#other_number").val(other_number);
        totalSimulatedInvoice();
        estimatedAnualSave();
    });

    $('.alquiler_contador').on('keyup', function() {
        var alquiler_contador = parseFloat($(this).val());
        if (isNaN(alquiler_contador)) {
            alquiler_contador = 0;
        }
        $("#alquiler_contador").val(alquiler_contador);
        totalSimulatedInvoice();
        estimatedAnualSave();
    });

    $('.rdl_number').on('keyup', function() {
        var rdl_number = parseFloat($(this).val());
        if (isNaN(rdl_number)) {
            rdl_number = 0;
        }
        $("#rdl_number").val(rdl_number);
        totalSimulatedInvoice();
        estimatedAnualSave();
    });

    $('.total_invoice_now').on('keyup', function() {
        var total_invoice_now = parseFloat($(this).val());
        if (isNaN(total_invoice_now)) {
            total_invoice_now = 0;
        }
        $("#total_invoice_now").val(total_invoice_now);
        estimatedAnualSave();
    });


    // document.getElementById('imgUpload').addEventListener('change', function(event) {
    //     let file = event.target.files[0];
    //     if (!file) return;
    
    //     let formData = new FormData();
    //     formData.append('file', file); 
    
    //     $.ajax({
    //         url: base_url + '/user/extract-pdf',
    //         type: 'POST',
    //         data: formData,
    //         contentType: false,  
    //         processData: false,
    //         beforeSend: function() {
    //             $('.loader-wrap').show();
    //         },
    //         success: function(data) {
    //             $('.loader-wrap').hide();
    
    //             if (data.status == 1) {
    //                 Swal.fire({
    //                     title: 'Success',
    //                     text: data.msg,
    //                     icon: 'success',
    //                 });
    //                 location.reload();
    //             } else if (data.status == 0) {
    //                 Swal.fire({
    //                     title: 'Error',
    //                     text: data.msg,
    //                     icon: 'error',
    //                 });
    //                 // location.reload();
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             $('.loader-wrap').hide();
    //             Swal.fire({
    //                 title: 'Error',
    //                 text: 'Something went wrong while uploading the file.',
    //                 icon: 'error',
    //             });
    //             // location.reload();
    //             console.error(error);
    //         }
    //     });
    // });

    document.getElementById('imgUpload').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (!file) return;
    
        let formData = new FormData();
        formData.append('file', file); 
    
        $.ajax({
            url: base_url + '/user/extract-pdf',
            type: 'POST',
            data: formData,
            contentType: false,  
            processData: false,
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
    
                // Track upload progress
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = (evt.loaded / evt.total) * 70; 
                        // cap upload at 70%
                        document.getElementById("loader-container-pdf-data-wrap").style.display = "flex"; 
                        document.getElementById("progress-pdf-data").style.width = percentComplete + "%";
                    }
                }, false);
    
                return xhr;
            },
            beforeSend: function() {
                document.getElementById("loader-container-pdf-data-wrap").style.display = "flex";
                document.querySelector(".loader-text-pdf-data").innerText = "Cargando...";
                document.querySelector(".progress-desc-pdf-data").innerText =
                  "Analizando PDF para extraer todos los datos, en pocos segundos lo tienes.";
                document.getElementById("progress-pdf-data").style.width = "0%";
            },
            success: function(data) {
                // Fill to 100% once server responds
                document.getElementById("progress-pdf-data").style.width = "100%";
    
                if (data.status == 1) {
                    document.querySelector(".loader-text-pdf-data").innerText = "Completado!";
                    document.querySelector(".progress-desc-pdf-data").innerText = "PDF analizado con éxito.";
    
                    // Swal.fire({
                    //     title: 'Success',
                    //     text: data.msg,
                    //     icon: 'success',
                    // }).then(() => {
                    //     location.reload();
                    // });
                    location.reload();
                } else {
                    document.getElementById("loader-container-pdf-data-wrap").style.display = "none";
                    Swal.fire({
                        title: 'Error',
                        text: data.msg,
                        icon: 'error',
                    });
                }
            },
            error: function(xhr, status, error) {
                document.getElementById("loader-container-pdf-data-wrap").style.display = "none";
                Swal.fire({
                    title: 'Error',
                    text: 'Something went wrong while uploading the file.',
                    icon: 'error',
                });
                console.error(error);
            }
        });
    });


});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.querySelectorAll('.only_number').forEach(function (input) {
    input.addEventListener('input', function () {
        let value = this.value;
        value = value.replace(/[^0-9.,]/g, '');
        const parts = value.split(',');
        if (parts.length > 2) {
            value = parts[0] + ',' + parts.slice(1).join('');
        }
        const dotParts = value.split('.');
        if (dotParts.length > 2) {
            value = dotParts[0] + '.' + dotParts.slice(1).join('');
        }
        this.value = value;
    });
});

window.OpenRegisterModal = function(package_id, package_price) {
    localStorage.setItem('pack', package_id);

    var package_title = $(".package_title"+package_id).text();
    // var package_price = $(".package_price"+package_id).text();

    $(".pack_details").html(package_title +' ('+package_price+'&#8364;)');
    const myModal = document.getElementById('registerModel');
    const modal = new Modal(myModal);
    modal.show();
}

// window.renewModal = function(package_id, package_price) {
//     localStorage.setItem('pack', package_id);

//     var package_title = $(".package_title"+package_id).text();

//     $(".pack_details").html(package_title +' ('+package_price+'&#8364;)');
//     const myModal = document.getElementById('renewModel');
//     const modal = new Modal(myModal);
//     modal.show();
// }

window.renewModal = function(package_id, package_price) {
    
    $.ajax({
        url: base_url + '/user/getstriperenewlink',
        type: 'POST',
        data: {
            'package_id': package_id,
        },
        beforeSend: function() {
            $(".loader-wrap").show();
        },
        success: function(data) {

            if(data.status == 1){

                window.location.href= data.redrict_url;

            }else if(data.status == 0) {
                $(".loader-wrap").hide();
            }
        }
    });
    
}

window.modifyInput = function(ele) {
    if (ele.value.length === 2){
        ele.value = ele.value + '/';
    }else if (ele.value.length === 3 && ele.value.charAt(2) === '/'){
        ele.value = ele.value.replace('/', '');
    }
}

window.companyOffers = function(offer_id) {
    if(offer_id!=''){
        $("#offer_id").val(offer_id);
        getfixedPrice();
    }
}

window.companyAccessfee = function(accessfee_id) {
    if(accessfee_id!=''){
        $("#accessfee_id").val(accessfee_id);
        getfixedPrice();
    }
}

window.getfixedPrice = function() {
    var offer_id = $("#offer_id").val();
    var accessfee_id = $("#accessfee_id").val();

    if(offer_id !== '' && accessfee_id !== ''){
        var company_id  = $("#company_id").val();
        $.ajax({
            url: base_url + '/user/getfixedPrice',
            type: 'POST',
            data: {
                'offer_id': offer_id,
                'accessfee_id': accessfee_id,
                'company_id': company_id,
            },
            beforeSend: function() {

            },
            success: function(data) {

                if(data.status == 1){
                    var companyPrice = data.companyPrice;
                    $(".price_potencyp1").html(companyPrice.price_potencyp1 !== null ? companyPrice.price_potencyp1 : "0.000000");
                    $(".price_potencyp2").html(companyPrice.price_potencyp2 !== null ? companyPrice.price_potencyp2 : "0.000000");
                    $(".price_potencyp3").html(companyPrice.price_potencyp3 !== null ? companyPrice.price_potencyp3 : "0.000000");
                    $(".price_potencyp4").html(companyPrice.price_potencyp4 !== null ? companyPrice.price_potencyp4 : "0.000000");
                    $(".price_potencyp5").html(companyPrice.price_potencyp5 !== null ? companyPrice.price_potencyp5 : "0.000000");
                    $(".price_potencyp6").html(companyPrice.price_potencyp6 !== null ? companyPrice.price_potencyp6 : "0.000000");

                    $(".price_energyp1").html(companyPrice.price_energyp1 !== null ? companyPrice.price_energyp1 : "0.000000");
                    $(".price_energyp2").html(companyPrice.price_energyp2 !== null ? companyPrice.price_energyp2 : "0.000000");
                    $(".price_energyp3").html(companyPrice.price_energyp3 !== null ? companyPrice.price_energyp3 : "0.000000");
                    $(".price_energyp4").html(companyPrice.price_energyp4 !== null ? companyPrice.price_energyp4 : "0.000000");
                    $(".price_energyp5").html(companyPrice.price_energyp5 !== null ? companyPrice.price_energyp5 : "0.000000");
                    $(".price_energyp6").html(companyPrice.price_energyp6 !== null ? companyPrice.price_energyp6 : "0.000000");

                    autoKeyupcall();
                    potencyAmountOfferSum();
                    energyAmountOfferSum();
                    totalSimulatedInvoice();
                    estimatedAnualSave();

                }else if(data.status == 0) {

                }
            }
        });

    }
}

window.autoKeyupcall = function() {
    $('.hired_potencyp1').keyup();
    $('.hired_potencyp2').keyup();
    $('.hired_potencyp3').keyup();
    $('.hired_potencyp4').keyup();
    $('.hired_potencyp5').keyup();
    $('.hired_potencyp6').keyup();

    $('.energy_consumedp1').keyup();
    $('.energy_consumedp2').keyup();
    $('.energy_consumedp3').keyup();
    $('.energy_consumedp4').keyup();
    $('.energy_consumedp5').keyup();
    $('.energy_consumedp6').keyup();

    $('.imp_electrico').keyup();
    $('.iva_number').keyup();

    $('.other_number').keyup();
    $('.alquiler_contador').keyup();
    $('.rdl_number').keyup();
    $('.total_invoice_now').keyup();

}


window.potencyAmountOfferSum = function() {
    var sum = 0;
    $('.potency_amount_offerp1, .potency_amount_offerp2, .potency_amount_offerp3, .potency_amount_offerp4, .potency_amount_offerp5, .potency_amount_offerp6').each(function() {
        sum += parseFloat($(this).text());
    });
    $('#total_potency_amount_offer').val(sum.toFixed(2));
}

window.energyAmountOfferSum = function() {
    var sum = 0;
    $('.energy_amount_offerp1, .energy_amount_offerp2, .energy_amount_offerp3, .energy_amount_offerp4, .energy_amount_offerp5, .energy_amount_offerp6').each(function() {
        sum += parseFloat($(this).text());
    });
    $('#total_energy_amount_offer').val(sum.toFixed(2));
}

window.totalSimulatedInvoice = function() {

    var total_potency_amount_offer = parseFloat($("#total_potency_amount_offer").val());
    var total_energy_amount_offer = parseFloat($("#total_energy_amount_offer").val());
    var imp_electrico_input = parseFloat($("#imp_electrico_input").val());
    var iva_input = parseFloat($("#iva_input").val());
    var other_number = parseFloat($("#other_number").val());
    var alquiler_contador = parseFloat($("#alquiler_contador").val());
    var rdl_number = parseFloat($("#rdl_number").val());

    var total = total_potency_amount_offer + total_energy_amount_offer + imp_electrico_input + iva_input + other_number + alquiler_contador + rdl_number;

    $("#totalSimulatedInvoice_input").val(total.toFixed(2));
    $(".totalSimulatedInvoice_show").html(total.toFixed(2) + ' €');

}

window.estimatedAnualSave = function() {
    var total_days = $("#total_days").val();
    if(total_days==''){
        total_days = 0;
    }
    var total_invoice_now = parseFloat($("#total_invoice_now").val());
    var totalSimulatedInvoice_input = parseFloat($("#totalSimulatedInvoice_input").val());

    var totalanual = (total_invoice_now-totalSimulatedInvoice_input)/total_days*365;

    $(".estimated_anual_save_show").html(totalanual.toFixed(2) + ' €');
    $("#estimated_anual_save_input").val(totalanual.toFixed(2));
}

window.stepThreeBackBtn = function() {
    $("#step_three").addClass("d-none");
    $("#step_two").removeClass("d-none");
}

window.stepTwoBackBtn = function() {
    $("#step_two").addClass("d-none");
    $("#step_one").removeClass("d-none");
}

window.tramitar_btn = function(comparisons_type) {

    let text_notes = [];

    $('.other-calculate-note p').each(function () {
        if ($(this).attr('class')?.includes('text_notes_')) {
            text_notes.push($(this).text().trim());
        }
    });

    $.ajax({
        url: base_url + '/user/save_comparisons_history',
        type: 'POST',
        data: {
            'company_id': $("#company_id").val(),
            'offer': $("#offer").val(),
            'hired_potencyp1': $(".hired_potencyp1").text(),
            'hired_potencyp2': $(".hired_potencyp2").text(),
            'hired_potencyp3': $(".hired_potencyp3").text(),
            'hired_potencyp4': $(".hired_potencyp4").text(),
            'hired_potencyp5': $(".hired_potencyp5").text(),
            'hired_potencyp6': $(".hired_potencyp6").text(),
            'price_potencyp1': $(".price_potencyp1").text(),
            'price_potencyp2': $(".price_potencyp2").text(),
            'price_potencyp3': $(".price_potencyp3").text(),
            'price_potencyp4': $(".price_potencyp4").text(),
            'price_potencyp5': $(".price_potencyp5").text(),
            'price_potencyp6': $(".price_potencyp6").text(),
            'potency_amount_offerp1': $(".potency_amount_offerp1").text(),
            'potency_amount_offerp2': $(".potency_amount_offerp2").text(),
            'potency_amount_offerp3': $(".potency_amount_offerp3").text(),
            'potency_amount_offerp4': $(".potency_amount_offerp4").text(),
            'potency_amount_offerp5': $(".potency_amount_offerp5").text(),
            'potency_amount_offerp6': $(".potency_amount_offerp6").text(),
            'energy_consumedp1': $(".energy_consumedp1").text(),
            'energy_consumedp2': $(".energy_consumedp2").text(),
            'energy_consumedp3': $(".energy_consumedp3").text(),
            'energy_consumedp4': $(".energy_consumedp4").text(),
            'energy_consumedp5': $(".energy_consumedp5").text(),
            'energy_consumedp6': $(".energy_consumedp6").text(),
            'price_energyp1': $(".price_energyp1").text(),
            'price_energyp2': $(".price_energyp2").text(),
            'price_energyp3': $(".price_energyp3").text(),
            'price_energyp4': $(".price_energyp4").text(),
            'price_energyp5': $(".price_energyp5").text(),
            'price_energyp6': $(".price_energyp6").text(),
            'energy_amount_offerp1': $(".energy_amount_offerp1").text(),
            'energy_amount_offerp2': $(".energy_amount_offerp2").text(),
            'energy_amount_offerp3': $(".energy_amount_offerp3").text(),
            'energy_amount_offerp4': $(".energy_amount_offerp4").text(),
            'energy_amount_offerp5': $(".energy_amount_offerp5").text(),
            'energy_amount_offerp6': $(".energy_amount_offerp6").text(),
            'other_number': $(".other_number").text(),
            'alquiler_contador': $(".alquiler_contador").text(),
            'rdl_number': $(".rdl_number").text(),
            'imp_electrico': $(".imp_electrico").text(),
            'imp_electrico_result': $(".imp_electrico_result").text(),
            'iva_result': $(".iva_result").text(),
            'iva_number': $(".iva_number").text(),
            'total_invoice_now': $(".total_invoice_now").text(),
            'totalSimulatedInvoice': $(".totalSimulatedInvoice").text(),
            'estimated_anual_save': $(".estimated_anual_save").text(),
            'user_name': $(".user_name").text(),
            'user_cups': $(".user_cups").text(),
            'user_name_offer': $(".user_name_offer").text(),
            'comparisons_type': comparisons_type,
            'final_commission': $(".final_commission").val(),
            'comparissor_sub_type': $(".comparissor_sub_type").text(),
            'text_notes': text_notes,
        },
        beforeSend: function() {
            $(".loader-wrap").show();
        },
        success: function(data) {

            if(data.status == 1){
                // window.open('https://tramitatucontrato.energy/', '_blank');
                // window.location.href = 'https://tramitatucontrato.energy';
                Swal.fire({
                    title: 'Success',
                    text: 'GUARDADO',
                    icon: 'success',
                });
                $(".loader-wrap").hide();
            }else if(data.status == 0) {
                $(".loader-wrap").hide();
            }
        }
    });


}

window.monthChnage = function(val) {
    if(val!=''){
        $("#month").val(val);
        getIndexPricedata();
    }

}

window.yearChange = function(val) {
    if(val!=''){
        $("#year").val(val);
        getIndexPricedata();
    }
}

window.getIndexPricedata = function() {
    var month = $("#month").val();
    var year = $("#year").val();

    if(month!='' && year!=''){

        $.ajax({
            url: base_url + '/user/getIndexPricedata',
            type: 'POST',
            data: {
                'month': month,
                'year': year,
            },
            beforeSend: function() {

            },
            success: function(data) {

                if(data.status == 1){
                    $(".indexdatabody").html(data.step_one_html);
                    $(".indexStepOneBtn").prop("disabled", false);
                    $(".indexStepOneBtn").attr("type", "submit");
                }else if(data.status == 0) {
                    $(".indexdatabody").html('');
                    $(".indexStepOneBtn").prop("disabled", true);
                    $(".indexStepOneBtn").attr("type", "button");
                }
            }
        });

    }
}

window.indexStepTwoBackBtn = function() {
    $("#index_step_one").removeClass("d-none")
    $("#index_step_two").addClass("d-none")
}

window.indexstepThreeBackBtn = function() {
    $("#index_step_three").addClass("d-none");
    $("#index_step_two").removeClass("d-none");
}

window.indexStepfourBackBtn = function() {
    $("#index_step_four").addClass("d-none");
    $("#index_step_three").removeClass("d-none");
}

window.getconuseContent = function(id) {
    $.ajax({
        url: base_url + '/user/getconuseContent',
        type: 'POST',
        data: {
            'id': id,
        },
        beforeSend: function() {
            $(".loader-wrap").show();
        },
        success: function(data) {

            if(data.status == 1){

                $(".sider_manu").removeClass("sider-manu-wrap");
                $(".hamburger-box").removeClass("active");

                $(".course-details-show").html(data.html);
                // if(data.type=='video'){
                //     const container = document.getElementById('container')
                //     const url = data.doc_file;
                //     renderReactPlayer(container, { url, playing: true, controls:true, height:'100%', width:'100%'});
                //     $(".course-details-show").html(`<div id='container' style="height: 100%; width:100%"></div>`);
                // }

                // if(data.type=='pdf'){
                //     $(".course-details-show").html(`<object class="pdf-view" data="${data.doc_file}" width="100%" height="100%"></object>`);
                // }

                $(".loader-wrap").hide();

            }else if(data.status == 0) {
                $(".loader-wrap").hide();
            }
        }
    });
}


window.courseBuy = function(course_id) {
    localStorage.setItem('course_id', course_id);

    var course_title = $(".course_title"+course_id).text();
    var course_price = $(".course_price"+course_id).text();


    $.ajax({
        url: base_url + '/user/getstripepopup',
        type: 'POST',
        data: {
            'course_id': course_id,
        },
        beforeSend: function() {
            $(".loader-wrap").show();
        },
        success: function(data) {

            if(data.status == 1){

                // const myModal = document.getElementById('coursebuyModel');
                // const modal = new Modal(myModal);
                // modal.show();

                // $("#stripe_modal_body").html(data.html);
                // $(".course_details").html(course_title +' ('+course_price+')');

                window.location.href= data.redrict_url;

            }else if(data.status == 0) {
                $(".loader-wrap").hide();
            }
        }
    });


}

window.cancelMembership = function(plan_id) {

    Swal.fire({
        title: 'Are you sure',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, CANCELAR PLAN',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                url: base_url + '/user/cancelMembership',
                type: 'POST',
                data: {
                    'plan_id': plan_id,
                },
                beforeSend: function() {
                    $('#cancelMembership').html('Please Wait...');
                    $('#cancelMembership').attr('disabled', 'disabled');
                },
                success: function(data) {

                    if(data.status == 1){
                        $('#cancelMembership').html('Cancel Membership');
                        $("#cancelMembership").prop("disabled", false);

                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });
                        location.reload();

                    }else if(data.status == 0) {
                        $('#cancelMembership').html('Cancel Membership');
                        $("#cancelMembership").prop("disabled", false);
                    }
                }
            });
        } else {
          
        }
    })
}

window.removeCard = function(payment_method_id) {

    Swal.fire({
        title: 'Remove payment method',
        text: 'The payment method will no longer be usable after removing from the customer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + '/user/removePaymentMethod',
                type: 'POST',
                data: {
                    'payment_method_id': payment_method_id,
                },
                beforeSend: function() {
                    $('.loader-wrap').show();
                },
                success: function(data) {

                    if(data.status == 1){
                        $('.loader-wrap').hide();
                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });
                        location.reload();

                    }else if(data.status == 0) {
                        Swal.fire({
                            title: 'Error',
                            text: data.msg,
                            icon: 'error',
                        });
                        $('.loader-wrap').hide();
                    }
                }
            });
        } else {
          
        }
      })

    
}

window.makeDefaultCard = function(payment_method_id) {
    $.ajax({
        url: base_url + '/user/makeDefaultCard',
        type: 'POST',
        data: {
            'payment_method_id': payment_method_id,
        },
        beforeSend: function() {
            $('.loader-wrap').show();
        },
        success: function(data) {

            if(data.status == 1){
                $('.loader-wrap').hide();
                Swal.fire({
                    title: 'Success',
                    text: data.msg,
                    icon: 'success',
                });
                location.reload();

            }else if(data.status == 0) {
                Swal.fire({
                    title: 'Error',
                    text: data.msg,
                    icon: 'error',
                });
                $('.loader-wrap').hide();
            }
        }
    });
}


window.comparissor_system_type = function(type) {
    localStorage.setItem('comparissor_system_type', type);
}


window.stepTwoBackGasFixedBtn = function() {
    $("#step_two_fixed").addClass("d-none");
    $("#step_one_fixed").removeClass("d-none");
}

window.stepThreeGasFixedBackBtn = function() {
    $("#step_three_fixed").addClass("d-none");
    $("#step_two_fixed").removeClass("d-none");
}


window.gasIndexStepfourBackBtn = function() {
    $("#gas_index_step_four").addClass("d-none");
    $("#gas_index_step_three").removeClass("d-none");
}

window.gasIndexStepTwoBackBtn = function() {
    $("#gas_index_step_one").removeClass("d-none")
    $("#gas_index_step_two").addClass("d-none")
}

window.gasIndexstepThreeBackBtn = function() {
    $("#gas_index_step_three").addClass("d-none");
    $("#gas_index_step_two").removeClass("d-none");
}

window.deleteQuote = function(id) {
    Swal.fire({
        title: 'Estas seguro',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, Eliminar',
        cancelButtonText: '¡No, cancela!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                url: base_url + '/user/delete_quote',
                type: 'POST',
                data: {
                    'id': id,
                },
                beforeSend: function() {
                    // $('#cancelMembership').html('Please Wait...');
                    // $('#cancelMembership').attr('disabled', 'disabled');
                },
                success: function(data) {

                    if(data.status == 1){
                        Swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                        });
                        location.reload();

                    }
                }
            });
        } else {
          
        }
    })
}





























