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
                        <div class="user-heading">AYUDA</div>
                        <div class="user-body">

                            <div class="row justify-content-center">
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="faq-wrap">
                                        <div class="accordion" id="faqlistwrap-1">
                                            {{-- <div class="accordion-item">
                                                <h2 class="accordion-header" id="faqlist-1">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        This is the first item's accordion body
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show"
                                                    aria-labelledby="faqlist-1" data-bs-parent="#faqlistwrap-1">
                                                    <div class="accordion-body">
                                                        This is the first item's accordion body. It is shown by
                                                        default, until the collapse plugin adds the appropriate classes that we use to
                                                        style each element. These classes
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="faqlist-2">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        CSS or overriding our default variables
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqlist-2"
                                                    data-bs-parent="#faqlistwrap-1">
                                                    <div class="accordion-body">
                                                        This is the second item's accordion body. It is hidden by
                                                        default, until the collapse plugin adds the appropriate classes that
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="faqlist-3">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseThree" aria-expanded="false"
                                                        aria-controls="collapseThree">
                                                        via CSS transitions. You can modify any of this
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqlist-3"
                                                    data-bs-parent="#faqlistwrap-1">
                                                    <div class="accordion-body">
                                                        This is the third item's accordion body. It is hidden by
                                                    </div>
                                                </div>
                                            </div> --}}
                                            @foreach ($faq as $key=>$item)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="faqlist-{{$key}}">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne{{$key}}">
                                                        {{$item->question}}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{$key}}" class="accordion-collapse collapse {{$key==0 ? 'show' : '' }}"
                                                    aria-labelledby="faqlist-{{$key}}" data-bs-parent="#faqlistwrap-{{$key}}">
                                                    <div class="accordion-body">
                                                        {!! $item->ans !!}
                                                    </div>
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
        </div>
    </section>

@endsection
