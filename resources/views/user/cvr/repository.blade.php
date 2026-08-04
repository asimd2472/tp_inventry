@extends('layouts.app')

@section('content')

<section class="cvr-repository">

    <div class="repo-header">
        <div class="repo-header-inner">
            <a href="{{ url('/user/cvr') }}" class="repo-back" title="Back">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h1 class="repo-title">CVR Repository</h1>
            <a href="{{ url('/user/cvr') }}" class="repo-header-action" title="Upload CVR">
                <i class="fas fa-upload"></i>
            </a>
        </div>
    </div>

    <div class="repo-body">

        {{-- Summary Stats --}}
        <div class="repo-stats">
            <div class="stat-card">
                <div class="stat-value blue" id="statTotalVisits">{{ $totalVisits }}</div>
                <div class="stat-label">Total Visits</div>
            </div>
            <div class="stat-card">
                <div class="stat-value orange" id="statOpenActions">{{ $openActions }}</div>
                <div class="stat-label">Open Actions</div>
            </div>
            <div class="stat-card">
                <div class="stat-value red" id="statCriticalIssues">{{ $criticalIssues }}</div>
                <div class="stat-label">Crit. Issues</div>
            </div>
        </div>

        {{-- Search --}}
        <div class="repo-search-wrap">
            <div class="repo-search">
                <i class="fas fa-search"></i>
                <input type="text"
                       id="cvrSearchInput"
                       placeholder="Search dealers, people, actions..."
                       autocomplete="off">
            </div>
            <div class="repo-match-count">
                <span id="matchCount">{{ $totalVisits }}</span> Matches Found
            </div>
        </div>

        @if(count($items) === 0)
            <div class="repo-empty">
                <i class="fas fa-folder-open"></i>
                <h4>No CVR Records Yet</h4>
                <p>Upload an Excel file to start building your visit repository.</p>
                <a href="{{ url('/user/cvr') }}" class="btn-upload-link">
                    <i class="fas fa-upload"></i>
                    Upload CVR
                </a>
            </div>
        @else
            <div class="repo-list has-items" id="cvrList">
                @include('user.cvr.partials.repository-items', ['items' => $items])
            </div>

            <div class="repo-no-results" id="noResults" style="display:none;">
                <i class="fas fa-search"></i>
                <p>No matches found for your search.</p>
            </div>
        @endif

        <div class="repo-pagination" style="margin-top: 15px;" id="paginationContainer"></div>

    </div>

</section>

@endsection

@push('scripts')
<script type="module">
(function () {
    var $input = $('#cvrSearchInput');
    var $matchCount = $('#matchCount');
    var $noResults = $('#noResults');
    var $list = $('#cvrList');
    var $pagination = $('#paginationContainer');
    var $statTotal = $('#statTotalVisits');
    var $statOpen = $('#statOpenActions');
    var $statCritical = $('#statCriticalIssues');
    var debounceTimer = null;
    var baseUrl = '{{ route('user.repository.data') }}';

    if (!$input.length) {
        return;
    }

    function updateStats(data) {
        if (data.totalVisits !== undefined) {
            $statTotal.text(data.totalVisits);
        }
        if (data.openActions !== undefined) {
            $statOpen.text(data.openActions);
        }
        if (data.criticalIssues !== undefined) {
            $statCritical.text(data.criticalIssues);
        }
        if (data.pagination && data.pagination.total !== undefined) {
            $matchCount.text(data.pagination.total);
        }
    }

    function renderPagination(data) {
        if (!$pagination.length) {
            return;
        }

        $pagination.empty();

        if (!data.pagination || data.pagination.last_page <= 1) {
            return;
        }

        var currentPage = data.pagination.current_page || 1;
        var lastPage = data.pagination.last_page || 1;
        var prevPage = data.pagination.prev_page;
        var nextPage = data.pagination.next_page;

        var buildButton = function (page, label, disabled, active) {
            var btn = $('<button>', {
                type: 'button',
                class: 'btn btn-sm me-2 ' + (active ? 'btn-primary' : 'btn-outline-secondary'),
                text: label,
                disabled: disabled
            });

            btn.on('click', function () {
                loadPage(page);
            });

            return btn;
        };

        if (prevPage) {
            $pagination.append(buildButton(prevPage, 'Previous', false, false));
        }

        for (var page = 1; page <= lastPage; page++) {
            $pagination.append(buildButton(page, page, false, page === currentPage));
        }

        if (nextPage) {
            $pagination.append(buildButton(nextPage, 'Next', false, false));
        }
    }

    function loadPage(page, search) {
        var query = search === undefined ? $input.val().trim() : search;
        var params = new URLSearchParams({
            page: page || 1,
            search: query
        });

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
            });
    }

    $input.on('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            loadPage(1, $input.val().trim());
        }, 250);
    });

    loadPage(1, '');
})();
</script>
@endpush
