@php
    $price_month=0;
    if($companyIndexenergyPrice->price_month=='1'){
        $price_month = 'ENERO';
    }else if($companyIndexenergyPrice->price_month=='2'){
        $price_month = 'FEBRERO';
    }else if($companyIndexenergyPrice->price_month=='3'){
        $price_month = 'MARZO';
    }else if($companyIndexenergyPrice->price_month=='4'){
        $price_month = 'ABRIL';
    }else if($companyIndexenergyPrice->price_month=='5'){
        $price_month = 'MAYO';
    }else if($companyIndexenergyPrice->price_month=='6'){
        $price_month = 'JUNIO';
    }else if($companyIndexenergyPrice->price_month=='7'){
        $price_month = 'JULIO';
    }else if($companyIndexenergyPrice->price_month=='8'){
        $price_month = 'AGOSTO';
    }else if($companyIndexenergyPrice->price_month=='9'){
        $price_month = 'SEPTIEMBRE';
    }else if($companyIndexenergyPrice->price_month=='10'){
        $price_month = 'OCTUBRE';
    }else if($companyIndexenergyPrice->price_month=='11'){
        $price_month = 'NOVIEMBRE';
    }else if($companyIndexenergyPrice->price_month=='12'){
        $price_month = 'DICIEMBRE';
    }

@endphp

<tr>
    <td>{{ucfirst($price_month)}}</td>
    <td class="sticky">{{$companyIndexenergyPrice->price_year}}</td>
    <td>{{$companyIndexenergyPrice->twotd_price_energy1 != '' ? number_format($companyIndexenergyPrice->twotd_price_energy1, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->twotd_price_energy2 != '' ? number_format($companyIndexenergyPrice->twotd_price_energy2, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->twotd_price_energy3 != '' ? number_format($companyIndexenergyPrice->twotd_price_energy3, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->threetd_price_energy1 != '' ? number_format($companyIndexenergyPrice->threetd_price_energy1, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->threetd_price_energy2 != '' ? number_format($companyIndexenergyPrice->threetd_price_energy2, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->threetd_price_energy3 != '' ? number_format($companyIndexenergyPrice->threetd_price_energy3, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->threetd_price_energy4 != '' ? number_format($companyIndexenergyPrice->threetd_price_energy4, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->threetd_price_energy5 != '' ? number_format($companyIndexenergyPrice->threetd_price_energy5, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->threetd_price_energy6 != '' ? number_format($companyIndexenergyPrice->threetd_price_energy6, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixonetd_price_energy1 != '' ? number_format($companyIndexenergyPrice->sixonetd_price_energy1, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixonetd_price_energy2 != '' ? number_format($companyIndexenergyPrice->sixonetd_price_energy2, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixonetd_price_energy3 != '' ? number_format($companyIndexenergyPrice->sixonetd_price_energy3, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixonetd_price_energy4 != '' ? number_format($companyIndexenergyPrice->sixonetd_price_energy4, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixonetd_price_energy5 != '' ? number_format($companyIndexenergyPrice->sixonetd_price_energy5, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixonetd_price_energy6 != '' ? number_format($companyIndexenergyPrice->sixonetd_price_energy6, 6) : ''}}</td>

    <td>{{$companyIndexenergyPrice->sixtwotd_price_energy1 != '' ? number_format($companyIndexenergyPrice->sixtwotd_price_energy1, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixtwotd_price_energy2 != '' ? number_format($companyIndexenergyPrice->sixtwotd_price_energy2, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixtwotd_price_energy3 != '' ? number_format($companyIndexenergyPrice->sixtwotd_price_energy3, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixtwotd_price_energy4 != '' ? number_format($companyIndexenergyPrice->sixtwotd_price_energy4, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixtwotd_price_energy5 != '' ? number_format($companyIndexenergyPrice->sixtwotd_price_energy5, 6) : ''}}</td>
    <td>{{$companyIndexenergyPrice->sixtwotd_price_energy6 != '' ? number_format($companyIndexenergyPrice->sixtwotd_price_energy6, 6) : ''}}</td>
  </tr>
