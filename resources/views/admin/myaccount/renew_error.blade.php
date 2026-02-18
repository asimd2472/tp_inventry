@extends('layouts.front_user')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">ALGO SALIÓ MAL</div>
                        <div class="user-body">
                            

                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <div class="message-box _success _failed">
                                     <i class="fa fa-times-circle" aria-hidden="true"></i>
                                    <h2> ALGO SALIÓ MAL</h2>
                                    <a href="{{url('/')}}">Volver a Inicio</a>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <style>
    ._failed{ border-bottom: solid 4px red !important; }
._failed i{  color:red !important;  }

._success {
    box-shadow: 0 15px 25px #00000019;
    padding: 45px;
    width: 100%;
    text-align: center;
    margin: 40px auto;
    border-bottom: solid 4px #28a745;
}

._success i {
    font-size: 55px;
    color: #28a745;
}

._success h2 {
    margin-bottom: 12px;
    font-size: 40px;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 10px;
}

._success p {
    margin-bottom: 0px;
    font-size: 18px;
    color: #495057;
    font-weight: 500;
}
.site-Footer{
    display: none;
}
</style>




@endsection
