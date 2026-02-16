$(function () {

    // $(function () {
    //     var header = $(".start-style");
    //     $(window).scroll(function () {
    //         var scroll = $(window).scrollTop();

    //         if (scroll >= 10) {
    //             header.removeClass('start-style').addClass("scroll-on");
    //         } else {
    //             header.removeClass("scroll-on").addClass('start-style');
    //         }
    //     });
    // });

     /*-------------------------------------Start Password Eye-------------------------*/
     $(document).on('click', '.pass_eye', function(){
        if($(this).closest('.add_eye').find(".pass_input").attr('type')=='password'){
        $(this).closest('.add_eye').find(".pass_input").attr('type','text');
        $(this).closest('.add_eye').find(".eye_change").addClass("fa-eye").removeClass("fa-eye-slash");
        }else{
        $(this).closest('.add_eye').find(".pass_input").attr('type', 'password');
        $(this).closest('.add_eye').find(".eye_change").removeClass("fa-eye").addClass("fa-eye-slash");
        }
    });
    /*-------------------------------------End Password Eye-------------------------*/

    /*-------------------------------------User Page Footer position End-------------------------*/
    // $(document).ready(function(){
    //     var bodyHeight = $(document).height();
    //     var fotterHeight = $('.site-Footer').outerHeight();
    //     $('body').css({"padding-bottom": fotterHeight, "min-height": bodyHeight});
    //     $('.site-Footer').css({"position": "absolute", "bottom": "0", "width": "100%"});
    // });
    /*-------------------------------------User Page Footer position Start-------------------------*/
    flatpickr('#invoice_period', {
        mode: "range",
        onChange: function(selectedDates, dateStr, instance) {
            // Check if both start and end dates are selected
            if (selectedDates.length === 2) {
                // Calculate the difference in days
                var startDate = selectedDates[0];
                var endDate = selectedDates[1];
                var differenceInTime = endDate.getTime() - startDate.getTime();
                var differenceInDays = differenceInTime / (1000 * 3600 * 24);

                // Output the total days
                // console.log("Total days:", differenceInDays);
                $(".total_days_show").val(differenceInDays+ ' DIAS');
                $("#total_days").val(differenceInDays);

                autoKeyupcall();
                potencyAmountOfferSum();
                energyAmountOfferSum();
                totalSimulatedInvoice();
                estimatedAnualSave();
            }
        }
    });

    flatpickr('#index_invoice_period', {
        mode: "range",
        onChange: function(selectedDates, dateStr, instance) {
            // Check if both start and end dates are selected
            if (selectedDates.length === 2) {
                // Extract start and end dates
                var startDate = selectedDates[0];
                var endDate = selectedDates[1];
    
                // Extract the years from both dates
                var startYear = startDate.getFullYear();
                var endYear = endDate.getFullYear();
    
                // Extract the months (add 1 since getMonth() returns 0 for January)
                var startMonth = startDate.getMonth() + 1;  // Start month (1-12)
                var endMonth = endDate.getMonth() + 1;      // End month (1-12)
    
                // Calculate the difference in days
                var differenceInTime = endDate.getTime() - startDate.getTime();
                var differenceInDays = differenceInTime / (1000 * 3600 * 24);
    
                // Set the start year in the year dropdown
                document.querySelector('select[name="year"]').value = startYear;
                document.querySelector('input[name="start_month"]').value = startMonth;
                document.querySelector('input[name="end_month"]').value = endMonth;
                $("#total_days").val(differenceInDays);
    
                // Call your other functions
                autoKeyupcall();
                potencyAmountOfferSum();
                energyAmountOfferSum();
                totalSimulatedInvoice();
                estimatedAnualSave();
            }
        }
    });
    
    

    /*-------------------------------------Left Menu Wrap End-------------------------*/
    // $(document).on('click', '#menu_open', function(){
    //     if($('#menu_wrap').toggleClass('open')){
    //         $(this).html('close menu<i class="fa-solid fa-filter"></i>')
    //     }else{
    //         $(this).html('open menu<i class="fa-solid fa-filter"></i>')
    //     }
    // });

    $(document).on('click', '#menu_open', function(){
        $('#menu_wrap').toggleClass('open');
        $('.category-hamburger-box').toggleClass('active')
        // if($('#menu_wrap').hasClass('open')){
        //     $(this).html('close menu</i>');
        // } else {
        //     $(this).html('open menu</i>');
        // }
    });
    /*-------------------------------------Left Menu Wrap Start-------------------------*/

    $('.company_select').select2();

    $(document).on('click', '.hamburger-box', function(){
        $(this).toggleClass('active');
        $('.sider_manu').toggleClass('sider-manu-wrap')
    });

    $(document).on('click', '.submenu', function(){
        $('.submenu-list').slideToggle();
    });
});
