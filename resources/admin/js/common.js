$(function() {
    "use strict";

    $("#changepasswordform").validate({

        rules : {
            password : {
                required : true,
                minlength: 6,
            },
            confirm_password : {
                required : true,
                minlength: 6,
                equalTo: "#password",
            },
        },
       messages : {

       },
       errorElement : 'span',
       submitHandler: function(form) {
            e.preventDefault();
            $("#changepasswordform").submit();
        }
    });

    $("#resetpasswordform").validate({

        rules : {
            email : {
                required : true,
            },
        },
       messages : {

       },
       errorElement : 'span',
       submitHandler: function(form) {
            e.preventDefault();
            $("#resetpasswordform").submit();
        }
    });

    $("#createcompanyForm").validate({
        ignore: [],
        rules : {
            "company_name" : {
                required : true,
            },

       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {

            var form = $('#createcompanyForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_company",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/company";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#createofferForm").validate({
        ignore: [],
        rules : {
            "company_id" : {
                required : true,
            },
            "offer" : {
                required : true,
            },
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {

            var form = $('#createofferForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_offer",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/offers";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#createAccessfeeForm").validate({
        ignore: [],
        rules : {
            "title" : {
                required : true,
            },
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {

            var form = $('#createAccessfeeForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_accessfee",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/accessfee";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#createcompanyPriceForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#createcompanyPriceForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_companyprice",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/company-price";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#uploadPriceForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#uploadPriceForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/upload_price_excel",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        if(obj.price_type=='Fixed'){
                            window.location.href = base_url+"/admin/company-price";
                        }else if(obj.price_type=='Indexed'){
                            window.location.href = base_url+"/admin/company-price-index";
                        }
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }else if(obj.status==2){
                        printErrorMsg(obj.error);
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#uploadPriceFormFixedService").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#uploadPriceFormFixedService')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/upload_price_excel_fixed_service_fee",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        if(obj.price_type=='Fixed'){
                            window.location.href = base_url+"/admin/company-price";
                        }else if(obj.price_type=='Indexed'){
                            window.location.href = base_url+"/admin/company-price-index";
                        }
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }else if(obj.status==2){
                        printErrorMsg(obj.error);
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#featuresForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#featuresForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_features",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/package_features";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#packageForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#packageForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_package",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/package";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#uploadIndexOfferForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#uploadIndexOfferForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/upload_indexoffer_excel",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/index-offers";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }else if(obj.status==2){
                        printErrorMsg(obj.error);
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#salespersonForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#salespersonForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_salesperson",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/salesperson";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#salespersonUpdateForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#salespersonUpdateForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/update_salesperson",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/salesperson";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#createcourseForm").validate({
        ignore: [],
        rules : {
            "title" : {
                required : true,
            },
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {
            var form = $('#createcourseForm')[0];
            var formData = new FormData(form);
            event.preventDefault();
            $.ajax({
                url: base_url+"/admin/store_course",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });

                        window.location.href = base_url+"/admin/course-view/"+obj.course_id;

                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#settingForm").validate({
        ignore: [],
        rules : {
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {
            var form = $('#settingForm')[0];
            var formData = new FormData(form);
            event.preventDefault();
            $.ajax({
                url: base_url+"/admin/store_setting",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });

                        window.location.href = base_url+"/admin/setting";

                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#maintenanceForm").validate({
        ignore: [],
        rules : {
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {
            var form = $('#maintenanceForm')[0];
            var formData = new FormData(form);
            event.preventDefault();
            $.ajax({
                url: base_url+"/admin/store_maintenance",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });

                        window.location.href = base_url+"/admin/maintenance";

                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#laveladdform").validate({
        ignore: [],
        rules : {
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {
            var form = $('#laveladdform')[0];
            var formData = new FormData(form);
            event.preventDefault();
            $.ajax({
                url: base_url+"/admin/store_lavel",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });

                        window.location.href = base_url+"/admin/agentlavels";

                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#stripeForm").validate({
        ignore: [],
        rules : {
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {
            var form = $('#stripeForm')[0];
            var formData = new FormData(form);
            event.preventDefault();
            $.ajax({
                url: base_url+"/admin/setting/addstripe",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtnstripe').html('Please Wait...');
                  $('#categoryBtnstripe').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });

                        window.location.href = base_url+"/admin/setting";

                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtnstripe').html('Submit');
                        $("#categoryBtnstripe").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#lavelpersentageaddform").validate({
        ignore: [],
        rules : {
       },
       messages : {
       },
       errorElement : 'span',
       submitHandler: function(form) {
            var form = $('#lavelpersentageaddform')[0];
            var formData = new FormData(form);
            event.preventDefault();
            $.ajax({
                url: base_url+"/admin/store_lavel_persentage",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });

                        window.location.href = base_url+"/admin/agentlavels";

                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#faqForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#faqForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/store_faq",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/faq";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    // gas start 

    $("#gasUploadPriceForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#gasUploadPriceForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/gas/upload_price_excel",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        if(obj.price_type=='Fixed'){
                            window.location.href = base_url+"/admin/gas/fixed-price";
                        }else if(obj.price_type=='Indexed'){
                            window.location.href = base_url+"/admin/gas/index-price";
                        }
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }else if(obj.status==2){
                        printErrorMsg(obj.error);
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $("#gascreatecompanyPriceForm").validate({
        ignore: [],
        rules : {
        },
        messages : {
        },
        errorElement : 'span',
        submitHandler: function(form) {

            var form = $('#gascreatecompanyPriceForm')[0];
            var formData = new FormData(form);
            event.preventDefault();

            $.ajax({
                url: base_url+"/admin/gas/update_fixed_price",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function(){
                  $('#categoryBtn').html('Please Wait...');
                  $('#categoryBtn').attr('disabled','disabled');
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    printErrorMsg(obj.error);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        window.location.href = base_url+"/admin/gas/fixed-price";
                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                        $('#categoryBtn').html('Submit');
                        $("#categoryBtn").prop("disabled", false);
                    }
                }
            });
        }
    });

    $('.select2').select2();

    $(".isnumber").keydown(function(e) {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || 65 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || 67 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || 88 == e.keyCode && (!0 === e.ctrlKey || !0 === e.metaKey) || e.keyCode >= 35 && e.keyCode <= 39 || (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.preventDefault()
    });

    $('#blogdesc').summernote({
        height: 500,
    });

    $('#homepage_section_three').summernote({
        height: 500,
        callbacks: {
            onImageUpload: function(image) {
                solutionsuploadImage(image[0]);
            }
        }
    });

    $('#section_four_desc').summernote({
        height: 500,
        callbacks: {
            onImageUpload: function(image) {
                solutionsuploadImage(image[0]);
            }
        }
    });

    $('#section_three_option_one').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(image) {
                solutionsuploadImage(image[0]);
            }
        }
    });
    $('#section_three_option_two').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(image) {
                solutionsuploadImage(image[0]);
            }
        }
    });
    $('#section_three_option_three').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(image) {
                solutionsuploadImage(image[0]);
            }
        }
    });

    $('#maintenance_message').summernote({
        height: 250,
        callbacks: {
            onImageUpload: function(image) {
                solutionsuploadImage(image[0]);
            }
        }
    });


});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.printErrorMsg = function(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}

window.getOfferbyCompany = function(company_id) {
    // console.log(company_id);
    $.ajax({
        url: base_url+"/getOfferbyCompany",
        type: 'POST',
        data: {'company_id':company_id},
        beforeSend:function(){
        },
        success: function(data){
            $("#offer_id").html(data);
        }
    });
}

window.edit_features = function(id, features_title) {
    $("input[name='features_title']").val(features_title);
    $("input[name='id']").val(id);
}


window.checkStatusselsperson = function(part_id, value) {

    if($("#packId_"+part_id).is(":checked")) {
        var value = 1;
    }else{
        var value = 0;
    }
        $.ajax({
                url: base_url+"/admin/checkStatusselsperson",
                type: 'POST',
                data: {'part_id':part_id, value:value},
                beforeSend:function(){
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });


                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                    }
                }
        });

}

window.checkStatusCompany = function(companyId, value) {

    if($("#companyId_"+companyId).is(":checked")) {
        var value = 1;
    }else{
        var value = 0;
    }
        $.ajax({
                url: base_url+"/admin/checkStatusCompany",
                type: 'POST',
                data: {'companyId':companyId, value:value},
                beforeSend:function(){
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });


                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                    }
                }
        });

}

window.quoteHistoryStatus = function(part_id, value) {

    if($("#userId_"+part_id).is(":checked")) {
        var value = 1;
    }else{
        var value = 0;
    }
        $.ajax({
                url: base_url+"/admin/quoteHistoryStatus",
                type: 'POST',
                data: {'part_id':part_id, value:value},
                beforeSend:function(){
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });


                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                    }
                }
        });

}

window.checkvaluePack = function(stripe_id, value) {

    if($("#value_pack_"+stripe_id).is(":checked")) {
        var value = 1;
    }else{
        var value = 0;
    }

    if (confirm("You want to set this account as a default")) {
        $.ajax({
                url: base_url+"/admin/setting/checkvalue_stripe",
                type: 'POST',
                data: {'stripe_id':stripe_id, value:value},
                beforeSend:function(){
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    if(obj.status==1){
                        $(".commoncls").prop("checked", false);
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });
                        $("#value_pack_"+stripe_id).prop("checked", true);

                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });

                        $("#value_pack_"+stripe_id).prop("checked", true);
                    }
                }
        });
    }
}

