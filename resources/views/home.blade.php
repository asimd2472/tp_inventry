@extends('layouts.front')
@section('content')
<section class="new-login-sec d-flex justify-content-center align-items-center">
    <div class="container">
        <form action="" id="homeLoginForm">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8 col-ms-12 col-12">
                    <div class="new-login-page g-3">
                        <div class="new-login-logo">
                            <a href="{{url('/')}}" class="logoimg">
                                <img class="img-blog" src="{{Vite::asset('resources/front/images/logo.png')}}" alt="">
                            </a>
                        </div>
                        <div class="front-input">
                            <div class="position-relative add-icon-lft">
                                <span class="icon-lft"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="username" class="form-control front-input-style" placeholder="User ID:" value="{{@Session::get('remember_me')['username']}}" required>
                            </div>
                        </div>
                        <div class="front-input">
                            <div class="position-relative add-icon-lft add-icon-rgt add_eye">
                                <span class="icon-lft"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="user_password" class="form-control front-input-style pass_input"
                                    placeholder="Password" value="{{@Session::get('remember_me')['user_password']}}" required>
                                <span class="icon-rgt pass_eye"><i class="eye_change fa-solid fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <div class="remember-wrap row align-items-center justify-content-between g-2">
                            <div class="col-md-auto col-sm-12 col-12">
                                <div class="checkbox ps-1">
                                    <input type="checkbox" id="remember_password" name="remember" value="1" @if(Session::get('remember_me')) checked @endif>
                                    <label for="remember_password">Remember me</label>
                                </div>
                            </div>
                            <input type="hidden" name="rfc" value="@php if(isset($_GET['rfc'])) { if($_GET['rfc']=='method'){ echo 'method'; } } @endphp">
                            <div class="col-md-auto col-sm-12 col-12">
                                <div class="forget-pass-wrap">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#forgotModal"
                                    data-bs-dismiss="modal" aria-label="Close" class="forget-pass-btn">Forgot Password</a>
                                </div>
                            </div>
                        </div>
                        <div class="log-reg-submit-wrap mt-3">
                            <button type="submit" class="log-reg-submit-btn" id="login_btn">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</section>




<!-- forgotpassword Modal -->
<div class="modal fade only-modal-body only-modal-body" id="forgotModal" tabindex="-1"
aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button class="modal-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-regular fa-circle-xmark"></i></button>
                <div class="log-reg-wrap">
                    <div class="log-reg-head-wrap row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="log-reg-head">
                                <h4>Forgot Password</h4>
                            </div>
                        </div>
                    </div>
                    <form action="" id="forgotpasswordForm">
                        @csrf
                        <div class="front-input">
                            <div class="position-relative add-icon-lft">
                                <span class="icon-lft"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="user_email" class="form-control front-input-style" placeholder="Email" required>
                            </div>
                        </div>
                        {{-- <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                            </div>
                            <div class="col-auto">
                                <div class="forget-pass-wrap">
                                    <a href="javascript:void(0)" data-bs-target="#loginModal"
                                    data-bs-dismiss="modal" aria-label="Close" class="forget-pass-btn">Back to Login</a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="log-reg-submit-wrap">
                            <button type="submit" id="forgot_btn" class="log-reg-submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- forgotpassword Modal End -->




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


