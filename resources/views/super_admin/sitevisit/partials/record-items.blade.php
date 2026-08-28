@if(count($items) === 0)
    {{-- <div class="sv-record-empty">
        <i class="fas fa-map-marker-alt"></i>
        <h4>No Site Visits Found</h4>
        <p>No visit records match your current filters.</p>
    </div> --}}
@else
    @foreach($items as $item)
        <article class="sv-record-card is-clickable"
                 onclick="window.location.href='{{ route('admin.site_visit_record.show', $item['id']) }}'">
            <div class="sv-record-card-head">
                <div>
                    <h3 class="sv-record-card-title">{{ $item['customer_name'] }}</h3>
                    <p class="sv-record-card-subtitle">
                        <i class="fas fa-phone"></i> {{ $item['mobile'] }}
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; justify-content: flex-end;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; padding:4px 10px; border-radius:999px; background:#eef2ff; color:#4338ca; font-size:11px; font-weight:700; letter-spacing:0.02em; text-transform:lowercase;">
                        {{ $item['visit_number_label'] ?? '1st visit' }}
                    </span>
                    {{-- <span style="display:inline-flex; align-items:center; justify-content:center; padding:4px 10px; border-radius:999px; background:#ecfdf5; color:#047857; font-size:11px; font-weight:700;">
                        Last visit
                    </span> --}}
                    <button type="button"
                            class="sv-revisit-btn"
                            title="Revisit this customer"
                            style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; border:1px solid #dbeafe; background:#eff6ff; color:#1d4ed8; cursor:pointer;"
                            onclick="event.stopPropagation(); window.location.href='{{ route('admin.site_visit_record.revisit', $item['id']) }}';">
                        <i class="fas fa-redo"></i>
                    </button>
                    <span class="sv-interest-badge {{ $item['interest_class'] }}">
                        {{ $item['interest'] }} Interest
                    </span>
                </div>
            </div>

            <div class="sv-record-card-meta">
                {{-- <div class="sv-meta-item">
                    <span class="sv-meta-label">Visit History</span>
                    <span class="sv-meta-value">{{ $item['total_visits'] ?? 1 }} {{ ($item['total_visits'] ?? 1) === 1 ? 'visit' : 'visits' }}</span>
                </div> --}}
                <div class="sv-meta-item">
                    <span class="sv-meta-label">Visit Date</span>
                    <span class="sv-meta-value">{{ $item['visit_date'] }}@if($item['visit_time']) · {{ $item['visit_time'] }}@endif</span>
                </div>
                <div class="sv-meta-item">
                    <span class="sv-meta-label">Location</span>
                    <span class="sv-meta-value">{{ $item['location'] ?: '—' }}</span>
                </div>
                <div class="sv-meta-item">
                    <span class="sv-meta-label">Sales Executive</span>
                    <span class="sv-meta-value">{{ $item['executive_name'] }}</span>
                </div>
                @if(!empty($showManagerColumn))
                    <div class="sv-meta-item">
                        <span class="sv-meta-label">Sales Manager</span>
                        <span class="sv-meta-value">{{ $item['manager_name'] }}</span>
                    </div>
                @endif
            </div>

            <div class="sv-record-card-details">
                <div class="sv-detail-chip">
                    <i class="fas fa-hard-hat"></i>
                    {{ $item['construction_stage'] }}
                </div>
                <div class="sv-detail-chip">
                    <i class="fas fa-boxes"></i>
                    {{ $item['qty_total'] }} Products
                </div>
                @if($item['follow_up'])
                    <div class="sv-detail-chip follow-up">
                        <i class="fas fa-bell"></i>
                        Follow-up Required
                        @if(!empty($item['follow_update'])): {{ $item['follow_update'] }}@endif
                    </div>
                @endif
            </div>

            @if($item['products'])
                <p class="sv-record-products">{{ $item['products'] }}</p>
            @endif

            @if($item['remarks'])
                <p class="sv-record-remarks">{{ $item['remarks'] }}</p>
            @endif
        </article>
    @endforeach
@endif
