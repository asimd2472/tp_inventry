@extends('layouts.app')
@section('content')
<section class="new-login-sec d-flex justify-content-center align-items-center">
    <div class="container">
        
        
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-ms-12 col-12">
                <div class="new-login-page inventory-bg g-3">
                    <div class="home-heading">Tata Pravesh Inventory</div>
                    <form action="" id="loginForm" class="loginForm inventory-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Product Type</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-door-closed"></i></span>
                                        <select class="form-control front-input-style" name="" id="type">
                                            <option value="">Select Product Type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">User Type</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-user"></i></span>
                                        <select class="form-control front-input-style" name="user_type" id="user_type">
                                            <option value="">Select User Type</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Model</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-barcode"></i></span>
                                        <select class="form-control front-input-style" name="" id="model">
                                            <option value="">Select Model</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="modelDescription" class="model-description"></div>
                            </div>
                            {{-- <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Finish</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-check-double"></i></span>
                                        <select class="form-control front-input-style" name="" id="finish">
                                            <option value="">Select Finish</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Design</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-brush"></i></span>
                                        <select class="form-control front-input-style" name="" id="design">
                                            <option value="">Select Design</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Dimention</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-paintbrush"></i></span>
                                        <select class="form-control front-input-style" name="" id="dimention">
                                            <option value="">Select Dimention</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Colour</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-ruler-vertical"></i></span>
                                        <select class="form-control front-input-style" name="" id="colour">
                                            <option value="">Select Colour</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Orientation</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-ruler-vertical"></i></span>
                                        <select class="form-control front-input-style" name="" id="orientation">
                                            <option value="">Select Orientation</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-ms-6">
                                <div class="front-input">
                                    <label for="" class="mb-1">Special Feature</label>
                                    <div class="position-relative add-icon-lft">
                                        <span class="icon-lft"><i class="fa-solid fa-ruler-vertical"></i></span>
                                        <select class="form-control front-input-style" name="" id="special_feature">
                                            <option value="">Select Special Feature</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-ms-12">
                                <div class="log-reg-submit-wrap d-flex justify-content-end">
                                    <button type="submit" class="log-reg-submit-btn" id="stockCheckBtn">Next</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row result-section" style="display: none;">
                        <div class="stock-card">
                            <h3 class="stock-title">Available Stock</h3>

                            <div class="stock-grid">
                                <div class="stock-item ultimate">
                                    <span class="label">Hyderabad</span>
                                    <span class="value hyderabad"></span>
                                </div>

                                <div class="stock-item all">
                                    <span class="label">NCR</span>
                                    <span class="value ncr"></span>
                                </div>

                                {{-- <div class="stock-item ultimate">
                                    <span class="label">Ultimate</span>
                                    <span class="value d_ultimate"></span>
                                </div>

                                <div class="stock-item tspl">
                                    <span class="label">GMP</span>
                                    <span class="value d_gmp"></span>
                                </div> --}}
                            </div>
                        </div>
                        {{-- <div class="stock-card">
                            <h3 class="stock-title">Available Stock in Hyderabad Warehouse</h3>

                            <div class="stock-grid">
                                <div class="stock-item tspl">
                                    <span class="label">Alhada</span>
                                    <span class="value h_alhada"></span>
                                </div>

                                <div class="stock-item all">
                                    <span class="label">TSPL</span>
                                    <span class="value h_tspl"></span>
                                </div>

                                <div class="stock-item ultimate">
                                    <span class="label">Ultimate</span>
                                    <span class="value h_ultimate"></span>
                                </div>

                                <div class="stock-item tspl">
                                    <span class="label">GMP</span>
                                    <span class="value h_gmp"></span>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-12 col-md-12 col-ms-12">
                            <div class="log-reg-submit-wrap d-flex justify-content-start">
                                <button type="submit" class="log-reg-submit-btn previous-btn" id="previous_btn">Previous</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        


        

    </div>
</section>





@push('scripts')

<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        var m_p = 0;
        var elements = document.querySelectorAll('.same_height');

        elements.forEach(function(element) {
            if (element.offsetHeight >= m_p) {
                m_p = element.offsetHeight;
            }
        });

        elements.forEach(function(element) {
            element.style.minHeight = m_p + "px";
        });
    });




</script>

@endpush

@endsection


