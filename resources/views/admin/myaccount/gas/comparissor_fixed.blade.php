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
                                <form action="" id="step_one_fixed" class="step_one_fixed">
                                    <div class="step-wrap1">
                                        <div class="row g-2">
                                            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="front-select">
                                                    <label for="" class="site-label">TARIFA DE ACCESO</label>
                                                    <select name="access_fee" class="form-select front-select-style">
                                                        <option value="">SELECCIONAR TARIFA DE ACCESO</option>
                                                        @foreach ($companyAccessfee as $companyAccessfeeitem)
                                                        <option value="{{$companyAccessfeeitem->id}}">{{$companyAccessfeeitem->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-9 col-md-9 col-sm-8 col-12">
                                                <div class="front-input">
                                                    <label for="" class="site-label">PERIODO FACTURACION</label>
                                                    <input name="invoice_period" type="text" id="invoice_period" class="form-control front-input-style" placeholder="PERIODO FACTURACION" required>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12">
                                                <div class="front-input">
                                                    <label for="" class="site-label">DIAS</label>
                                                    <input name="" type="text" class="form-control front-input-style readonly total_days_show" value="" readonly>
                                                    <input type="hidden" name="total_days" id="total_days" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mt-0">
                                            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="calculate-wrap">
                                                    {{-- <div class="calculate-wrap-width">
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
                                                    </div> --}}
                                                    {{-- <div class="calculate-wrap-auto hired_potency_section">
                                                        <div class="calculate-box-head">TERMINO FIJO</div>
                                                        <div class="calculate-box">
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="hired_potencyp1" type="number" class="form-control hired_potencyp1" value="{{session('indexFixedInputData')['hired_potencyp1'] ?? '' }}">
                                                                </div>
                                                            </div> --}}
                                                            {{-- <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="hired_potencyp2" type="number" class="form-control hired_potencyp2" value="{{session('indexFixedInputData')['hired_potencyp2'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="hired_potencyp3" type="number" class="form-control hired_potencyp3" value="{{session('indexFixedInputData')['hired_potencyp3'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="hired_potencyp4" type="number" class="form-control hired_potencyp4" value="{{session('indexFixedInputData')['hired_potencyp4'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="hired_potencyp5" type="number" class="form-control hired_potencyp5" value="{{session('indexFixedInputData')['hired_potencyp5'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="hired_potencyp6" type="number" class="form-control hired_potencyp6" value="{{session('indexFixedInputData')['hired_potencyp6'] ?? '' }}">
                                                                </div>
                                                            </div> --}}
                                                        {{-- </div>
                                                    </div> --}}
                                                    <div class="calculate-wrap-auto energy_consumed_section">
                                                        <div class="calculate-box-head">CONSUMO GAS</div>
                                                        <div class="calculate-box">
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="energy_consumedp1" type="number" class="form-control energy_consumedp1" value="{{session('indexFixedInputData')['energy_consumedp1'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            {{-- <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="energy_consumedp2" type="number" class="form-control energy_consumedp2" value="{{session('indexFixedInputData')['energy_consumedp2'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="energy_consumedp3" type="number" class="form-control energy_consumedp3" value="{{session('indexFixedInputData')['energy_consumedp3'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="energy_consumedp4" type="number" class="form-control energy_consumedp4" value="{{session('indexFixedInputData')['energy_consumedp4'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="energy_consumedp5" type="number" class="form-control energy_consumedp5" value="{{session('indexFixedInputData')['energy_consumedp5'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    <input name="energy_consumedp6" type="number" class="form-control energy_consumedp6" value="{{session('indexFixedInputData')['energy_consumedp6'] ?? '' }}">
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="other-calculate-wrap">
                                                    <div class="other-calculate">
                                                        <div class="other-calculate-lft">OTROS</div>
                                                        <div class="other-calculate-rgt">
                                                            <div class="input-group other-input">
                                                                <input name="other_number" type="number" class="form-control other_number" value="{{session('indexFixedInputData')['other_number'] ?? '' }}">
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
                                                                <input name="alquiler_contador" type="number" class="form-control alquiler_contador" value="{{session('indexFixedInputData')['alquiler_contador'] ?? '' }}">
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
                                                                <input name="rdl_number" type="number" class="form-control rdl_number" value="{{session('indexFixedInputData')['rdl_number'] ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="other-calculate">
                                                        <div class="other-calculate-lft">Impuesto Hidrocarburos</div>
                                                        <div class="other-calculate-rgt">
                                                            <div class="input-group other-input">
                                                                <input name="imp_electrico" type="number" class="form-control imp_electrico" value="0.00234">
                                                                {{-- <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="other-calculate">
                                                        <div class="other-calculate-lft">IVA</div>
                                                        <div class="other-calculate-rgt">
                                                            <div class="input-group other-input">
                                                                <input name="iva_number" type="number" class="form-control iva_number" value="21">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mt-0 justify-content-between">
                                            <div class="col-xl-6 col-lg-5 col-md-12 col-sm-12 col-12">
                                                <div class="total-calculate-wrap">
                                                    <div class="total-calculate-head">CONSUMO ANUAL ESTIMADO</div>
                                                    <div class="total-calculate-body bdy-clr">
                                                        <div class="input-group other-input">
                                                            <input name="annual_consumption" type="number" class="form-control total_invoice_now" value="{{session('indexFixedInputData')['annual_consumption'] ?? '' }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text total_invoice_now_show">KWH</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12">
                                                <div class="total-calculate-wrap">
                                                    <div class="total-calculate-head">IMPORTE FACTURA ACTUAL</div>
                                                    <div class="total-calculate-body bdy-clr">
                                                        <div class="input-group other-input">
                                                            <input name="total_invoice_now" type="number" class="form-control total_invoice_now" value="{{session('indexFixedInputData')['total_invoice_now'] ?? '' }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text total_invoice_now_show">€</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 justify-content-end">
                                            <div class="col-auto">
                                                <div class="back-prv-btn-box">
                                                    <button type="submit" class="back-prv-btn stepOneBtn">SIGUIENTE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form action="" id="step_two_fixed" class="step_two_fixed d-none">
                                    <div class="step-wrap2">
                                        <div class="row">
                                            <div class="table-responsive append_table table-pagination">

                                            </div>
                                        </div>
                                        <div class="row mt-4 justify-content-between">
                                            <div class="col-auto">
                                                <div class="back-prv-btn-box">
                                                    <button type="button" class="back-prv-btn stepTwoBackGasFixedBtn" onclick="stepTwoBackGasFixedBtn()">ATRÁS</button>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="back-prv-btn-box">
                                                    <button type="submit" class="back-prv-btn stepTwoBtn">SIGUIENTE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="step-wrap3 step_three_fixed d-none" id="step_three_fixed">

                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-12">
                                    <div class="progress mt-2" id="progressBar" style="display: none;">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">10%</div>
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
