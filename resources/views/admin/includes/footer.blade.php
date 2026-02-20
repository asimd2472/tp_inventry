<footer class="site-Footer">
    <div class="container">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
        <div class="row justify-content-between align-items-center">
            <div class="col-md-auto col-sm-12">
                {{-- <div class="copyright-text">&copy; 2021 por Grupo New Energy</div> --}}
            </div>
            <div class="col-md-auto col-sm-12">
                <div class="footer-menu">
                    <ul>
                        <li>
                            <a href="{{url('/privacy-policy')}}">Privacy policy</a>
                        </li>
                        <li>
                            <a href="{{url('/cookies-policy')}}">Cookies policy</a>
                        </li>
                        {{-- <li>
                            <a href="#">info@gruponewenergy.es</a>
                        </li> --}}
                    </ul>
                </div>
                {{-- <div class="info-mail"><a href="#"></a></div> --}}
            </div>
        </div>
    </div>
</footer>



<!-- Login Modal -->
<div class="modal fade only-modal-body only-modal-body" id="loginModal" tabindex="-1"
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
                                <h4>INICIAR SESION</h4>
                            </div>
                        </div>
                        {{-- <div class="col-auto">
                            <div class="log-reg-btn-wrap">
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#register"
                                    data-bs-dismiss="modal" aria-label="Close" class="log-reg-btn">Register</a>
                            </div>
                        </div> --}}
                    </div>
                    <form action="" id="loginForm">
                        @csrf
                        <div class="front-input">
                            <div class="position-relative add-icon-lft">
                                <span class="icon-lft"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="username" class="form-control front-input-style" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="front-input">
                            <div class="position-relative add-icon-lft add-icon-rgt add_eye">
                                <span class="icon-lft"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="user_password" class="form-control front-input-style pass_input"
                                    placeholder="CONTRASEÑA" required>
                                <span class="icon-rgt pass_eye"><i class="eye_change fa-solid fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                            </div>
                            <div class="col-auto">
                                <div class="forget-pass-wrap">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#forgotModal"
                                    data-bs-dismiss="modal" aria-label="Close" class="forget-pass-btn">OLVIDÓ SU CONTRASEÑA?</a>
                                </div>
                            </div>
                        </div>
                        <div class="log-reg-submit-wrap">
                            <button type="submit" class="log-reg-submit-btn" id="login_btn">INICIAR SESION</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Modal End -->


<!-- Modal Register -->
<div class="modal fade only-modal-body custom-width-modal" id="registerModel" tabindex="-1"
aria-labelledby="registerLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
            <button class="modal-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-regular fa-circle-xmark"></i></button>
            <form
                role="form"
                {{-- action="{{ route('stripe') }}"
                method="post"
                class="require-validation"
                data-cc-on-file="false"
                data-stripe-publishable-key="{{!empty($stripeAccount) ? $stripeAccount->stripe_key : env('STRIPE_KEY')}}" --}}
                id="payment-form">
                <div class="row g-3">
                    <div class="col-sm-12">
                        <div class="log-reg-wrap pb-0">
                            <div class="log-reg-head-wrap row align-items-center justify-content-between">
                                <div class="col-auto">
                                    <div class="log-reg-head">
                                        <h4>CREA TU CUENTA</h4>
                                    </div>
                                    <div class="package-header-text">
                                        <h5>PLAN: <span class="pack_details">STANDARD (75€)</span></h5>
                                    </div>
                                </div>
                                {{-- <div class="col-auto">
                                    <div class="log-reg-btn-wrap">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                                            data-bs-dismiss="modal" aria-label="Close" class="log-reg-btn">login</a>
                                    </div>
                                </div> --}}
                            </div>
                                <div class="front-input">
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" class="form-control front-input-style" name="name" placeholder="NOMBRE" required>
                                    </div>
                                </div>
                                <div class="front-input">
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-envelope"></i></span>
                                        <input type="email" class="form-control front-input-style" name="email" id="reg_email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="front-input phone-input">
                                    <input name="phone" type="tel" id="phone_prifix" class="form-control front-input-style"
                                        placeholder="NUMERO DE TELEFONO" required>
                                </div>
                                <input type="hidden" name="dialCode" id="dialCode">
                                <div class="front-input">
                                    <div class="position-relative add-icon-lft add-icon-rgt add_eye">
                                        <span class="icon-lft"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control front-input-style pass_input"
                                            placeholder="CONTRASEÑA" required>
                                        <span class="icon-rgt pass_eye"><i class="eye_change fa-solid fa-eye-slash"></i></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="front-input">
                                            <div class="position-relative add-icon-lft">
                                                <span class="icon-lft"><i class="fa-solid fa-street-view"></i></span>
                                                <input type="text" class="form-control front-input-style" name="street" id="street" placeholder="CALLE" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="front-input">
                                            <div class="position-relative add-icon-lft">
                                                <span class="icon-lft"><i class="fa-solid fa-city"></i></span>
                                                <input type="text" class="form-control front-input-style" name="city" id="city" placeholder="CIUDAD" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="front-input">
                                            <div class="position-relative add-icon-lft">
                                                <span class="icon-lft"><i class="fa-solid fa-map"></i></span>
                                                <input type="text" class="form-control front-input-style" name="state" id="state" placeholder="POBLACION" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="front-input">
                                            <div class="position-relative add-icon-lft">
                                                <span class="icon-lft"><i class="fa-solid fa-map-pin"></i></span>
                                                <input type="text" class="form-control front-input-style" name="zip_code" id="zip_code" placeholder="CODIGO POSTAL" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="log-reg-submit-wrap">
                                    <button type="submit" class="log-reg-submit-btn" id="apy_btn">PAGA Y ACCEDE</button>
                                </div>
                        </div>

                    </div>
                    {{-- <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="package-account-wrap pb-0 after-border">
                            <div class="package-details">
                                <div class="package-header-text">
                                    <h3>PLAN: <span class="pack_details">STANDARD (75€)</span></h3>
                                </div>
                                <div class="front-input">
                                    <input name="cardholder_name" type="text" class="form-control front-input-style"
                                        placeholder="NOMBRE EN LA TARJETA" required>
                                </div>
                                <div class="front-input">
                                    <input name="card_no" type="text" class="form-control front-input-style card-number isnumber"
                                        placeholder="NUMERO DE TARJETA" required>
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
                                <button type="submit" class="log-reg-submit-btn" id="apy_btn">PAGA Y ACCEDE</button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- Modal Register End -->


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
                                <h4>OLVIDÓ SU CONTRASEÑA</h4>
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
