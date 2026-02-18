@extends('layouts.front_user')
@section('content')

@php
    $pdf_invoice_data = session('pdf_invoice_data');
    // dd($pdf_invoice_data);
@endphp

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">COMPARADOR</div>
                        <div class="user-body">
                            <div class="row">
                                @if(isset($_GET['type']) && $_GET['type'] == 'electricity')
                                <div class="col-md-6">
                                    <div class="file-upload">
                                        <input type="file" name="admin_img" id="imgUpload" accept=".pdf">
                                        <label for="imgUpload">
                                            <i class="fa-solid fa-upload"></i>
                                            <p>Upload Invoice</p>
                                        </label>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="compar-wrap">
                                        <form action="{{ url('user/comparissor-type-' . (isset($_GET['type']) ? $_GET['type'] : '')) }}" method="GET">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="">CLIENTE</label>
                                                    {{-- <input type="text" class="form-control front-input-style" name="name" placeholder="CLIENTE" value="{{Session::get('user_session')->name}}" required=""> --}}
                                                    <input type="text" class="form-control front-input-style" name="name" placeholder="CLIENTE" value="{{@$pdf_invoice_data['cliente']}}" required="">
                                                </div>
                                            
                                                <div class="col-md-12">
                                                    <label for="CUPS">CUPS</label>
                                                    <input type="text" class="form-control front-input-style" name="cups" placeholder="CUPS" value="{{@$pdf_invoice_data['cups']}}" required="">
                                                </div>
                                            </div>
                                            <div class="row mt-4 justify-content-between">
                                                <div class="col-auto">
                                                    <div class="back-prv-btn-box">
                                                        <button type="submit" class="back-prv-btn stepTwoBtn">SIGUIENTE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
