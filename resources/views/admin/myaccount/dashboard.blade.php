@extends('layouts.front_user')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        {{-- <div class="user-heading">PANEL</div> --}}
                        {{-- <div class="user-body">dashboard</div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
