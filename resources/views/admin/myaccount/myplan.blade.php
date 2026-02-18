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
                        <div class="user-heading">MI PLAN</div>
                        <div class="user-body">
                            @if(Auth::user()->payment_type==1)
                            <div>
                                <div class="my-plan-dtls">
                                    <h4>DETALLES DEL PLAN: <span>{{@$my_plan->Package->package_title}} ({{@$my_plan->Package->package_price}}€) / {{$my_plan->duration}} Días</span></h4>
                                    <ul>
                                        @php
                                            $packageFeatures = PackageFeatures::whereIn('id', explode(',', $my_plan->features_ids))->get();
                                        @endphp
                                        @foreach ($packageFeatures as $feature)
                                            <li>{{ $feature->features_title }}</li>
                                        @endforeach
                                    </ul>
                                    <h4>FECHA INICIO: <span>{{$my_plan->start_date}}</span></h4>

                                    @php
                                        $start_date = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                        $end_date = Carbon::createFromFormat('Y-m-d', $my_plan->end_date);
                                        $days_difference = $start_date->diffInDays($end_date);
                                    @endphp

                                    <h4 class="mt-2">EXPIRA EN: <span>{{$my_plan->end_date}}</span></h4>
                                </div>
                                @php
                                    $expiryDate = Carbon::parse($end_date);
                                    $today = Carbon::today();
                                @endphp

                                @if ($today->greaterThanOrEqualTo($expiryDate))
                                <div class="alert alert-danger mt-2">
                                    Your plan has expired on {{ $expiryDate->format('Y-m-d') }}.
                                </div>
                                @else
                                    @if($my_plan->auto_renewal==1)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="log-reg-submit-wrap mt-3">
                                                <button type="submit" class="btn btn-danger" id="cancelMembership" onclick="cancelMembership('{{$my_plan->id}}')">CANCELAR PLAN</button>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-danger mt-2">
                                        Membresía cancelada
                                    </div>
                                    @endif
                                @endif
                            </div>
                            @else

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
