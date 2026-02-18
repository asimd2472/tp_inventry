<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    @php
        $path = public_path('storage/images/'.$calculationdata['company_logo']);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $base64 = '';
        }

        if(Auth::user()->admin_img!=''){
            $path1 = public_path('storage/images/'.Auth::user()->admin_img);
            if (file_exists($path1)) {
                $type1 = pathinfo($path1, PATHINFO_EXTENSION);
                $data1 = file_get_contents($path1);
                $base64_user = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);
            } else {
                $base64_user = '';
            }
        }else{
            $base64_user = '';
        }
    @endphp

    <div class="margin-top">
        <table cellpadding="0" cellspacing="0"
            style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse; font-family: 'Poppins', sans-serif;">
            <thead>
                {{-- <tr>
                    @if(Auth::user()->admin_img!='')
                        <td style="padding-bottom: 2rem;">
                            <img style="width: 100px; height: 100px; display: block; border-radius: 50%; object-fit: cover;" src="{{ $base64_user }}" alt=""  />
                            <img style="width: 120px; display: block; margin-left: 1rem;" src="{{ $base64 }}" alt=""  />
                        </td>
                    @else
                        <td colspan="2" style="text-align: center; padding-bottom: 2rem;">
                            <img style="width: 120px; display: block;" src="{{ $base64 }}" alt=""  />
                        </td>
                    @endif
                </tr> --}}
                <tr>
                    <td colspan="2" style="padding: 0.25rem;">
                        <table cellpadding="0" cellspacing="0"
                            style="width: 100%; border-spacing: 0px; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    @if(Auth::user()->admin_img!='')
                                    <td style="padding-bottom: 2rem; width: 250px;">
                                        <img style="width: 100px; height: 100px; display: block; border-radius: 50%; object-fit: cover;" src="{{ $base64_user }}" alt=""  />
                                    </td>
                                    @endif
                                    <td style="padding-bottom: 2rem; text-align: center;">
                                        <img style="width: 120px; display: block; margin-left: 1rem;" src="{{ $base64 }}" alt=""  />
                                    </td>
                                    <td style="padding-bottom: 2rem; width: 250px;">
                                        <h4 style="margin: 0; padding: 0;">{{session('cupd_data')['name']}}</h4>
                                        <h4 style="margin: 0; padding: 0;">{{session('cupd_data')['cups']}}</h4>
                                        <h4 style="margin: 0; padding: 0;">{{$calculationdata['name_offer']}}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 0.25rem;">
                        <table cellpadding="0" cellspacing="0"
                            style="width: 100%; border-spacing: 0px; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    {{-- <td style="width: 60px;"></td> --}}
                                    {{-- <td
                                        style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px; width: 120px;">
                                        POTENCIA CONTRATADA</td> --}}
                                    <td
                                        style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px; width: 120px;">
                                        PRECIO TERMINO FIJO</td>
                                    <td
                                        style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px; width: 120px;">
                                        IMPORTE TERMINO FIJO</td>
                                </tr>
                                <tr>
                                    {{-- <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p1</td> --}}
                                    {{-- <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{@$comparissorinputdata['hired_potencyp1']}}</td> --}}
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_potencyp1']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['potency_amount_offerp1'], 2)}} €</td>
                                </tr>
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p2</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['hired_potencyp2']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_potencyp2']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['potency_amount_offerp2'], 2)}} €</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p3</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['hired_potencyp3']}}
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_potencyp3']}}
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['potency_amount_offerp3'], 2)}} €
                                    </td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p4</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['hired_potencyp4']}}
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_potencyp4']}}
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['potency_amount_offerp4'], 2)}} €</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p5</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['hired_potencyp5']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_potencyp5']}}
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['potency_amount_offerp5'], 2)}} €</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p6</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['hired_potencyp6']}}
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_potencyp6']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['potency_amount_offerp6'], 2)}} €</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </td>
                    <td style="padding: 0.25rem;">
                        <table cellpadding="0" cellspacing="0"
                            style="width: 100%; background: border-spacing: 0px; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    {{-- <td style="width: 60px;"></td> --}}
                                    <td
                                        style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px; width: 120px;">
                                        ENERGIA CONSUMIDA</td>
                                    <td
                                        style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px; width: 120px;">
                                        PRECIO ENERGIA</td>
                                    <td
                                        style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px; width: 120px;">
                                        PRECIO ENERGIA OFERTA</td>
                                </tr>
                                <tr>
                                    {{-- <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p1</td> --}}
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['energy_consumedp1']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_energyp1']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['energy_amount_offerp1'], 2)}} €</td>
                                </tr>
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p2</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['energy_consumedp2']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_energyp2']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['energy_amount_offerp2'], 2)}} €</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p3</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['energy_consumedp3']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_energyp3']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['energy_amount_offerp3'], 2)}} €</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p4</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['energy_consumedp4']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_energyp4']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['energy_amount_offerp4'], 2)}} €</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p5</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['energy_consumedp5']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_energyp5']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['energy_amount_offerp5'], 2)}} €</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #464c9a; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        p6</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['energy_consumedp6']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$calculationdata['price_energyp6']}}</td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['energy_amount_offerp6'], 2)}} €</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0.25rem;">
                        <table cellpadding="0" cellspacing="0"
                            style="width: 100%; border-spacing: 0px; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td
                                        style="width: 100px; padding: 0.425rem; height: 42px; color: #464c9a; font-weight: 700; font-size: .875rem; text-align: center; border: 1px solid #dee2e6;">
                                        OTROS
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['other_number'] == '' ? '' : $comparissorinputdata['other_number'].' €'}}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="width: 100px; padding: 0.425rem; height: 42px; color: #464c9a; font-weight: 700; font-size: .875rem; text-align: center; border: 1px solid #dee2e6;">
                                        ALQUILER CONTADOR
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['alquiler_contador'] == '' ? '' : $comparissorinputdata['alquiler_contador'].' €'}}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="width: 100px; padding: 0.425rem; height: 42px; color: #464c9a; font-weight: 700; font-size: .875rem; text-align: center; border: 1px solid #dee2e6;">
                                        RDL
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['rdl_number'] == '' ? '' : $comparissorinputdata['rdl_number'].' €'}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="padding: 0.25rem; vertical-align: top;">
                        <table cellpadding="0" cellspacing="0"
                            style="width: 100%; border-spacing: 0px; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td
                                        style="width: 100px; padding: 0.425rem; height: 42px; color: #464c9a; font-weight: 700; font-size: .875rem; text-align: center; border: 1px solid #dee2e6;">
                                        IMP. Hidrocarburos
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['imp_electrico']}} %
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['imp_electrico_result'], 2)}} €
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="width: 100px; padding: 0.425rem; height: 42px; color: #464c9a; font-weight: 700; font-size: .875rem; text-align: center; border: 1px solid #dee2e6;">
                                        IVA
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{$comparissorinputdata['iva_number']}} %
                                    </td>
                                    <td
                                        style="padding: 0.425rem; text-transform: uppercase; color: #08adca; font-size: 0.875rem; font-weight: 700; text-align: center; border: 1px solid #dee2e6;">
                                        {{round($calculationdata['iva_result'], 2)}} €
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table cellpadding="0" cellspacing="0"
                        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0.25rem;">
                                        <table cellpadding="0" cellspacing="0"
                                            style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                            <tr>
                                                <td
                                                    style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px;">
                                                    IMPORTE FACTURA ACTUAL</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 0.425rem; text-transform: uppercase; height: 42px; color: #ff0000; font-size:1.5rem; font-weight: 700;  text-align: center; border: 1px solid #dee2e6;">
                                                    {{number_format($calculationdata['total_invoice_now'], 2, ',', '.')}}€
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 0.25rem;">
                                        <table cellpadding="0" cellspacing="0"
                                            style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                            <tr>
                                                <td
                                                    style="background-color: #454b99; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px;">
                                                    TOTAL SIMULACIÓN FACTURA</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 0.425rem; text-transform: uppercase; height: 42px; color: #000; font-size:1.5rem; font-weight: 700;  text-align: center; border: 1px solid #dee2e6;">
                                                    {{number_format($calculationdata['totalSimulatedInvoice'], 2, ',', '.')}}€
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 0.25rem;">
                                        <table cellpadding="0" cellspacing="0"
                                            style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                            <tr>
                                                <td
                                                    style="background-color: #1aab26; padding: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; font-size: 0.875rem; text-align: center; color: #fff; height: 42px;">
                                                    AHORRO ESTIMADO ANUAL</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 0.425rem; text-transform: uppercase; height: 42px; color: #1aab26; font-size:1.5rem; font-weight: 700;  text-align: center; border: 1px solid #dee2e6;">
                                                    {{number_format($calculationdata['estimated_anual_save'], 2, ',', '.')}}€
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
