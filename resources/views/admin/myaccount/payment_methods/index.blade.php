@extends('layouts.front_user')
@section('content')
@php
    use App\Models\PackageFeatures;
    use Carbon\Carbon;
@endphp

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Método de pago</div>
                        <div class="user-body">
                            <div class="payments-method-wrap">
                                <div class="row g-3 justify-content-between align-items-center">
                                    <div class="col-md-auto col-sm-auto col-12">
                                        <div class="title-head">Your card details</div>
                                    </div>
                                    <div class="col-md-auto col-sm-auto col-12">
                                        <div class="back-prv-btn-box">
                                            <a href="{{url('user/add-payment-methods')}}" class="back-prv-btn">Add new card</a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        @foreach ($sortedPaymentMethods as $method)
                                        
                                            <div class="add-card-box">
                                                @if($method->type=='card')
                                                @php
                                                    $cardBrand = $method->card->brand;
                                                    $icon = $cardIcons[$cardBrand] ?? $cardIcons['unknown'];
                                                @endphp
                                                    <div class="add-card-box-lft">
                                                        <div class="card-dtls">
                                                            <div class="card-dtls-img">
                                                                <span class="card-img">
                                                                    <img src="{{ Vite::asset('resources/front/images/card/'. $icon)}}" />
                                                                </span>
                                                            </div>
                                                            <div class="card-dtls-number">
                                                                ************{{$method->card->last4}}
                                                            </div>
                                                        </div>
                                                        <ul class="card-expiry">
                                                            <li>{{$method->card->funding}} Card</li>
                                                            <li>expires {{str_pad($method->card->exp_month, 2, '0', STR_PAD_LEFT)}}-{{$method->card->exp_year}}</li>
                                                            @if ($method->id === $defaultPaymentMethodId)
                                                                <li> <span class="make-default">default method</span></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @elseif($method->type=='link')
                                                    <div class="add-card-box-lft">
                                                        <div class="card-dtls">
                                                            <div class="card-dtls-img">
                                                                <span class="card-img">
                                                                    <img src="{{ Vite::asset('resources/front/images/card/link.png')}}" />
                                                                </span>
                                                            </div>
                                                            <div class="card-dtls-number">
                                                                ****************
                                                            </div>
                                                        </div>
                                                        <ul class="card-expiry">
                                                            <li>{{$method->link->email}}</li>
                                                            @if ($method->id === $defaultPaymentMethodId)
                                                                <li> <span class="make-default">default method</span></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="add-card-box-rgt">
                                                    <ul class="card-action">
                                                        @if ($method->id != $defaultPaymentMethodId)
                                                            <li><button type="submit" class="card-action-btn" onclick="makeDefaultCard('{{$method->id}}')">make a default</button></li>
                                                            <li><button type="submit" class="card-action-btn delete" onclick="removeCard('{{$method->id}}')">Remove</button></li>
                                                        @endif
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
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
