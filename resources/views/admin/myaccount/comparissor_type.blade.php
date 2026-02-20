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
                                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="price-box-wrap">
                                            <a class="price-box-btn" href="{{url('/user/comparissor/fixed')}}">PRECIO FIJO</a>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="price-box-wrap">
                                            <a class="price-box-btn" href="{{url('/user/comparissor/index')}}">PRECIO INDEXADO</a>
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
