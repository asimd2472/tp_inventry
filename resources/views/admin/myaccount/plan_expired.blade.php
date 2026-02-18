@extends('layouts.front_user')
@section('content')
@php
    use App\Models\PackageFeatures;
    use Carbon\Carbon;
@endphp

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Sucripción expirada</div>
                        <div class="user-body">
                            <div class="row g-3">
                                @foreach ($package as $keys=>$package_item)
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="subscription-box subscription-plan-{{($keys+1)}}">
                                        <div class="subscription-head package_title{{$package_item->id}}">{{$package_item->package_title}}</div>
                                        <div class="subscription-body">
                                            <div class="plan-price">
                                                <h3 class="package_price{{$package_item->id}}">
                                                    @if ($package_item->discount_amount!='' && $package_item->discount_amount!=0)
                                                        <del>{{$package_item->discount_amount}}&#8364;</del>
                                                    @endif
                                                    @php
                                                        $get_month = ($package_item->package_duration / 30);
                                                        $monthly_price = ($package_item->package_price / $get_month);
                                                        $formatted_price = number_format($monthly_price, 2, '.', '');
                                                    @endphp

                                                    @if (strpos($formatted_price, '.') !== false)
                                                        @php
                                                            $parts = explode('.', $formatted_price);
                                                            $integerPart = $parts[0];
                                                            $fractionalPart = rtrim($parts[1], '0');
                                                        @endphp
                                                        <span class="discount-price"><strong>{{ $integerPart }}</strong>@if($fractionalPart).{{ $fractionalPart }}@endif&#8364;/mes</span>
                                                    @else
                                                        <span class="discount-price"><strong>{{ $formatted_price }}</strong>&#8364;/mes</span>
                                                    @endif
                                                </h3>
                                            </div>
                                            <ul class="same_height">
                                            </ul>
                                            <div class="subscription-btn-wrap">
                                                <a href="javascript:void(0)" onclick="renewModal({{$package_item->id}}, {{$package_item->package_price}})" class="subscription-btn">Renovar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<div class="modal fade only-modal-body custom-width-modal" id="renewModel" tabindex="-1"
aria-labelledby="registerLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
            <button class="modal-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-regular fa-circle-xmark"></i></button>
            <form
                role="form"
                action="{{ route('user.renew_stripe') }}"
                method="post"
                class="require-validation"
                data-cc-on-file="false"
                data-stripe-publishable-key="{{$stripeAccount->stripe_key}}"
                id="payment-form">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="package-account-wrap pb-0">
                            <div class="package-details">
                                <div class="package-header-text">
                                    <h3>Plan Details: <span class="pack_details">STANDARD (75€)</span></h3>
                                </div>
                                <div class="front-input">
                                    <input name="cardholder_name" type="text" class="form-control front-input-style"
                                        placeholder="Card holder name" required>
                                </div>
                                <div class="front-input">
                                    <input name="card_no" type="text" class="form-control front-input-style card-number isnumber"
                                        placeholder="Card Number" required>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="front-input">
                                            <input name="card_expair" type="text" onkeyup="modifyInput(this)" placeholder='MM/YYYY' size='7' minlength="7" maxlength="7" class="form-control front-input-style card-expiry-year isnumber"
                                                placeholder="Expairy Date" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="front-input">
                                            <input name="cvc" type="text" class="form-control front-input-style card-cvc isnumber"
                                                placeholder="CVV" maxlength="4" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="log-reg-submit-wrap">
                                <button type="submit" class="log-reg-submit-btn" id="apy_btn">Pay Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-12">
                        <div class="progress mt-2" id="progressBar" style="display: none;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">10%</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>



@push('scripts')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        var m_p = 0;
        var elements = document.querySelectorAll('.same_height');

        elements.forEach(function(element) {
            if (element.offsetHeight >= m_p) {
                m_p = element.offsetHeight;
            }
        });

        elements.forEach(function(element) {
            element.style.minHeight = m_p + "px";
        });
    });


    $(function() {

        var $form = $(".require-validation");

        $("#payment-form").validate({

            rules: {
                cardholder_name: {
                    required: true,
                },
                card_no: {
                    required: true,
                },
                cvc: {
                    required: true,
                },
                card_expair: {
                    required: true,
                },

            },
            messages: {
                cardholder_name: {
                    required: "Este campo es obligatorio.",
                },
                card_no: {
                    required: "Este campo es obligatorio.",
                },
                cvc: {
                    required: "Este campo es obligatorio.",
                },
                card_expair: {
                    required: "Este campo es obligatorio.",
                },
            },
            errorElement: 'span',
            errorClass: 'customerror',

            submitHandler: function(e) {

                var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                                'input[type=text]', 'input[type=file]',
                                'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    // e.preventDefault();
                }
                });

                if (!$form.data('cc-on-file')) {

                    var expiryMonthYear = $('.card-expiry-year').val();

                    var parts = expiryMonthYear.split("/");
                    var expiryMonth = parts[0];
                    var expiryYear = parts[1];

                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: expiryMonth,
                        exp_year: expiryYear,
                    }, stripeResponseHandler);
                }

            }
        });

        window.stripeResponseHandler = function(status, response) {
            console.log(response);
            $('.loading').attr("style", "display:block");
            if (response.error) {
                // $('.error')
                //     .removeClass('hide')
                //     .find('.alert')
                //     .text(response.error.message);

                Swal.fire({
                    // title: 'Alert',
                    text: response.error.message,
                    icon: 'warning',
                });

                $('.loading').attr("style", "display:none");
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                // $form.get(0).submit();

                var packData = localStorage.getItem('pack');

                var form = $('#payment-form')[0];
                var formData = new FormData(form);
                event.preventDefault();

                formData.append('package_id', packData);

                $.ajax({
                    url: base_url + "/user/renew_stripe",
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

                        $('#apy_btn').html('Please Wait...');
                        $('#apy_btn').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        if (data.status == 1) {

                            Swal.fire({
                                title: data.msg,
                                text: data.transaction_id,
                                icon: 'success',
                            });

                            $('#apy_btn').html('Pay Now');
                            $("#apy_btn").prop("disabled", false);
                            form.reset();

                            $('#progressBar').hide();

                        } else if (data.status == 0) {

                            $('#apy_btn').html('Pay Now');
                            $("#apy_btn").prop("disabled", false);

                            Swal.fire({
                                title: 'Error',
                                text: data.msg,
                                icon: 'warning',
                            });

                            $('#progressBar').hide();

                        }
                    }
                });

            }
        }

});


</script>

@endpush

@endsection
