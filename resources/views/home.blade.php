@extends('layouts.app')
@section('content')
<section class="new-login-sec d-flex justify-content-center align-items-center">
    <div class="container">
        <form action="" id="homeLoginForm">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8 col-ms-12 col-12">
                    <div class="new-login-page g-3">

                        <div class="row align-items-center g-3">
                            <div class="col-md-8 col-12" id="email-input">
                                <div class="front-input">
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-envelope"></i></span>
                                        <input type="email" name="username" class="form-control front-input-style" placeholder="Email" value="{{@Session::get('remember_me')['username']}}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-12 otp-input" style="display: none;">
                                <div class="front-input">
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-key"></i></span>
                                        <input type="text" name="otp" class="form-control front-input-style" placeholder="Enter OTP">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="log-reg-submit-wrap" style="margin-top: -17px;">
                                    <button type="submit" class="log-reg-submit-btn" id="login_btn">Login</button>
                                </div>
                            </div>

                            <div class="otp-controls" style="display: none; text-align: center; margin-top: 0px;">
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


