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
        $path = public_path('storage/images/'.$settingdata->site_logo);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $base64 = '';
        }
    @endphp

<table
        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
        <thead>
            <tr>
                <td>
                    <table
                        style="width: 100%; background: #fff; padding: 0; margin: 0; border-spacing: 0px; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="text-align: left; padding: 15px 0;">
                                    <img style="width: 120px;"
                                        src="{{ $base64 }}"
                                        alt="">
                                </th>
                            </tr>
                        </thead>
                    </table>
                </td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 15px 0; vertical-align: top;">
                    <h4 style="padding: 3px 0; margin: 0; font-size: 14px;">CLIENTE</h4>
                    <h5 style="padding: 3px 0; margin: 0; font-size: 14px;">{{$user->name}}</h5>
                    <p style="padding: 3px 0 0 0; margin: 0; font-size: 14px;">{{$user->street}}, {{$user->city}}</p>
                    <p style="padding: 3px 0 0 0; margin: 0; font-size: 14px;">{{$user->zip_code}} ({{$user->state}})</p>
                    <p style="padding: 3px 0 0 0; margin: 0; font-size: 14px;">ID SALESPERSON</p>
                </td>
                <td style="padding: 15px 0; text-align: right; vertical-align: top;">
                    <h4 style="padding: 3px 0; margin: 0; font-size: 14px;">NEW ENERGY REVOLUTION SL</h4>
                    <h5 style="padding: 3px 0; margin: 0; font-size: 14px;">C/ ELECTRONICA 19, 9B</h5>
                    <p style="padding: 3px 0 0 0; margin: 0; font-size: 14px;">08915 BADALONA (BARCELONA)</p>
                    <p style="padding: 3px 0 0 0; margin: 0; font-size: 14px;">CIF - {{$settingdata->cif_nif}}</p>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: right; padding-bottom: 20px;">
                    <table
                        style="width: 100%; background: #fff; padding: 0; margin: 0; border-spacing: 0px; border-collapse: collapse;">
                        <tr>
                            <td><strong>Fecha</strong></td>
                            <td>
                                <p
                                    style="padding: 3px; margin: 0; font-size: 14px; text-align: center; background-color: #e4e5f9;">
                                    {{(new DateTime($payment->created_at))->format('Y-m-d')}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Nº Factura</strong></td>
                            <td>
                                <p style="padding: 3px 0 0 0; margin: 0; font-size: 14px; text-align: center;">
                                    {{$payment->translation_id}}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            @php
                $desc ='';
                $final_price = $payment->amount;
                if($payment->course_id!=''){
                    $course = DB::table('course')->where('id', $payment->course_id)->first();
                    $desc = @$course->title;

                    $iva = $course->vat;
                    $result = ($final_price * $iva) / 100;
                    $befour_tax = ($final_price-$result);

                }else if($payment->package_id!=''){
                    $package = DB::table('package')->where('id', $payment->package_id)->first();
                    $desc = @$package->package_title;


                    $iva = $settingdata->vat;
                    $result = ($final_price * $iva) / 100;
                    $befour_tax = ($final_price-$result);
                }


            @endphp

            @if($payment->package_id!='')
            <tr>
                <td colspan="2">
                    <table
                        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                        <thead>
                            <th style="text-align: center; padding: 5px; border: 1px solid #dddddd;">CONCEPTO</th>
                            <th style="text-align: center; padding: 5px; border: 1px solid #dddddd;">PRECIO</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: left; padding: 5px; border: 1px solid #dddddd; font-size: 14px;">
                                    {{$desc}}
                                </td>
                                <td style="text-align: right; padding: 5px; border: 1px solid #dddddd;">{{$befour_tax}} €</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="padding-top: 20px;">
                                    <table
                                        style="width: 100%; height: 170px; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="padding: 5px;  border: 1px solid #dddddd; background-color: #ebebff; text-align: left;">
                                                    COMENTARIOS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="padding: 60px;  border: 1px solid #dddddd; vertical-align: top;">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 200px;">
                                    <table
                                        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                SUBTOTAL
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong>{{$befour_tax}} €</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                TASA DE IMPUESTO
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong>{{$result}} €</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                IMPUESTO
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; padding: 5px;" colspan="1">
                                                TOTAL
                                            </td>
                                            <td style="text-align: right; padding: 5px; border: 1px solid #dddddd;">
                                                <strong>{{$final_price}} €</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-top: 20px;">
                                                <p
                                                    style="padding: 3px; margin: 0; font-weight: 800; font-size: 12px; text-align: center; background-color: #e4e5f9;">
                                                    DE PROFESION COMERCIAL</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
            @endif
            @if($payment->course_id!='')
            @if($iva!=0)
            <tr>
                <td colspan="2">
                    <table
                        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                        <thead>
                            <th style="text-align: center; padding: 5px; border: 1px solid #dddddd;">CONCEPTO</th>
                            <th style="text-align: center; padding: 5px; border: 1px solid #dddddd;">PRECIO</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: left; padding: 5px; border: 1px solid #dddddd; font-size: 14px;">
                                    {{$desc}}
                                </td>
                                <td style="text-align: right; padding: 5px; border: 1px solid #dddddd;">{{$befour_tax}} €</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="padding-top: 20px;">
                                    <table
                                        style="width: 100%; height: 170px; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="padding: 5px;  border: 1px solid #dddddd; background-color: #ebebff; text-align: left;">
                                                    COMENTARIOS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="padding: 60px;  border: 1px solid #dddddd; vertical-align: top;">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 200px;">
                                    <table
                                        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                SUBTOTAL
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong>{{$befour_tax}} €</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                TASA DE IMPUESTO
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong>{{$result}} €</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                IMPUESTO
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; padding: 5px;" colspan="1">
                                                TOTAL
                                            </td>
                                            <td style="text-align: right; padding: 5px; border: 1px solid #dddddd;">
                                                <strong>{{$final_price}} €</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-top: 20px;">
                                                <p
                                                    style="padding: 3px; margin: 0; font-weight: 800; font-size: 12px; text-align: center; background-color: #e4e5f9;">
                                                    DE PROFESION COMERCIAL</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
            @else
            <tr>
                <td colspan="2">
                    <table
                        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                        <thead>
                            <th style="text-align: center; padding: 5px; border: 1px solid #dddddd;">CONCEPTO</th>
                            <th style="text-align: center; padding: 5px; border: 1px solid #dddddd;">PRECIO</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: left; padding: 5px; border: 1px solid #dddddd; font-size: 14px;">
                                    {{$desc}}
                                </td>
                                <td style="text-align: right; padding: 5px; border: 1px solid #dddddd;">{{$final_price}} €</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="padding-top: 20px;">
                                    <table
                                        style="width: 100%; height: 170px; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="padding: 5px;  border: 1px solid #dddddd; background-color: #ebebff; text-align: left;">
                                                    COMENTARIOS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="padding: 60px;  border: 1px solid #dddddd; vertical-align: top;">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 200px;">
                                    <table
                                        style="width: 100%; background: #fff; padding: 0; margin: 0 auto; border-spacing: 0px; border-collapse: collapse;">
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                SUBTOTAL
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong>{{$final_price}} €</strong>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                TASA DE IMPUESTO
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong>{{$result}} €</strong>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <td style="text-align: right; padding: 5px; font-size: 12px;">
                                                IMPUESTO
                                            </td>
                                            <td
                                                style="text-align: right; padding: 5px; border: 1px solid #dddddd; font-size: 12px;">
                                                <strong></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; padding: 5px;" colspan="1">
                                                TOTAL
                                            </td>
                                            <td style="text-align: right; padding: 5px; border: 1px solid #dddddd;">
                                                <strong>{{$final_price}} €</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-top: 20px;">
                                                <p
                                                    style="padding: 3px; margin: 0; font-weight: 800; font-size: 12px; text-align: center; background-color: #e4e5f9;">
                                                    DE PROFESION COMERCIAL</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
            @endif
            @endif
            <tr>
                <td colspan="2" style="padding: 25px 0; ">
                    <table
                        style="width: 100%; background: #fff; padding: 0; margin: 0; border-spacing: 0px; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="padding-top: 30px;">
                                    <p
                                        style="padding: 0; margin: 0px; font-size: 14px; color: #04041c; text-align: center;">
                                        hola@deprofesioncomercial.com</p>
                                    <p
                                        style="padding: 0; margin: 0px; font-size: 14px; color: #04041c; text-align: center; font-weight: 800;">
                                        ¡Gracias!</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
