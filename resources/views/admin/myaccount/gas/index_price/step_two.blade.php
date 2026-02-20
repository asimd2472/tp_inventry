<div class="step-wrap1">
    <div class="row g-2">
        <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12">
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
                        </div> --}}
                        {{-- <div class="value-box">
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
                    <div class="other-calculate-lft">IMP. ELECTRICO</div>
                    <div class="other-calculate-rgt">
                        <div class="input-group other-input">
                            <input name="imp_electrico" type="number" class="form-control imp_electrico" value="{{session('indexFixedInputData')['imp_electrico'] ?? '' }}">
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
                            <input name="iva_number" type="number" class="form-control iva_number" value="{{session('indexFixedInputData')['iva_number'] ?? '' }}">
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
    <div class="row mt-4 justify-content-between">
        <div class="col-auto">
            <div class="back-prv-btn-box">
                <button type="button" class="back-prv-btn stepTwoBackBtn" onclick="gasIndexStepTwoBackBtn()">ATRÁS</button>
            </div>
        </div>
        <div class="col-auto">
            <div class="back-prv-btn-box">
                <button type="submit" class="back-prv-btn stepOneBtn">SIGUIENTE</button>
            </div>
        </div>
    </div>
</div>
