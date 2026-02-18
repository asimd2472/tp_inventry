@extends('layouts.front_user')
@section('content')

{{-- {{ \App\Helpers\NumberHelper::parseEuroNumber('1.234,56') }} --}}


@php
  
    $pdf_invoice_data = session('pdf_invoice_data');

    // echo "<pre>";
    // print_r($pdf_invoice_data);
    // echo "</pre>";

    $data_new = [];
    if (empty(session('indexFixedInputData'))) {
        if($pdf_invoice_data){

            $periodo_start = '';
            if(!empty($pdf_invoice_data['periodo_start']) && ($d = DateTime::createFromFormat('d/m/Y', $pdf_invoice_data['periodo_start']))){
                $periodo_start = $d->format('Y-m-d');
            }

            $periodo_end = '';
            if(!empty($pdf_invoice_data['periodo_end']) && ($e = DateTime::createFromFormat('d/m/Y', $pdf_invoice_data['periodo_end']))){
                $periodo_end = $e->format('Y-m-d');
            }

            $hired_potencyp2 = '';
            $hired_potencyp3 = '';
            if (@$pdf_invoice_data['tarifa_acceso'] == '2.0TD') {
                $hired_potencyp2 = !empty($pdf_invoice_data['potencia_contratada']['P2'])
                    ? $pdf_invoice_data['potencia_contratada']['P2']
                    : $pdf_invoice_data['potencia_contratada']['P3'];
                $hired_potencyp3 = '';
            } else {
                $hired_potencyp2 = $pdf_invoice_data['potencia_contratada']['P2'] ?? '';
                $hired_potencyp3 = $pdf_invoice_data['potencia_contratada']['P3'] ?? '';
            }

            $otros_raw = $pdf_invoice_data['otros'] ?? '';
            $alquiler_raw = $pdf_invoice_data['alquiler_contador'] ?? '';

            if ($otros_raw !== '' && $alquiler_raw !== '' && $otros_raw == $alquiler_raw) {
                $otros = '';
            } else {
                $otros = $otros_raw;
            }

            $data_new = [
                
                'invoice_period' => @$periodo_start.' to '.@$periodo_end,
                'total_days' => @$pdf_invoice_data['dias_facturados'], 

                'hired_potencyp1' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['potencia_contratada']['P1']),
                'hired_potencyp2' => \App\Helpers\NumberHelper::parseNumber(@$hired_potencyp2),
                'hired_potencyp3' => \App\Helpers\NumberHelper::parseNumber(@$hired_potencyp3),
                'hired_potencyp4' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['potencia_contratada']['P4']),
                'hired_potencyp5' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['potencia_contratada']['P5']),
                'hired_potencyp6' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['potencia_contratada']['P6']),

                'access_fee' => @$pdf_invoice_data['tarifa_acceso'],

                'energy_consumedp1' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['energia_consumida']['P1']),
                'energy_consumedp2' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['energia_consumida']['P2']),
                'energy_consumedp3' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['energia_consumida']['P3']),
                'energy_consumedp4' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['energia_consumida']['P4']),
                'energy_consumedp5' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['energia_consumida']['P5']),
                'energy_consumedp6' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['energia_consumida']['P6']),

                'other_number' => \App\Helpers\NumberHelper::parseNumber(@$otros),
                'alquiler_contador' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['alquiler_contador']),
                'rdl_number' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['excedentes']),
                'total_invoice_now' => \App\Helpers\NumberHelper::parseNumber(@$pdf_invoice_data['importe_total_factura']),

                'annual_consumption' => '',

            ];

            
            Session::put('new_potency_input', $data_new);
            // echo "<pre>";
            // print_r($data_new);
            // echo "</pre>";

            
        }else{
            $data_new = [
                
                'invoice_period' => '',
                'total_days' => '', 

                'hired_potencyp1' => '',
                'hired_potencyp2' => '',
                'hired_potencyp3' => '',
                'hired_potencyp4' => '',
                'hired_potencyp5' => '',
                'hired_potencyp6' => '',

                'access_fee' => '',

                'energy_consumedp1' => '',
                'energy_consumedp2' => '',
                'energy_consumedp3' => '',
                'energy_consumedp4' => '',
                'energy_consumedp5' => '',
                'energy_consumedp6' => '',

                'other_number' => '',
                'alquiler_contador' => '',
                'rdl_number' => '',
                'total_invoice_now' => '',

                'annual_consumption' => '',

            ];
        }
        Session::put('new_potency_input', $data_new);
    }else{
        $data_new = [

            'invoice_period' => '',
            'total_days' => '', 

            'hired_potencyp1' => session('indexFixedInputData')['hired_potencyp1'] ?? '',
            'hired_potencyp2' => session('indexFixedInputData')['hired_potencyp2'] ?? '',
            'hired_potencyp3' => session('indexFixedInputData')['hired_potencyp3'] ?? '',
            'hired_potencyp4' => session('indexFixedInputData')['hired_potencyp4'] ?? '',
            'hired_potencyp5' => session('indexFixedInputData')['hired_potencyp5'] ?? '',
            'hired_potencyp6' => session('indexFixedInputData')['hired_potencyp6'] ?? '',
            'access_fee' => '',
            'energy_consumedp1' => session('indexFixedInputData')['energy_consumedp1'] ?? '',
            'energy_consumedp2' => session('indexFixedInputData')['energy_consumedp2'] ?? '',
            'energy_consumedp3' => session('indexFixedInputData')['energy_consumedp3'] ?? '',
            'energy_consumedp4' => session('indexFixedInputData')['energy_consumedp4'] ?? '',
            'energy_consumedp5' => session('indexFixedInputData')['energy_consumedp5'] ?? '',
            'energy_consumedp6' => session('indexFixedInputData')['energy_consumedp6'] ?? '',

            'alquiler_contador' => session('indexFixedInputData')['alquiler_contador'] ?? '',
            'rdl_number' => session('indexFixedInputData')['rdl_number'] ?? '',
            'imp_electrico' => session('indexFixedInputData')['imp_electrico'] ?? '',
            'iva_number' => session('indexFixedInputData')['iva_number'] ?? '',
            'other_number' => session('indexFixedInputData')['other_number'] ?? '',
            'total_invoice_now' => session('indexFixedInputData')['total_invoice_now'] ?? '',
            'annual_consumption' => '',
            
        ];
        Session::put('new_potency_input', $data_new);
    }

    // echo "<pre>";
    // print_r(session('new_potency_input'));
    // echo "</pre>";
    // exit;


    $text_notes = $comparissorsNote ? json_decode($comparissorsNote->text, true) : [];
