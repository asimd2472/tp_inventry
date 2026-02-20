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
                        <div class="user-heading">Método de pago</div>
                        <div class="user-body">
                            <div class="row justify-content-center">
                                <div class="col-xl-8 col-md-8 col-sm-12 col-12">
                                    <div class="card-add-box">
                                        <form id="payment-form">
                                            <div id="card-element" class="card-element">
                                                <!-- Stripe's card element will be inserted here -->
                                            </div>
                                            <div id="card-errors" role="alert" style="color: red;"></div>
                                            <button type="submit" id="submit" class="btn-style">Add Card</button>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script type="module">

        var stripe = Stripe("{{ $stripe_Key }}");
        var elements = stripe.elements();
        // var cardElement = elements.create('card');
        var style = {
        base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };
        var cardElement = elements.create("card", {
        style: style,
            hidePostalCode: true
        });
        cardElement.mount('#card-element');
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            $('.loader-wrap').show();
            event.preventDefault();
            stripe.createPaymentMethod({
                type: 'card',
                card: cardElement
            }).then(function (result) {
                if (result.error) {
                    $('.loader-wrap').hide();
                    document.getElementById('card-errors').textContent = result.error.message;
                } else {
                    fetch('/user/add-card', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            payment_method_id: result.paymentMethod.id,
                            customer_id: '{{ $customer_id }}'
                        })
                    }).then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        if (data.error) {
                            document.getElementById('card-errors').textContent = data.error;
                            $('.loader-wrap').hide();
                        } else {
                            $('.loader-wrap').hide();
                            alert('Card added successfully');
                            location.href = "{{url('/user/payment-methods')}}";
                        }
                    });
                }
            });
        });
        </script>

    @endpush

@endsection
