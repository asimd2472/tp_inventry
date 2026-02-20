@extends('layouts.front_user')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                <div class="userwrap-lft">
                    <div class="user-dashboard">
                        @include('front.includes.leftmenu')
                    </div>
                </div>
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">comparissor for {{$company->company_name}}</div>
                        <input type="hidden" name="company_id" id="company_id" value="{{$company->id}}">
                        <input type="hidden" name="offer_id" id="offer_id" value="">
                        <input type="hidden" name="accessfee_id" id="accessfee_id" value="">
                        <input type="hidden" name="total_potency_amount_offer" id="total_potency_amount_offer" value="0">
                        <input type="hidden" name="total_energy_amount_offer" id="total_energy_amount_offer" value="0">
                        <input type="hidden" name="imp_electrico_input" id="imp_electrico_input" value="0">
                        <input type="hidden" name="iva_input" id="iva_input" value="0">
                        <input type="hidden" name="other_number" id="other_number" value="0">
                        <input type="hidden" name="alquiler_contador" id="alquiler_contador" value="0">
                        <input type="hidden" name="rdl_number" id="rdl_number" value="0">
                        <input type="hidden" name="totalSimulatedInvoice_input" id="totalSimulatedInvoice_input" value="0">
                        <input type="hidden" name="total_invoice_now" id="total_invoice_now" value="0">
                        <input type="hidden" name="estimated_anual_save_input" id="estimated_anual_save_input" value="0">

                        <div class="user-body">
                            <div class="compar-wrap">
                                <div class="row g-2">
                                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="front-select">
                                            <label for="" class="site-label">Offer</label>
                                            <select class="form-select front-select-style" onchange="companyOffers(this.value)">
                                                <option value="">Select Offer</option>
                                                @foreach ($companyOffers as $companyOffersitem)
                                                <option value="{{$companyOffersitem->id}}">{{$companyOffersitem->offer}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="front-select">
                                            <label for="" class="site-label">Access Fee</label>
                                            <select class="form-select front-select-style" onchange="companyAccessfee(this.value)">
                                                <option value="">Select Access Fee</option>
                                                @foreach ($companyAccessfee as $companyAccessfeeitem)
                                                <option value="{{$companyAccessfeeitem->id}}">{{$companyAccessfeeitem->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-9 col-md-9 col-sm-12 col-12">
                                        <div class="front-input">
                                            <label for="" class="site-label">Invoice Period</label>
                                            <input name="" type="text" id="invoice_period" class="form-control front-input-style" placeholder="Invoice Period" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12">
                                        <div class="front-input">
                                            <label for="" class="site-label">Days</label>
                                            <input name="" type="text" class="form-control front-input-style readonly total_days_show" value="" readonly>
                                            <input type="hidden" name="total_days" id="total_days" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="calculate-wrap">
                                            <div class="calculate-wrap-width">
                                                <div class="no-head"></div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p1</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p2</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p3</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p4</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p5</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p6</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="calculate-wrap-auto hired_potency_section">
                                                <div class="calculate-box-head">hired potency</div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control hired_potencyp1">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control hired_potencyp2">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control hired_potencyp3">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control hired_potencyp4">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control hired_potencyp5">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control hired_potencyp6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="calculate-wrap-auto">
                                                <div class="calculate-box-head">price potency</div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_potencyp1">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_potencyp2">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_potencyp3">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_potencyp4">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_potencyp5">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_potencyp6">0.000000</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="calculate-wrap-auto">
                                                <div class="calculate-box-head">potency amount offer</div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="potency_amount_offerp1">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="potency_amount_offerp2">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="potency_amount_offerp3">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="potency_amount_offerp4">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="potency_amount_offerp5">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="potency_amount_offerp6">0.00</span>&nbsp€</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="calculate-wrap">
                                            <div class="calculate-wrap-width">
                                                <div class="no-head"></div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p1</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p2</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p3</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p4</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p5</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap">p6</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="calculate-wrap-auto energy_consumed_section">
                                                <div class="calculate-box-head">energy consumed</div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control energy_consumedp1">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="text" class="form-control energy_consumedp2">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control energy_consumedp3">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control energy_consumedp4">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control energy_consumedp5">
                                                        </div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="input-group value-box-wrap type-area">
                                                            <input name="" type="number" class="form-control energy_consumedp6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="calculate-wrap-auto">
                                                <div class="calculate-box-head">price energy</div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_energyp1">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_energyp2">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_energyp3">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_energyp4">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_energyp5">0.000000</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area price_energyp6">0.000000</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="calculate-wrap-auto">
                                                <div class="calculate-box-head">energy amount offer</div>
                                                <div class="calculate-box">
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="energy_amount_offerp1">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="energy_amount_offerp2">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="energy_amount_offerp3">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="energy_amount_offerp4">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="energy_amount_offerp5">0.00</span>&nbsp€</div>
                                                    </div>
                                                    <div class="value-box">
                                                        <div class="value-box-wrap value-area"><span class="energy_amount_offerp6">0.00</span>&nbsp€</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mt-0">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="other-calculate-wrap">
                                            <div class="other-calculate">
                                                <div class="other-calculate-lft">Other</div>
                                                <div class="other-calculate-rgt">
                                                    <div class="input-group other-input">
                                                        <input name="other_number" type="number" class="form-control other_number">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="other-calculate">
                                                <div class="other-calculate-lft">ALQUILER CONTADOR</div>
                                                <div class="other-calculate-rgt">
                                                    <div class="input-group other-input">
                                                        <input name="alquiler_contador" type="number" class="form-control alquiler_contador">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="other-calculate">
                                                <div class="other-calculate-lft">RDL</div>
                                                <div class="other-calculate-rgt">
                                                    <div class="input-group other-input">
                                                        <input name="rdl_number" type="number" class="form-control rdl_number">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="other-calculate-wrap">
                                            <div class="other-calculate">
                                                <div class="other-calculate-lft">IMP. ELECTRICO</div>
                                                <div class="other-calculate-rgt">
                                                    <div class="input-group other-input">
                                                        <input name="imp_electrico" type="number" class="form-control imp_electrico">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="other-calculate-value">
                                                    <div class="other-value imp_electrico_show">0.00 €</div>
                                                </div>
                                            </div>
                                            <div class="other-calculate">
                                                <div class="other-calculate-lft">IVA</div>
                                                <div class="other-calculate-rgt">
                                                    <div class="input-group other-input">
                                                        <input name="iva" type="number" class="form-control iva_number">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="other-calculate-value">
                                                    <div class="other-value iva_show">0.00 €</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mt-0">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="total-calculate-wrap">
                                            <div class="total-calculate-head">total invoice now</div>
                                            <div class="total-calculate-body bdy-clr">
                                                <div class="input-group other-input">
                                                    <input name="" type="number" class="form-control total_invoice_now">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text total_invoice_now_show">€</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="total-calculate-wrap">
                                            <div class="total-calculate-head">total simulated invoice</div>
                                            <div class="total-calculate-body totalSimulatedInvoice_show">0.00 €</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                        <div class="total-calculate-wrap">
                                            <div class="total-calculate-head">estimated anual save</div>
                                            <div class="total-calculate-body estimated_anual_save_show">0.00 €</div>
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
