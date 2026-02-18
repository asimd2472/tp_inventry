<div id="results_body" class="position-relative">
    {{-- @if(Auth::user()->admin_img!='')
        <div class="user-img-wrap">
            <span class="user-img-wrap-img">
                <img class="img-block" src="{{asset('storage/images/'.Auth::user()->admin_img)}}">
            </span>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-2 col-md-6 col-sm-6 col-12">
            <div class="company-list-icon-wrap">
                <span class="company-icon-box-wrap">
                    <img class="img-block" src="{{asset('storage/images/'.$calculationdata['company_logo'])}}">
                    <input type="hidden" name="company_id" id="company_id" value="{{$calculationdata['company_id']}}">
                    <input type="hidden" name="offer" id="offer" value="{{$calculationdata['name_offer']}}">
                </span>
            </div>
        </div>
    </div> --}}

    <div class="row justify-content-between g-3 mb-4">
        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
            @if(Auth::user()->admin_img!='')
                <div class="user-img-wrap">
                    <span class="user-img-wrap-img">
                        <img class="img-block" src="{{asset('storage/images/'.Auth::user()->admin_img)}}">
                    </span>
                </div>
            @endif
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12 col-12">
            <div class="company-list-icon-wrap">
                <span class="company-icon-box-wrap">
                    <img class="img-block" src="{{asset('storage/images/'.$calculationdata['company_logo'])}}">
                    <input type="hidden" name="company_id" id="company_id" value="{{$calculationdata['company_id']}}">
                    <input type="hidden" name="offer" id="offer" value="{{$calculationdata['name_offer']}}">
                </span>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
            <div class="name-details">
                <h4 class="user_name">{{session('cupd_data')['name']}}</h4>
                <h4 class="user_cups">{{session('cupd_data')['cups']}}</h4>
                <h4 class="user_name_offer">{{$calculationdata['name_offer']}}</h4>
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
                    <div class="calculate-box-head">POTENCIA CONTRATADA</div>
                    <div class="calculate-box">
                        <div class="value-box">
                            <div class="value-box-wrap value-area hired_potencyp1">{{$comparissorinputdata['hired_potencyp1']}}</div>
                        </div> --}}
                        {{-- <div class="value-box">
                            <div class="value-box-wrap value-area hired_potencyp2">{{$comparissorinputdata['hired_potencyp2']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area hired_potencyp3">{{$comparissorinputdata['hired_potencyp3']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area hired_potencyp4">{{$comparissorinputdata['hired_potencyp4']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area hired_potencyp5">{{$comparissorinputdata['hired_potencyp5']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area hired_potencyp6">{{$comparissorinputdata['hired_potencyp6']}}</div>
                        </div> --}}
                    {{-- </div>
                </div> --}}
                <div class="calculate-wrap-auto">
                    <div class="calculate-box-head">PRECIO TERMINO FIJO</div>
                    <div class="calculate-box">
                        <div class="value-box">
                            <div class="value-box-wrap value-area price_potencyp1">{{$calculationdata['price_potencyp1']}}</div>
                        </div>
                        {{-- <div class="value-box">
                            <div class="value-box-wrap value-area price_potencyp2">{{$calculationdata['price_potencyp2']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area price_potencyp3">{{$calculationdata['price_potencyp3']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area price_potencyp4">{{$calculationdata['price_potencyp4']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area price_potencyp5">{{$calculationdata['price_potencyp5']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area price_potencyp6">{{$calculationdata['price_potencyp6']}}</div>
                        </div> --}}
                    </div>
                </div>
                <div class="calculate-wrap-auto">
                    <div class="calculate-box-head">IMPORTE TERMINO FIJO</div>
                    <div class="calculate-box">
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="potency_amount_offerp1">{{round($calculationdata['potency_amount_offerp1'], 2)}}</span>&nbsp€</div>
                        </div>
                        {{-- <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="potency_amount_offerp2">{{round($calculationdata['potency_amount_offerp2'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="potency_amount_offerp3">{{round($calculationdata['potency_amount_offerp3'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="potency_amount_offerp4">{{round($calculationdata['potency_amount_offerp4'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="potency_amount_offerp5">{{round($calculationdata['potency_amount_offerp5'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="potency_amount_offerp6">{{round($calculationdata['potency_amount_offerp6'], 2)}}</span>&nbsp€</div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="calculate-wrap">
                {{-- <div class="calculate-wrap-width">
                    <div class="no-head"></div>
                    <div class="calculate-box">
                        <div class="value-box">
                            <div class="value-box-wrap">p1</div>
                        </div> --}}
                        {{-- <div class="value-box">
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
                        </div> --}}
                    {{-- </div>
                </div> --}}
                <div class="calculate-wrap-auto energy_consumed_section">
                    <div class="calculate-box-head">ENERGIA CONSUMIDA</div>
                    <div class="calculate-box">
                        <div class="value-box">
                            <div class="value-box-wrap value-area energy_consumedp1">{{$comparissorinputdata['energy_consumedp1']}}</div>
                        </div>
                        {{-- <div class="value-box">
                            <div class="value-box-wrap value-area energy_consumedp2">{{$comparissorinputdata['energy_consumedp2']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area energy_consumedp3">{{$comparissorinputdata['energy_consumedp3']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area energy_consumedp4">{{$comparissorinputdata['energy_consumedp4']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area energy_consumedp5">{{$comparissorinputdata['energy_consumedp5']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area energy_consumedp6">{{$comparissorinputdata['energy_consumedp6']}}</div>
                        </div> --}}
                    </div>
                </div>
                <div class="calculate-wrap-auto">
                    <div class="calculate-box-head">PRECIO ENERGIA</div>
                    <div class="calculate-box">
                        <div class="value-box">
                            <div class="value-box-wrap value-area valueprice_energy1">{{$afterofferEnergyresult[0]['valueprice_energy1']}}</div>
                        </div>
                        {{-- <div class="value-box">
                            <div class="value-box-wrap value-area valueprice_energy2">{{$afterofferEnergyresult[0]['valueprice_energy2']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area valueprice_energy3">{{$afterofferEnergyresult[0]['valueprice_energy3']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area valueprice_energy4">{{$afterofferEnergyresult[0]['valueprice_energy4']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area valueprice_energy5">{{$afterofferEnergyresult[0]['valueprice_energy5']}}</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area valueprice_energy6">{{$afterofferEnergyresult[0]['valueprice_energy6']}}</div>
                        </div> --}}
                    </div>
                </div>
                <div class="calculate-wrap-auto">
                    <div class="calculate-box-head">PRECIO ENERGIA OFERTA</div>
                    <div class="calculate-box">
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="energy_amount_offerp1">{{round($calculationdata['energy_amount_offerp1'], 2)}}</span>&nbsp€</div>
                        </div>
                        {{-- <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="energy_amount_offerp2">{{round($calculationdata['energy_amount_offerp2'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="energy_amount_offerp3">{{round($calculationdata['energy_amount_offerp3'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="energy_amount_offerp4">{{round($calculationdata['energy_amount_offerp4'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="energy_amount_offerp5">{{round($calculationdata['energy_amount_offerp5'], 2)}}</span>&nbsp€</div>
                        </div>
                        <div class="value-box">
                            <div class="value-box-wrap value-area"><span class="energy_amount_offerp6">{{round($calculationdata['energy_amount_offerp6'], 2)}}</span>&nbsp€</div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-2 mt-0">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="other-calculate-wrap">
                <div class="other-calculate">
                    <div class="other-calculate-lft">OTROS</div>
                    <div class="other-calculate-value">
                        <div class="other-value other_number">{{$comparissorinputdata['other_number'] == '' ? '' : $comparissorinputdata['other_number'].' €'}} </div>
                    </div>
                </div>
                <div class="other-calculate">
                    <div class="other-calculate-lft">ALQUILER CONTADOR</div>
                    <div class="other-calculate-value">
                        <div class="other-value alquiler_contador">{{$comparissorinputdata['alquiler_contador'] == '' ? '' : $comparissorinputdata['alquiler_contador'].' €'}} </div>
                    </div>
                </div>
                <div class="other-calculate">
                    <div class="other-calculate-lft">RDL</div>
                    <div class="other-calculate-value">
                        <div class="other-value rdl_number">{{$comparissorinputdata['rdl_number'] == '' ? '' : $comparissorinputdata['rdl_number'].' €'}} </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="other-calculate-wrap">
                <div class="other-calculate">
                    <div class="other-calculate-lft">IMP. Hidrocarburos</div>
                    <div class="other-calculate-value">
                        <div class="other-value imp_electrico">{{$comparissorinputdata['imp_electrico']}} %</div>
                    </div>
                    <div class="other-calculate-value">
                        <div class="other-value imp_electrico_show imp_electrico_result">{{round($calculationdata['imp_electrico_result'], 2)}} €</div>
                    </div>
                </div>
                <div class="other-calculate">
                    <div class="other-calculate-lft">IVA</div>
                    <div class="other-calculate-value">
                        <div class="other-value iva_number">{{$comparissorinputdata['iva_number']}} %</div>
                    </div>
                    <div class="other-calculate-value">
                        <div class="other-value iva_show iva_result">{{round($calculationdata['iva_result'], 2)}} €</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-2 mt-0">
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="total-calculate-wrap">
                <div class="total-calculate-head">IMPORTE FACTURA ACTUAL</div>
                <div class="total-calculate-body totalSimulatedInvoice_show total_invoice_now" style="color: #ff0000">{{number_format($calculationdata['total_invoice_now'], 2, ',', '.')}} €</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="total-calculate-wrap">
                <div class="total-calculate-head">TOTAL SIMULACIÓN FACTURA</div>
                <div class="total-calculate-body totalSimulatedInvoice_show totalSimulatedInvoice" style="color: #000">{{number_format($calculationdata['totalSimulatedInvoice'], 2, ',', '.')}} €</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="total-calculate-wrap">
                <div class="total-calculate-head" style="background-color:#1aab26;">AHORRO ESTIMADO ANUAL</div>
                <div class="total-calculate-body estimated_anual_save_show estimated_anual_save" style="color: #1aab26">{{number_format($calculationdata['estimated_anual_save'], 2, ',', '.')}} €</div>
            </div>
        </div>
    </div>
</div>


<div class="row mt-4 justify-content-between">
    <div class="col-auto">
        <div class="back-prv-btn-box">
            <button type="button" class="back-prv-btn" onclick="gasIndexStepfourBackBtn()">ATRÁS</button>
        </div>
    </div>
    <div class="col-auto">
        <div class="back-prv-btn-box">
            {{-- <button class="back-prv-btn" id="downloadPdfbtn">DESCARGAR</button> --}}
            <a href="{{url('user/gas-download-index')}}/{{$price_id}}" target="_blank" class="back-prv-btn">DESCARGAR</a>
            <button type="button" class="back-prv-btn" onclick="tramitar_btn()">GUARDAR</button>
            <a href="https://tramitatucontrato.energy" target="_blank" class="back-prv-btn">TRAMITAR</a>
        </div>
    </div>
</div>



<!-- Include latest html2canvas library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<!-- Include latest jsPDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script type="module">

        // document.getElementById('downloadPdfbtn').addEventListener('click', async function() {
        //     var element = document.getElementById('results_body');
        //     const canvas = await html2canvas(element, {
        //         scale: 2,
        //         useCORS: true
        //     });
        //     const imgData = canvas.toDataURL('image/png');

        //     const { jsPDF } = window.jspdf;
        //     const pdf = new jsPDF({
        //         orientation: 'landscape',
        //         unit: 'pt',
        //         format: 'a4'
        //     });
        //     const imgWidth = 595.28;
        //     const pageHeight = 841.89;
        //     const imgHeight = (canvas.height * imgWidth) / canvas.width;
        //     let heightLeft = imgHeight;
        //     let position = 0;

        //     pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        //     heightLeft -= pageHeight;

        //     while (heightLeft >= 0) {
        //         position = heightLeft - imgHeight;
        //         pdf.addPage();
        //         pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        //         heightLeft -= pageHeight;
        //     }

        //     pdf.save('COMPARADOR-DOWNLOAD.pdf');
        // });
    document.getElementById('downloadPdfbtn').addEventListener('click', async function() {
        var element = document.getElementById('results_body');


        const canvas = await html2canvas(element, {
            scale: 2,
            useCORS: true
        });
        const imgData = canvas.toDataURL('image/png');

        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({
            orientation: 'landscape',
            unit: 'pt',
            format: 'a4'
        });
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgWidth = canvas.width * 0.40;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        const x = (pageWidth - imgWidth) / 2;
        const y = (pageHeight - imgHeight) / 2;

        pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
        pdf.save('quote-history-download.pdf');
    });
</script>
