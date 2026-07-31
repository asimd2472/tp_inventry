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

                @foreach($items as $item)
                    @php
                        $sentimentClass = match(strtolower($item['sentiment'])) {
                            'positive' => 'positive',
                            'negative' => 'negative',
                            default => 'neutral',
                        };
                        $sentimentIcon = match(strtolower($item['sentiment'])) {
                            'positive' => 'fa-smile',
                            'negative' => 'fa-frown',
                            default => 'fa-chart-line',
                        };
                    @endphp

                    <article class="cvr-card"
                             data-search="{{ $item['search_text'] }}"
                             data-pending="{{ $item['pending'] }}"
                             data-issues="{{ $item['issues'] }}">

                        <div class="cvr-card-head">
                            <div>
                                <h3 class="cvr-card-title">{{ $item['dealer'] }}</h3>
                                @if($item['location'])
                                    <p class="cvr-card-location">{{ $item['location'] }}</p>
                                @endif
                            </div>
                            <span class="sentiment-badge {{ $sentimentClass }}">
                                <i class="fas {{ $sentimentIcon }}"></i>
                                {{ $item['sentiment'] }}
                            </span>
                        </div>

                        <div class="cvr-card-meta">
                            <div class="cvr-meta-item">
                                DATE: <span>{{ $item['date'] }}</span>
                            </div>
                            <div class="cvr-meta-item">
                                CONTACT: <span>{{ $item['contact'] }}</span>
                            </div>
                        </div>

                        @if($item['summary'])
                            <p class="cvr-card-summary">{{ $item['summary'] }}</p>
                        @endif

                        <div class="cvr-card-footer">
                            <span class="cvr-stat pending">
                                <i class="fas fa-clock"></i>
                                {{ $item['pending'] }} Action{{ $item['pending'] !== 1 ? 's' : '' }} Pending
                            </span>
                            <span class="cvr-stat completed">
                                <i class="fas fa-check-circle"></i>
                                {{ $item['completed'] }} Completed
                            </span>
                            <span class="cvr-stat issues">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $item['issues'] }} Issue{{ $item['issues'] !== 1 ? 's' : '' }}
                            </span>
                        </div>

                    </article>
                @endforeach

            </div>

            <div class="repo-no-results" id="noResults">
                <i class="fas fa-search"></i>
                <p>No matches found for your search.</p>
            </div>

        @endif

    </div>

</section>

@endsection

@push('scripts')
<script>
$(function () {
    var $input = $('#cvrSearchInput');
    var $cards = $('.cvr-card');
    var $matchCount = $('#matchCount');
    var $noResults = $('#noResults');
    var $list = $('#cvrList');

    if (!$input.length || !$cards.length) {
        return;
    }

    function filterCards() {
        var query = $input.val().toLowerCase().trim();
        var visible = 0;
        var visiblePending = 0;
        var visibleIssues = 0;

        $cards.each(function () {
            var $card = $(this);
            var searchText = $card.data('search') || '';
            var matches = query === '' || searchText.indexOf(query) !== -1;

            $card.toggle(matches);

            if (matches) {
                visible++;
                visiblePending += parseInt($card.data('pending'), 10) || 0;
                visibleIssues += parseInt($card.data('issues'), 10) || 0;
            }
        });

        $matchCount.text(visible);

        if (visible === 0) {
            $list.hide();
            $noResults.show();
        } else {
            $list.show();
            $noResults.hide();
        }
    }

    $input.on('input', filterCards);
});
</script>
@endpush