window.getstripeedit = function(stripe_id, account_name, stripe_key, stripe_secret) {

    $("#strip_id").val(stripe_id);
    $("#account_name").val(account_name);
    $("#stripe_key").val(stripe_key);
    $("#stripe_secret").val(stripe_secret);

}

window.checkCourseAmount = function(val) {

    if(val==''){
        $('#stripe_acount').removeAttr('required');
        console.log(val);
    }else{
        $('#stripe_acount').attr('required', true);
        console.log('val');
    }
}

window.addLavel = function(vabel_cat_id){
    const myModal = document.getElementById('addlabelPersentageModal');
    const modal = new Modal(myModal);
    modal.show();
    $("#label_id").val(vabel_cat_id);
}

window.lavelpersentageedit = function(id, label_id, label_name, label_percentage){
    const myModal = document.getElementById('addlabelPersentageModal');
    const modal = new Modal(myModal);
    modal.show();
    $("#id").val(id);
    $("#label_id").val(label_id);
    $("#label_name").val(label_name);
    $("#label_percentage").val(label_percentage);
}

window.laveledit= function(id, label){
    const myModal = document.getElementById('addlabelModal');
    const modal = new Modal(myModal);
    modal.show();
    $("#ids").val(id);
    $("#label").val(label);
}


window.getCommission= function(company_id){

    $.ajax({
        url: base_url+"/admin/get_commissionlist",
        type: 'POST',
        data: {'company_id':company_id},
        beforeSend:function(){
        },
        success: function(data){
            var obj=JSON.parse(data);
            if(obj.status==1){

                const myModal = document.getElementById('persentageModal');
                const modal = new Modal(myModal);
                modal.show();

                $(".appendForm").html(obj.html);

            }else if(obj.status==0){
                Swal.fire({
                    title: 'Error',
                    text: obj.msg,
                    icon: 'warning',
                });

                $("#value_pack_"+stripe_id).prop("checked", true);
            }
        }
    });
}

