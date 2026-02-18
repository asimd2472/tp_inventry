@extends('layouts.front_user')
@section('content')

<style type="text/css">
    .energy-price th, .energy-price td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
        background: #fff,
    }
    .energy-price th{
        font-size: 13px;
        font-weight: bold;
        padding: 5px 0;
    }
    .energy-price td{
        padding: 8px 12px;
        font-size: 11px;
    }

    .energy-price tr th:first-child,
    .energy-price tr td:first-child {
        position: sticky;
        top:0;
        left: -1px;
        border-right: #000 1px solid;
        background: #aae9f7;
        color: #000;
    }
    .energy-price .sticky {
        position: sticky;
        top:0;
        left: 63px;
        color: #000000;
        background: #aae9f7;

    }
    .noPadding{
        padding: 0;
    }
</style>


@php
  
    $pdf_invoice_data = session('pdf_invoice_data');

    // echo "<pre>";
    // print_r($pdf_invoice_data);
    // echo "</pre>";

    $data_new = [];
    if (empty(session('indexFixedInputData'))) {
        if($pdf_invoice_data){

            $periodo_start = '';
            $start_month = '';
            $year = '';
            if(!empty($pdf_invoice_data['periodo_start']) && ($d = DateTime::createFromFormat('d/m/Y', $pdf_invoice_data['periodo_start']))){
                $periodo_start = $d->format('Y-m-d');
                $start_month = $d->format('n');
                $year = $d->format('Y');
            }

            $periodo_end = '';
            $end_month = '';
            if(!empty($pdf_invoice_data['periodo_end']) && ($e = DateTime::createFromFormat('d/m/Y', $pdf_invoice_data['periodo_end']))){
                $periodo_end = $e->format('Y-m-d');
                $end_month = $e->format('n');
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

                'start_month' => @$start_month,
                'end_month' => @$end_month,
                'year' => @$year,

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

                'start_month' => '',
                'end_month' => '',
                'year' => '',

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

            'start_month' => '',
            'end_month' => '',
            'year' => '',

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
                                <form action="" id="index_step_one" class="index_step_one">
                                    <div class="step-wrap1">
                                        <div class="row g-2">
                                            {{-- <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="front-select">
                                                    <label for="" class="site-label">MES</label>
                                                    <select name="month" class="form-select front-select-style" onchange="monthChnage(this.value)">
                                                        <option value="">SELECCIONAR MES</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                        @php
                                                            if($i=='1'){
                                                                $price_month = 'ENERO';
                                                            }else if($i=='2'){
                                                                $price_month = 'FEBRERO';
                                                            }else if($i=='3'){
                                                                $price_month = 'MARZO';
                                                            }else if($i=='4'){
                                                                $price_month = 'ABRIL';
                                                            }else if($i=='5'){
                                                                $price_month = 'MAYO';
                                                            }else if($i=='6'){
                                                                $price_month = 'JUNIO';
                                                            }else if($i=='7'){
                                                                $price_month = 'JULIO';
                                                            }else if($i=='8'){
                                                                $price_month = 'AGOSTO';
                                                            }else if($i=='9'){
                                                                $price_month = 'SEPTIEMBRE';
                                                            }else if($i=='10'){
                                                                $price_month = 'OCTUBRE';
                                                            }else if($i=='11'){
                                                                $price_month = 'NOVIEMBRE';
                                                            }else if($i=='12'){
                                                                $price_month = 'DICIEMBRE';
                                                            }

                                                        @endphp
                                                            <option value="{{ $i }}">{{$price_month}}</option>
                                                        @endfor
                                                    </select>
                                                    <input type="hidden" id="month">
                                                </div>
                                            </div> --}}
                                            <div class="col-xxl-4 col-xl-4 col-lg-9 col-md-9 col-sm-8 col-12">
                                                <div class="front-input">
                                                    <label for="" class="site-label">PERIODO FACTURACION</label>
                                                    <input name="index_invoice_period" type="text" id="index_invoice_period" class="form-control front-input-style" value="{{session('new_potency_input')['invoice_period']}}" placeholder="PERIODO FACTURACION" required>
                                                </div>
                                                <input type="hidden" name="start_month" value="{{session('new_potency_input')['start_month']}}">
                                                <input type="hidden" name="end_month" value="{{session('new_potency_input')['end_month']}}">
                                                <input type="hidden" name="total_days" id="total_days" value="{{session('new_potency_input')['total_days']}}">
                                            </div>
                                            @php
                                                $currentYear = date('Y');
                                            @endphp
                                            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="front-select">
                                                    <label for="" class="site-label">AÑO</label>
                                                    <select name="year" class="form-select front-select-style" onchange="yearChange(this.value)">
                                                        <option value="">SELECCIONAR AÑO</option>
                                                        <option value="{{ $currentYear - 1 }}" {{session('new_potency_input')['year']==($currentYear - 1) ? 'selected' : '' }}>{{ $currentYear - 1 }}</option>
                                                        <option value="{{ $currentYear }}" {{session('new_potency_input')['year']==($currentYear) ? 'selected' : '' }}>{{ $currentYear }}</option>
                                                        <option value="{{ $currentYear + 1 }}" {{session('new_potency_input')['year']==($currentYear + 1) ? 'selected' : '' }}>{{ $currentYear + 1 }}</option>
                                                    </select>
                                                    <input type="hidden" id="year" value="{{session('new_potency_input')['year']}}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row g-2 mt-0">
                                            <div class="table-responsive">
                                                {{-- <table class="energy-price" width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <th colspan="2">TARIFA DE ACCESO</th>
                                                        <th colspan="3">2.0TD</th>
                                                        <th colspan="6">3.0TD</th>
                                                        <th colspan="6">6.1TD</th>
                                                        <th colspan="6">6.2TD</th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">PERIODO</td>
                                                        <td>PRECIO ENERGIA P1</td>
                                                        <td>PRECIO ENERGIA P2</td>
                                                        <td>PRECIO ENERGIA P3</td>

                                                        <td>PRECIO ENERGIA P1</td>
                                                        <td>PRECIO ENERGIA P2</td>
                                                        <td>PRECIO ENERGIA P3</td>
                                                        <td>PRECIO ENERGIA P4</td>
                                                        <td>PRECIO ENERGIA P5</td>
                                                        <td>PRECIO ENERGIA P6</td>
                                                        <td>PRECIO ENERGIA P1</td>
                                                        <td>PRECIO ENERGIA P2</td>
                                                        <td>PRECIO ENERGIA P3</td>
                                                        <td>PRECIO ENERGIA P4</td>
                                                        <td>PRECIO ENERGIA P5</td>
                                                        <td>PRECIO ENERGIA P6</td>

                                                        <td>PRECIO ENERGIA P1</td>
                                                        <td>PRECIO ENERGIA P2</td>
                                                        <td>PRECIO ENERGIA P3</td>
                                                        <td>PRECIO ENERGIA P4</td>
                                                        <td>PRECIO ENERGIA P5</td>
                                                        <td>PRECIO ENERGIA P6</td>
                                                    </tr>
                                                    <tbody class="indexdatabody"></tbody>

                                                </table> --}}
                                            </div>
                                        </div>
                                        <div class="row mt-4 justify-content-end">
                                            <div class="col-auto">
                                                <div class="back-prv-btn-box">
                                                    <button type="submit" class="back-prv-btn indexStepOneBtn">SIGUIENTE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form action="" id="index_step_two" class="index_step_two d-none">

                                </form>

                                <form action="" id="index_step_three" class="index_step_three d-none">
                                    <div class="step-wrap2">
                                        <div class="row">
                                            <div class="table-responsive append_table">

                                            </div>
                                        </div>
                                        <div class="row mt-4 justify-content-between">
                                            <div class="col-auto">
                                                <div class="back-prv-btn-box">
                                                    <button type="button" class="back-prv-btn indexstepThreeBackBtn" onclick="indexstepThreeBackBtn()">ATRÁS</button>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="back-prv-btn-box">
                                                    <button type="submit" class="back-prv-btn indexstepthreeBtn">SIGUIENTE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="step-wrap3 index_step_four d-none" id="index_step_four">

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
