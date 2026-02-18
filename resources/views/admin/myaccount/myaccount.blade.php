@extends('layouts.front_user')
@section('content')
@php
    use Illuminate\Support\Facades\Crypt;
    use Carbon\Carbon;
@endphp
    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">MI CUENTA</div>
                        <div class="user-body">
                            <div class="account-tab-sec">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="account1-tab" data-bs-toggle="pill"
                                    data-bs-target="#account1" type="button" role="tab" aria-controls="account1" aria-selected="true">DETALLES DE CUENTA</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="account2-tab" data-bs-toggle="pill"
                                    data-bs-target="#account2" type="button" role="tab" aria-controls="account2" aria-selected="false">CAMBIAR PASSWORD</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="account1" role="tabpanel" aria-labelledby="account1-tab">
                                        @if ($user_details->admin_img!='')
                                            <ul class="account-dtls">
                                                <img src="{{asset('storage/images/'.$user_details->admin_img)}}" class="rounded-circle" width="200px" height="200px" alt="">
                                            </ul>
                                        @endif
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">NOMBRE</li>
                                            <li class="account-dtls-rgt">: {{$user_details->name}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">EMAIL</li>
                                            <li class="account-dtls-rgt">: {{$user_details->email}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">TELEFONO</li>
                                            <li class="account-dtls-rgt">: {{$user_details->phone}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">CALLE</li>
                                            <li class="account-dtls-rgt">: {{$user_details->street}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">CIUDAD</li>
                                            <li class="account-dtls-rgt">: {{$user_details->city}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">PAIS</li>
                                            <li class="account-dtls-rgt">: {{$user_details->state}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">CODIGO POSTAL</li>
                                            <li class="account-dtls-rgt">: {{$user_details->zip_code}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <li class="account-dtls-lft">ID</li>
                                            <li class="account-dtls-rgt">: {{$user_details->user_id}}</li>
                                        </ul>
                                        <ul class="account-dtls">
                                            <a href="{{url('user/update-account')}}" class="btn btn-primary mt-1" >Update Profile</a>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="account2" role="tabpanel" aria-labelledby="account2-tab">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-8 col-sm-12 col-12">
                                                <form action="" id="user_changepassword">
                                                    <div class="front-input">
                                                        <input type="password" name="user_password" id="user_password" class="form-control front-input-style" placeholder="INTRODUCIR NUEVO PASSWORD" required>
                                                    </div>
                                                    <div class="front-input">
                                                        <input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control front-input-style" placeholder="CONFIRMAR PASSWORD" required>
                                                    </div>
                                                    <div class="log-reg-submit-wrap">
                                                        <button type="submit" class="log-reg-submit-btn">save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection




