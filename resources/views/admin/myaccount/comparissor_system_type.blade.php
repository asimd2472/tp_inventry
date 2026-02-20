@extends('layouts.front_user')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">COMPARADOR</div>
                        <div class="user-body">
                            <div class="compar-wrap">
                                <div class="row g-3">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="price-box-wrap">
                                            <a class="price-box-btn" href="{{url('/user/comparissor?type=electricity')}}" onclick="comparissor_system_type('ELECTRICITY')"><i class="fa-solid fa-bolt fs-3 d-block mb-2"></i> ELECTRICIDAD</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="price-box-wrap">
                                            <a class="price-box-btn" href="{{url('/user/comparissor?type=gas')}}" onclick="comparissor_system_type('GAS')"><i class="fa-solid fa-gas-pump fs-3 d-block mb-2"></i> GAS</a>
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
