@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <section class="sv-record-dashboard">

                            <div class="sv-record-header">
                                <div class="sv-record-header-inner">
                                    <a href="{{ url('/admin/site-visit') }}" class="sv-record-back" title="Back">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <div class="sv-record-header-text">
                                        <span class="sv-record-eyebrow">Site Visit</span>
                                        <h1 class="sv-record-title">{{ $dashboardTitle ?? 'Site Visit Dashboard' }}</h1>
                                    </div>
                                    <a href="{{ url('/admin/site-visit') }}" class="sv-record-header-action" title="New Site Visit">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="sv-record-body">

                                <div class="sv-record-stats">
                                    <div class="sv-stat-card">
                                        <div class="sv-stat-icon blue"><i class="fas fa-map-marked-alt"></i></div>
                                        <div class="sv-stat-value blue" id="statTotalVisits">{{ $totalVisits ?? 0 }}</div>
                                        <div class="sv-stat-label">Total Site Visits</div>
                                    </div>
                                    <div class="sv-stat-card">
                                        <div class="sv-stat-icon green"><i class="fas fa-users"></i></div>
                                        <div class="sv-stat-value green" id="statUniqueCustomers">{{ $uniqueCustomers ?? 0 }}</div>
                                        <div class="sv-stat-label">Unique Customers Visited</div>
                                    </div>
                                    <div class="sv-stat-card">
                                        <div class="sv-stat-icon orange"><i class="fas fa-star"></i></div>
                                        <div class="sv-stat-value orange" id="statHighPotential">{{ $highPotentialCustomers ?? 0 }}</div>
                                        <div class="sv-stat-label">High-Potential Customers</div>
                                    </div>
                                    <div class="sv-stat-card">
                                        <div class="sv-stat-icon purple"><i class="fas fa-boxes"></i></div>
                                        <div class="sv-stat-value purple" id="statEstimatedProducts">{{ $estimatedProducts ?? 0 }}</div>
                                        <div class="sv-stat-label">Estimated Total Products Required</div>
                                    </div>
                                </div>

                                @php
                                    $teamFilter = $teamFilter ?? ['show' => false, 'type' => null, 'options' => [], 'value' => '', 'label' => ''];
                                @endphp

                                <div class="sv-record-toolbar">
                                    <div class="sv-record-toolbar-row">
                                        <div class="sv-record-search-row">
                                            <div class="sv-record-search">
                                                <i class="fas fa-search"></i>
                                                <input type="text"
                                                       id="siteVisitSearchInput"
                                                       placeholder="Search customer, location, executive..."
                                                       autocomplete="off"
                                                       value="{{ $search ?? '' }}">
                                            </div>

                                            @if(!empty($teamFilter['show']))
                                                <div class="sv-record-filter">
                                                    <label for="teamFilterSelect">{{ $teamFilter['label'] ?? 'Filter' }}</label>
                                                    <select id="teamFilterSelect" data-filter-type="{{ $teamFilter['type'] ?? '' }}">
                                                        <option value="">All {{ $teamFilter['label'] ?? 'Users' }}</option>
                                                        @foreach(($teamFilter['options'] ?? []) as $option)
                                                            <option value="{{ $option['id'] }}" {{ ($teamFilter['value'] ?? '') == $option['id'] ? 'selected' : '' }}>
                                                                {{ $option['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="sv-record-export-panel">
                                            <div class="sv-record-export-form">
                                                <div class="sv-record-export-field">
                                                    <label for="exportDateFrom">From date</label>
                                                    <input type="date" id="exportDateFrom" value="{{ request('date_from') ?? '' }}">
                                                </div>
                                                <div class="sv-record-export-field">
                                                    <label for="exportDateTo">To date</label>
                                                    <input type="date" id="exportDateTo" value="{{ request('date_to') ?? '' }}">
                                                </div>

                                                @if(Auth::user() && Auth::user()->hasRole('Super User'))
                                                    <div class="sv-record-export-field sv-record-export-field--wide">
                                                        <label for="exportSalesManager">Sales Manager</label>
                                                        <select class="select2" id="exportSalesManager" multiple>
                                                            @foreach(($exportManagerOptions ?? []) as $option)
                                                                <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @elseif(Auth::user() && Auth::user()->hasRole('Sales Manager'))
                                                    <div class="sv-record-export-field sv-record-export-field--wide">
                                                        <label for="exportSalesExecutive">Sales Executive</label>
                                                        <select class="select2" id="exportSalesExecutive" multiple>
                                                            @foreach(($exportExecutiveOptions ?? []) as $option)
                                                                <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <div class="sv-record-export-field sv-record-export-field--compact">
                                                    <label for="exportMode">Mode</label>
                                                    <select id="exportMode">
                                                        <option value="consolidated">Consolidated</option>
                                                        <option value="individual">Individual</option>
                                                    </select>
                                                </div>

                                                <div class="sv-record-export-actions">
                                                    <div class="sv-record-export-actions-wrap">
                                                        <button type="button" class="sv-record-export-btn is-secondary" id="exportCsvBtn">
                                                            <i class="fas fa-file-csv"></i> CSV
                                                        </button>
                                                        <button type="button" class="sv-record-export-btn is-primary" id="exportExcelBtn">
                                                            <i class="fas fa-file-excel"></i> Excel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sv-record-match-count">
                                        <span id="matchCount">{{ $totalVisits ?? 0 }}</span> visit records found
                                    </div>
                                </div>

                                <div class="sv-record-section-head">
                                    <h2>Listing</h2>
                                    <p>Review submitted site visit reports with customer, location, and product details.</p>
                                </div>

                                <div class="sv-record-list has-items" id="siteVisitList">
                                    @include('super_admin.sitevisit.partials.record-items', [
                                        'items' => $items ?? [],
                                        'showManagerColumn' => $showManagerColumn ?? false,
                                    ])
                                </div>

                                <div class="sv-record-no-results" id="noResults" style="display:none;">
                                    <i class="fas fa-search"></i>
                                    <p>No site visits match your search.</p>
                                </div>

                                <div class="sv-record-pagination" id="paginationContainer"></div>
                            </div>

                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- @push('styles')
<style>
    @media (max-width: 768px) {
        .sv-record-dashboard .sv-record-toolbar-row {
            height: auto !important;
            min-height: 0 !important;
            gap: 10px !important;
        }

        .sv-record-dashboard .sv-record-search-row {
            flex: 0 0 auto !important;
            height: auto !important;
            min-height: 0 !important;
        }

        .sv-record-dashboard .sv-record-export-panel {
            height: auto !important;
            min-height: 0 !important;
            margin-top: 0 !important;
        }
    }

    @media (max-width: 480px) {
        .sv-record-dashboard .sv-record-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
</style>
@endpush --}}

@push('scripts')
<script type="module">
(function () {
    var $input = $('#siteVisitSearchInput');
    var $matchCount = $('#matchCount');
    var $noResults = $('#noResults');
    var $list = $('#siteVisitList');
    var $pagination = $('#paginationContainer');
    var $statTotal = $('#statTotalVisits');
    var $statUnique = $('#statUniqueCustomers');
    var $statHighPotential = $('#statHighPotential');
    var $statProducts = $('#statEstimatedProducts');
    var $teamSelect = $('#teamFilterSelect');
    var $exportCsvBtn = $('#exportCsvBtn');
    var $exportExcelBtn = $('#exportExcelBtn');
    var $exportDateFrom = $('#exportDateFrom');
    var $exportDateTo = $('#exportDateTo');
    var $exportMode = $('#exportMode');
    var $exportSalesManager = $('#exportSalesManager');
    var $exportSalesExecutive = $('#exportSalesExecutive');
    var debounceTimer = null;
    var baseUrl = '{{ route('admin.site_visit_record.data') }}';
    var exportBaseUrl = '{{ route('admin.site_visit_record.export') }}';
    var teamFilterType = @json($teamFilter['type'] ?? '');
    var selectedTeamUser = @json($teamFilter['value'] ?? '');

    if (!$input.length) {
        return;
    }

    function updateStats(data) {
        if (data.totalVisits !== undefined) {
            $statTotal.text(data.totalVisits);
        }
        if (data.uniqueCustomers !== undefined) {
            $statUnique.text(data.uniqueCustomers);
        }
        if (data.highPotentialCustomers !== undefined) {
            $statHighPotential.text(data.highPotentialCustomers);
        }
        if (data.estimatedProducts !== undefined) {
            $statProducts.text(data.estimatedProducts);
        }
        if (data.pagination && data.pagination.total !== undefined) {
            $matchCount.text(data.pagination.total);
        }
    }

    function appendTeamFilterParams(params) {
        if (!teamFilterType || !selectedTeamUser) {
            return;
        }

        if (teamFilterType === 'sales_manager') {
            params.set('sales_manager', selectedTeamUser);
        } else if (teamFilterType === 'sales_executive') {
            params.set('sales_executive', selectedTeamUser);
        }
    }

    function buildExportParams(type) {
        var params = new URLSearchParams();
        params.set('type', type);
        params.set('date_from', $exportDateFrom.val() || '');
        params.set('date_to', $exportDateTo.val() || '');
        params.set('export_mode', $exportMode.val() || 'consolidated');

        if ($exportSalesManager && $exportSalesManager.length && $exportSalesManager.val()) {
            $exportSalesManager.val().forEach(function (value) {
                params.append('sales_manager[]', value);
            });
        }

        if ($exportSalesExecutive && $exportSalesExecutive.length && $exportSalesExecutive.val()) {
            $exportSalesExecutive.val().forEach(function (value) {
                params.append('sales_executive[]', value);
            });
        }

        if (!teamFilterType || !selectedTeamUser) {
            return params;
        }

        if (teamFilterType === 'sales_manager') {
            params.append('sales_manager[]', selectedTeamUser);
        } else if (teamFilterType === 'sales_executive') {
            params.append('sales_executive[]', selectedTeamUser);
        }

        return params;
    }

    function triggerExport(type) {
        var url = exportBaseUrl + '?' + buildExportParams(type).toString();
        window.location.href = url;
    }

    function renderPagination(data) {
        $pagination.empty();

        if (!data.pagination || data.pagination.last_page <= 1) {
            return;
        }

        var currentPage = data.pagination.current_page || 1;
        var lastPage = data.pagination.last_page || 1;
        var prevPage = data.pagination.prev_page;
        var nextPage = data.pagination.next_page;

        var buildButton = function (page, label, active) {
            var btn = $('<button>', {
                type: 'button',
                class: 'btn btn-sm me-2 ' + (active ? 'btn-primary' : 'btn-outline-secondary'),
                text: label
            });

            btn.on('click', function () {
                loadPage(page);
            });

            return btn;
        };

        if (prevPage) {
            $pagination.append(buildButton(prevPage, 'Previous', false));
        }

        for (var page = 1; page <= lastPage; page++) {
            $pagination.append(buildButton(page, page, page === currentPage));
        }

        if (nextPage) {
            $pagination.append(buildButton(nextPage, 'Next', false));
        }
    }

    function loadPage(page, search) {
        var query = search === undefined ? $input.val().trim() : search;
        var params = new URLSearchParams({
            page: page || 1,
            search: query
        });

        appendTeamFilterParams(params);
        $('.loader-wrap').show();

        fetch(baseUrl + '?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                updateStats(data);

                if (data.items && data.items.length > 0) {
                    $list.html(data.itemsHtml);
                    $list.show();
                    $noResults.hide();
                } else {
                    $list.hide();
                    $noResults.show();
                }

                renderPagination(data);
            })
            .finally(function () {
                $('.loader-wrap').hide();
            });
    }

    $input.on('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            loadPage(1, $input.val().trim());
        }, 250);
    });

    $teamSelect.on('change', function () {
        selectedTeamUser = $(this).val() || '';
        loadPage(1, $input.val().trim());
    });

    $exportCsvBtn.on('click', function () {
        triggerExport('csv');
    });

    $exportExcelBtn.on('click', function () {
        triggerExport('excel');
    });

    if ($teamSelect.length && selectedTeamUser) {
        $teamSelect.val(selectedTeamUser);
    }

    loadPage(1, $input.val().trim());
})();
</script>
@endpush