window.accessFeeCheck= function(value){
    // console.log("value"+value);
    if(value=='2'){
        $(".potency_type_div").show();

        // $("select[name='potency_type']").prop('required', true);
        // $(".typess").addClass('required');

    }else{
        $(".potency_type_div").hide();

        // $("select[name='potency_type']").prop('required', false);
        // $(".typess").removeClass('required');
    }
}

window.editPriceRange= function(kwh_range_id){

    $.ajax({
        url: base_url+"/admin/get_kwh_range",
        type: 'POST',
        data: {'kwh_range_id':kwh_range_id},
        beforeSend:function(){
        },
        success: function(data){
            var obj=JSON.parse(data);
            if(obj.status==1){

                const myModal = document.getElementById('editRangeModal');
                const modal = new Modal(myModal);
                modal.show();

                $(".appendForm").html(obj.html);

            }else if(obj.status==0){
                Swal.fire({
                    title: 'Error',
                    text: obj.msg,
                    icon: 'warning',
                });
            }
        }
    });
}

window.editSpecificCompanyCommission= function(id){

    $.ajax({
        url: base_url+"/admin/get_specific_company_commission",
        type: 'POST',
        data: {'id':id},
        beforeSend:function(){
        },
        success: function(data){
            var obj=JSON.parse(data);
            if(obj.status==1){

                const myModal = document.getElementById('editRangeModal');
                const modal = new Modal(myModal);
                modal.show();

                $(".appendForm").html(obj.html);

            }else if(obj.status==0){
                Swal.fire({
                    title: 'Error',
                    text: obj.msg,
                    icon: 'warning',
                });
            }
        }
    });
}

window.solutionsuploadImage = function(image) {
    var data = new FormData();
    data.append("imagefile", image);
    $.ajax({
        url: base_url+"/admin/summernoteInagesave",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
            var image = $('<img>').attr('src', url);
            console.log(url);
            $('#solutions').summernote("insertNode", image[0]);
        },
        error: function(data) {
            console.log(data);
        }
    });
}


window.cancelMembership = function(plan_id) {
    Swal.fire({
        title: 'Are you sure',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + '/admin/cancelMembership',
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

window.checkStatuspackage = function(part_id, value) {

    if($("#packId_"+part_id).is(":checked")) {
        var value = 1;
    }else{
        var value = 0;
    }
        $.ajax({
                url: base_url+"/admin/checkStatuspackage",
                type: 'POST',
                data: {'part_id':part_id, value:value},
                beforeSend:function(){
                },
                success: function(data){
                    var obj=JSON.parse(data);
                    if(obj.status==1){
                        Swal.fire({
                            title: 'Success',
                            text: obj.msg,
                            icon: 'success',
                        });


                    }else if(obj.status==0){
                        Swal.fire({
                            title: 'Error',
                            text: obj.msg,
                            icon: 'warning',
                        });
                    }
                }
        });

}




















