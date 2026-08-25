@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <section class="sv-visit-details">

                            <div class="sv-visit-details-header">
                                <div class="sv-visit-details-header-inner">
                                    <a href="{{ route('admin.site_visit_record') }}" class="sv-visit-details-back" title="Back to listing">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <div class="sv-visit-details-header-text">
                                        <span class="sv-visit-details-eyebrow">Site Visit #{{ $visit->id }}</span>
                                        <h1>{{ $visit->customer_name }}</h1>
                                    </div>
                                    <span class="sv-interest-badge {{ $interestClass }}">
                                        {{ $visit->interest }} Interest
                                    </span>
                                </div>
                            </div>

                            <div class="sv-visit-details-body">

                                <div class="sv-visit-details-summary">
                                    <div class="sv-visit-summary-card">
                                        <span class="sv-visit-summary-label">Visit Date</span>
                                        <strong>{{ $visitDate }}</strong>
                                        <small>{{ $visitTime }}</small>
                                    </div>
                                    <div class="sv-visit-summary-card">
                                        <span class="sv-visit-summary-label">Total Products</span>
                                        <strong>{{ (int) ($visit->qty_total ?? 0) }}</strong>
                                        <small>Estimated quantity</small>
                                    </div>
                                    <div class="sv-visit-summary-card">
                                        <span class="sv-visit-summary-label">Timeline</span>
                                        <strong>{{ $visit->timeline ?: '—' }}</strong>
                                        <small>Purchase window</small>
                                    </div>
                                    <div class="sv-visit-summary-card">
                                        <span class="sv-visit-summary-label">Follow-up</span>
                                        <strong>{{ $visit->follow_up ? 'Required' : 'Not Required' }}</strong>
                                        <small>Next action</small>
                                    </div>
                                </div>

                                {{-- Customer --}}
                                <div class="sv-visit-panel">
                                    <div class="sv-visit-panel-head">
                                        <span class="sv-visit-panel-step">01</span>
                                        <div>
                                            <h2>Customer Details</h2>
                                            <p>Contact information captured on site</p>
                                        </div>
                                    </div>
                                    <div class="sv-visit-grid">
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Customer Name</span>
                                            <span class="sv-visit-field-value">{{ $visit->customer_name }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Mobile Number</span>
                                            <span class="sv-visit-field-value">
                                                <a href="tel:{{ $visit->mobile }}">{{ $visit->mobile }}</a>
                                            </span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Alternate Mobile</span>
                                            <span class="sv-visit-field-value">
                                                @if($visit->alt_mobile)
                                                    <a href="tel:{{ $visit->alt_mobile }}">{{ $visit->alt_mobile }}</a>
                                                @else
                                                    —
                                                @endif
                                            </span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Email</span>
                                            <span class="sv-visit-field-value">
                                                @if($visit->customer_email)
                                                    <a href="mailto:{{ $visit->customer_email }}">{{ $visit->customer_email }}</a>
                                                @else
                                                    —
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="sv-visit-panel">
                                    <div class="sv-visit-panel-head">
                                        <span class="sv-visit-panel-step">02</span>
                                        <div>
                                            <h2>Site Location</h2>
                                            <p>Installation address and map reference</p>
                                        </div>
                                    </div>
                                    <div class="sv-visit-grid">
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">State</span>
                                            <span class="sv-visit-field-value">{{ $visit->state ?: '—' }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">District</span>
                                            <span class="sv-visit-field-value">{{ $visit->district ?: '—' }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">PIN Code</span>
                                            <span class="sv-visit-field-value">{{ $visit->pincode ?: '—' }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">GPS Coordinates</span>
                                            <span class="sv-visit-field-value">{{ $gpsCoordinates ?: '—' }}</span>
                                        </div>
                                    </div>
                                    @if($visit->maps_link)
                                        <a href="{{ $visit->maps_link }}" target="_blank" rel="noopener noreferrer" class="sv-visit-map-link">
                                            <i class="fas fa-map-marked-alt"></i>
                                            Open in Google Maps
                                        </a>
                                    @endif
                                </div>

                                {{-- Executive --}}
                                <div class="sv-visit-panel">
                                    <div class="sv-visit-panel-head">
                                        <span class="sv-visit-panel-step">03</span>
                                        <div>
                                            <h2>Sales Team</h2>
                                            <p>Executive and manager information</p>
                                        </div>
                                    </div>
                                    <div class="sv-visit-grid">
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Sales Executive</span>
                                            <span class="sv-visit-field-value">{{ $executiveName }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Executive Email</span>
                                            <span class="sv-visit-field-value">{{ $executiveEmail }}</span>
                                        </div>
                                        @if($showManager)
                                            <div class="sv-visit-field">
                                                <span class="sv-visit-field-label">Sales Manager</span>
                                                <span class="sv-visit-field-value">{{ $managerName }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Construction & Products --}}
                                <div class="sv-visit-panel">
                                    <div class="sv-visit-panel-head">
                                        <span class="sv-visit-panel-step">04</span>
                                        <div>
                                            <h2>Requirement Details</h2>
                                            <p>Construction stage, products and quantities</p>
                                        </div>
                                    </div>
                                    <div class="sv-visit-grid sv-visit-grid--full">
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Construction Stage</span>
                                            <span class="sv-visit-field-value">{{ $visit->construction_stage ?: '—' }}</span>
                                        </div>
                                    </div>

                                    @if(count($products) > 0)
                                        <div class="sv-visit-chip-group">
                                            <span class="sv-visit-field-label">Products Required</span>
                                            <div class="sv-visit-chips">
                                                @foreach($products as $product)
                                                    <span class="sv-visit-chip">{{ $product }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if(count($categories) > 0)
                                        <div class="sv-visit-chip-group">
                                            <span class="sv-visit-field-label">Categories</span>
                                            <div class="sv-visit-chips">
                                                @foreach($categories as $category)
                                                    <span class="sv-visit-chip sv-visit-chip--muted">{{ $category }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="sv-visit-qty-grid">
                                        <div class="sv-visit-qty-item">
                                            <span>Doors</span>
                                            <strong>{{ (int) ($visit->qty_doors ?? 0) }}</strong>
                                        </div>
                                        <div class="sv-visit-qty-item">
                                            <span>Windows</span>
                                            <strong>{{ (int) ($visit->qty_windows ?? 0) }}</strong>
                                        </div>
                                        <div class="sv-visit-qty-item">
                                            <span>Frames</span>
                                            <strong>{{ (int) ($visit->qty_frames ?? 0) }}</strong>
                                        </div>
                                        <div class="sv-visit-qty-item">
                                            <span>Others</span>
                                            <strong>{{ (int) ($visit->qty_others ?? 0) }}</strong>
                                        </div>
                                        <div class="sv-visit-qty-item sv-visit-qty-item--total">
                                            <span>Total</span>
                                            <strong>{{ (int) ($visit->qty_total ?? 0) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Outcome --}}
                                <div class="sv-visit-panel">
                                    <div class="sv-visit-panel-head">
                                        <span class="sv-visit-panel-step">05</span>
                                        <div>
                                            <h2>Outcome & Notes</h2>
                                            <p>Budget, competitor, interest and remarks</p>
                                        </div>
                                    </div>
                                    <div class="sv-visit-grid">
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Budget</span>
                                            <span class="sv-visit-field-value">{{ $visit->budget ?: '—' }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Competitor</span>
                                            <span class="sv-visit-field-value">{{ $visit->competitor ?: '—' }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Customer Interest</span>
                                            <span class="sv-visit-field-value">
                                                <span class="sv-interest-badge {{ $interestClass }}">{{ $visit->interest }}</span>
                                            </span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Follow-up Required</span>
                                            <span class="sv-visit-field-value">
                                                @if($visit->follow_up)
                                                    <span class="sv-visit-status yes">Yes</span>
                                                @else
                                                    <span class="sv-visit-status no">No</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Intermediary / Influencer</span>
                                            <span class="sv-visit-field-value">{{ $visit->intermediary_name ?: '—' }}</span>
                                        </div>
                                        <div class="sv-visit-field">
                                            <span class="sv-visit-field-label">Intermediary Type</span>
                                            <span class="sv-visit-field-value">{{ $visit->intermediary_type ?: '—' }}</span>
                                        </div>
                                    </div>

                                    @if(count($visit->lead_status ?? []) > 0)
                                        <div class="sv-visit-chip-group">
                                            <span class="sv-visit-field-label">Lead Status</span>
                                            <div class="sv-visit-chips">
                                                @foreach($visit->lead_status as $status)
                                                    <span class="sv-visit-chip">{{ $status }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if(count($visit->drop_reasons ?? []) > 0)
                                        <div class="sv-visit-chip-group">
                                            <span class="sv-visit-field-label">Reasons for Drop</span>
                                            <div class="sv-visit-chips">
                                                @foreach($visit->drop_reasons as $reason)
                                                    <span class="sv-visit-chip sv-visit-chip--muted">{{ $reason }}</span>
                                                @endforeach
                                            </div>
                                            @if($visit->drop_reason_other)
                                                <p>{{ $visit->drop_reason_other }}</p>
                                            @endif
                                        </div>
                                    @endif

                                    @if($visit->remarks)
                                        <div class="sv-visit-remarks">
                                            <span class="sv-visit-field-label">Remarks</span>
                                            <p>{{ $visit->remarks }}</p>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
