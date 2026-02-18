@extends('layouts.front_user')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">MI CUENTA</div>
                        <div class="user-body">
                            <div class="account-tab-sec">
                                <form id="user-update-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="front-input">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-user"></i></span>
                                                    <input type="text" class="form-control front-input-style" name="name" placeholder="Name" value="{{$user_details->name}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="front-input">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-envelope"></i></span>
                                                    <input type="email" class="form-control front-input-style" name="email" id="reg_email" placeholder="Email" value="{{$user_details->email}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="front-input phone-input">
                                            <input name="phone" type="tel" id="phone_prifix" class="form-control front-input-style"
                                                placeholder="Phone Number" value="{{$user_details->phone}}" required>
                                        </div>
                                        <input type="hidden" name="dialCode" id="dialCode" value="{{$user_details->dialCode}}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="front-input">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-street-view"></i></span>
                                                    <input type="text" class="form-control front-input-style" name="street" id="street" placeholder="Street" value="{{$user_details->street}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="front-input">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-city"></i></span>
                                                    <input type="text" class="form-control front-input-style" name="city" id="city" placeholder="City" value="{{$user_details->city}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="front-input">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-map"></i></span>
                                                    <input type="text" class="form-control front-input-style" name="state" id="state" placeholder="State" value="{{$user_details->state}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="front-input">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-map-pin"></i></span>
                                                    <input type="text" class="form-control front-input-style" name="zip_code" id="zip_code" placeholder="Zip Code" value="{{$user_details->zip_code}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="front-input">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-id-card"></i></span>
                                                    <input type="text" class="form-control front-input-style" name="user_id" id="user_id" placeholder="ID" value="{{$user_details->user_id}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Profile Photo</label>
                                            <div class="front-input photo-up-wrap">
                                                <div class="position-relative add-icon-lft">
                                                    <span class="icon-lft"><i class="fa-solid fa-image"></i></span>
                                                    <input type="file" class="form-control front-input-style" name="admin_img" id="admin_img" value="{{$user_details->admin_img}}"  {{ $user_details->admin_img == '' ? 'required' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($user_details->admin_img!='')
                                            <div class="col-md-6">
                                                <img src="{{asset('storage/images/'.$user_details->admin_img)}}" class="img-fluid img-thumbnail" alt="">
                                            </div>
                                        @endif
                                        <div class="log-reg-submit-wrap">
                                            <button type="submit" class="log-reg-submit-btn" id="apy_btn">Actualizar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