@endphp

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">COMPARADOR</div>
                        <div class="user-body">
                            <div class="compar-wrap">
                                <form action="" id="step_one" class="step_one">
                                    <div class="step-wrap1">
                                        <div class="row g-2">
                                            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="front-select">
                                                    <label for="" class="site-label">TARIFA DE ACCESO</label>
                                                    <select name="access_fee" class="form-select front-select-style">
                                                        <option value="">SELECCIONAR TARIFA DE ACCESO</option>
                                                        @foreach ($companyAccessfee as $companyAccessfeeitem)
                                                        <option value="{{$companyAccessfeeitem->id}}" {{session('new_potency_input')['access_fee']==$companyAccessfeeitem->title ? 'selected' : '' }}>{{$companyAccessfeeitem->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-9 col-md-9 col-sm-8 col-12">
                                                <div class="front-input">
                                                    <label for="" class="site-label">PERIODO FACTURACION</label>
                                                    <input name="invoice_period" type="text" id="invoice_period" class="form-control front-input-style" placeholder="PERIODO FACTURACION" required value="{{session('new_potency_input')['invoice_period']}}">
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12">
                                                <div class="front-input">
                                                    <label for="" class="site-label">DIAS</label>
                                                    <input name="" type="text" class="form-control front-input-style readonly total_days_show" value="{{session('new_potency_input')['total_days'] !='' ? session('new_potency_input')['total_days'].' DIAS' : '' }} " readonly>
                                                    <input type="hidden" name="total_days" id="total_days" value="{{session('new_potency_input')['total_days']}}">
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
                                                        <div class="calculate-box-head">POTENCIA CONTRATADA</div>
                                                        <div class="calculate-box">
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="hired_potencyp1" type="number" class="form-control hired_potencyp1" value="{{session('indexFixedInputData')['hired_potencyp1'] ?? '' }}"> --}}
                                                                    <input name="hired_potencyp1" type="number" class="form-control hired_potencyp1" value="{{session('new_potency_input')['hired_potencyp1'] ?? '' }}">
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="hired_potencyp2" type="number" class="form-control hired_potencyp2" value="{{session('indexFixedInputData')['hired_potencyp2'] ?? '' }}"> --}}
                                                                    <input name="hired_potencyp2" type="number" class="form-control hired_potencyp2" value="{{session('new_potency_input')['hired_potencyp2'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="hired_potencyp3" type="number" class="form-control hired_potencyp3" value="{{session('indexFixedInputData')['hired_potencyp3'] ?? '' }}"> --}}
                                                                    <input name="hired_potencyp3" type="number" class="form-control hired_potencyp3" value="{{session('new_potency_input')['hired_potencyp3'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="hired_potencyp4" type="number" class="form-control hired_potencyp4" value="{{session('indexFixedInputData')['hired_potencyp4'] ?? '' }}"> --}}
                                                                    <input name="hired_potencyp4" type="number" class="form-control hired_potencyp4" value="{{session('new_potency_input')['hired_potencyp4'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="hired_potencyp5" type="number" class="form-control hired_potencyp5" value="{{session('indexFixedInputData')['hired_potencyp5'] ?? '' }}"> --}}
                                                                    <input name="hired_potencyp5" type="number" class="form-control hired_potencyp5" value="{{session('new_potency_input')['hired_potencyp5'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="hired_potencyp6" type="number" class="form-control hired_potencyp6" value="{{session('indexFixedInputData')['hired_potencyp6'] ?? '' }}"> --}}
                                                                    <input name="hired_potencyp6" type="number" class="form-control hired_potencyp6" value="{{session('new_potency_input')['hired_potencyp6'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="calculate-wrap-auto energy_consumed_section">
                                                        <div class="calculate-box-head">ENERGIA CONSUMIDA</div>
                                                        <div class="calculate-box">
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="energy_consumedp1" type="number" class="form-control energy_consumedp1" value="{{session('indexFixedInputData')['energy_consumedp1'] ?? '' }}"> --}}
                                                                    <input name="energy_consumedp1" type="number" class="form-control energy_consumedp1" value="{{session('new_potency_input')['energy_consumedp1'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="energy_consumedp2" type="number" class="form-control energy_consumedp2" value="{{session('indexFixedInputData')['energy_consumedp2'] ?? '' }}"> --}}
                                                                    <input name="energy_consumedp2" type="number" class="form-control energy_consumedp2" value="{{session('new_potency_input')['energy_consumedp2'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="energy_consumedp3" type="number" class="form-control energy_consumedp3" value="{{session('indexFixedInputData')['energy_consumedp3'] ?? '' }}"> --}}
                                                                    <input name="energy_consumedp3" type="number" class="form-control energy_consumedp3" value="{{session('new_potency_input')['energy_consumedp3'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="energy_consumedp4" type="number" class="form-control energy_consumedp4" value="{{session('indexFixedInputData')['energy_consumedp4'] ?? '' }}"> --}}
                                                                    <input name="energy_consumedp4" type="number" class="form-control energy_consumedp4" value="{{session('new_potency_input')['energy_consumedp4'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="energy_consumedp5" type="number" class="form-control energy_consumedp5" value="{{session('indexFixedInputData')['energy_consumedp5'] ?? '' }}"> --}}
                                                                    <input name="energy_consumedp5" type="number" class="form-control energy_consumedp5" value="{{session('new_potency_input')['energy_consumedp5'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="value-box">
                                                                <div class="input-group value-box-wrap type-area">
                                                                    {{-- <input name="energy_consumedp6" type="number" class="form-control energy_consumedp6" value="{{session('indexFixedInputData')['energy_consumedp6'] ?? '' }}"> --}}
                                                                    <input name="energy_consumedp6" type="number" class="form-control energy_consumedp6" value="{{session('new_potency_input')['energy_consumedp6'] ?? '' }}">
                                                                </div>
                                                            </div>
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
                                                                {{-- <input name="other_number" type="number" class="form-control other_number" value="{{session('indexFixedInputData')['other_number'] ?? '' }}"> --}}
                                                                <input name="other_number" type="number" class="form-control other_number" value="{{session('new_potency_input')['other_number'] ?? '' }}">
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
                                                                {{-- <input name="alquiler_contador" type="number" class="form-control alquiler_contador" value="{{session('indexFixedInputData')['alquiler_contador'] ?? '' }}"> --}}
                                                                <input name="alquiler_contador" type="number" class="form-control alquiler_contador" value="{{session('new_potency_input')['alquiler_contador'] ?? '' }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">€</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="other-calculate">
                                                        <div class="other-calculate-lft">EXCEDENTES</div>
                                                        <div class="other-calculate-rgt">
                                                            <div class="input-group other-input">
                                                                {{-- <input name="rdl_number" type="number" class="form-control rdl_number" value="{{session('indexFixedInputData')['rdl_number'] ?? '' }}"> --}}
                                                                <input name="rdl_number" type="number" class="form-control rdl_number" value="{{session('new_potency_input')['rdl_number'] ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="other-calculate">
                                                        <div class="other-calculate-lft">IMP. ELECTRICO</div>
                                                        <div class="other-calculate-rgt">
                                                            <div class="input-group other-input">
                                                                {{-- <input name="imp_electrico" type="number" class="form-control imp_electrico" value="5.11"> --}}
                                                                <input name="imp_electrico" type="number" class="form-control imp_electrico" value="5.11">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="other-calculate">
                                                        <div class="other-calculate-lft">IVA</div>
                                                        <div class="other-calculate-rgt">
                                                            <div class="input-group other-input">
                                                                {{-- <input name="iva_number" type="number" class="form-control iva_number" value="21"> --}}
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
                                                            {{-- <input name="annual_consumption" type="number" class="form-control total_invoice_now" value="{{session('indexFixedInputData')['annual_consumption'] ?? '' }}"> --}}
                                                            <input name="annual_consumption" type="number" class="form-control total_invoice_now" value="{{session('new_potency_input')['annual_consumption'] ?? '' }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text total_invoice_now_show">KwH</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="other-calculate-note">

                                                    @foreach ($text_notes as $key => $item)
                                                        <p class="{{$key!=0 ? 'mt-2' : '' }}">{{$item}}</p>
                                                    @endforeach

                                                    {{-- <p>Recuerda añadir (si fuera necesario) los costes del servicio asociado a cada producto, por ejemplo 5€ para DELUXE y 4€ para PLENITUDE+.</p>
                                                    <p class="mt-2">Recuerda que los precios mostrados de algunas compañías no incluyen los SSAA (Mega, Acciona... Etc.). La media del año 2024 fue de 0,01143.</p> --}}
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12">
                                                <div class="total-calculate-wrap">
                                                    <div class="total-calculate-head">IMPORTE FACTURA ACTUAL</div>
                                                    <div class="total-calculate-body bdy-clr">
                                                        <div class="input-group other-input">
                                                            {{-- <input name="total_invoice_now" type="number" class="form-control total_invoice_now" value="{{session('indexFixedInputData')['total_invoice_now'] ?? '' }}"> --}}
                                                            <input name="total_invoice_now" type="number" class="form-control total_invoice_now" value="{{session('new_potency_input')['total_invoice_now'] ?? '' }}">
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
                                <form action="" id="step_two" class="step_two d-none">
                                    <div class="step-wrap2">
                                        <div class="row">
                                            <div class="table-responsive append_table table-pagination">

                                            </div>
                                        </div>
                                        <div class="row mt-4 justify-content-between">
                                            <div class="col-auto">
                                                <div class="back-prv-btn-box">
                                                    <button type="button" class="back-prv-btn stepTwoBackBtn" onclick="stepTwoBackBtn()">ATRÁS</button>
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
                                <div class="step-wrap3 step_three d-none" id="step_three">

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
