@extends('layouts.app')
@section('content')
<section class="new-login-sec d-flex justify-content-center align-items-center login-page-bg">
    <div class="container">
        <form action="" id="homeLoginForm">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8 col-ms-12 col-12">
                    <div class="new-login-page g-3">
                        <div class="login-heading mb-2">Tata Pravesh Inventory</div>
                        {{-- <p class="login-subtitle">Sign in securely with a one-time password</p> --}}
                        <div class="login-row email-row">
                            <div class="login-step email-step">
                                <div class="front-input">
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-envelope"></i></span>
                                        <input type="email" id="login-email" name="username" class="form-control front-input-style" placeholder="Email address" value="{{@Session::get('remember_me')['username']}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="login-submit-row" id="login-action">
                                <div class="log-reg-submit-wrap" style="margin-top: -16px;">
                                    <button type="submit" class="log-reg-submit-btn" id="login_btn">Login</button>
                                </div>
                            </div>
                        </div>

                        <div class="login-row otp-row" style="display: none;">
                            <div class="login-step otp-step otp-input">
                                <div class="otp-step-heading">
                                    <div>
                                        <label class="login-label" for="otp-digit-1">Enter verification code</label>
                                        <p>We sent a 6-digit code to your email. <strong id="masked-email"></strong></p>
                                    </div>
                                    <button type="button" class="otp-back" aria-label="Back to email"><i class="fa-solid fa-arrow-left"></i></button>
                                </div>
                                <div class="otp-boxes" aria-label="Six digit one-time password">
                                    @for ($digit = 1; $digit <= 6; $digit++)
                                        <input type="text" id="otp-digit-{{ $digit }}" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" aria-label="OTP digit {{ $digit }}">
                                    @endfor
                                </div>
                                <input type="hidden" name="otp" id="otp-value">
                            </div>
                            <div class="otp-submit-slot"></div>
                        </div>

                        <div class="otp-controls" style="display: none; text-align: center; margin-top: 5px;">
                            <span class="otp-timer text-muted">OTP expires in <span class="timer-value">05:00</span></span>
                            <button type="button" class="btn btn-link resend-otp" style="display:none;">Resend OTP</button>
                        </div>

                            <input type="hidden" name="rfc" value="@php if(isset($_GET['rfc'])) { if($_GET['rfc']=='method'){ echo 'method'; } } @endphp">
                            
                            

                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</section>






@push('scripts')

<style>
    .login-page-bg{
        background-image: url("{{ Vite::asset('resources/front/images/Embosseddoor.webp') }}");
    }

    @media (max-width: 768px) {
        .login-page-bg{
            background-image: url("{{ Vite::asset('resources/front/images/why-pravesh.jpeg') }}");
        }
    }
</style>



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

       

        

    });


</script>

@endpush

@endsection


