@extends('layouts.front_user')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">comparissor</div>
                        <div class="user-body">
                            <div class="row g-3">
                                @foreach ($company as $item)
                                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="company-list-icon">
                                            <a class="company-list-box" href="{{url('user/comparissor/'.encrypt($item->id))}}">
                                                <span class="company-icon"><img class="img-block" src="{{asset('storage/images/'.$item->company_logo)}}"></span>
                                                <h4>{{$item->company_name}}</h4>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
