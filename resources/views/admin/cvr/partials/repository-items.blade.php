@if(count($items) === 0)
    <div class="repo-empty">
        <i class="fas fa-folder-open"></i>
        <h4>No CVR Records Yet</h4>
        <p>Upload an Excel file to start building your visit repository.</p>
        <a href="{{ url('/admin/cvr') }}" class="btn-upload-link">
            <i class="fas fa-upload"></i>
            Upload CVR
        </a>
    </div>
@else
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
                 data-issues="{{ $item['issues'] }}"
                 onclick="window.location.href='{{ route('admin.cvr.details', $item['id']) }}'"
                 style="cursor: pointer;">

            <div class="cvr-card-head">
                <div>
                    <h3 class="cvr-card-title">{{ $item['dealer'] }}</h3>
                    @if($item['location'])
                        <p class="cvr-card-location">{{ $item['location'] }}</p>
                    @endif
                </div>
                <span class="sentiment-badge {{ $sentimentClass }}">
                    <i class="fas fa-user"></i>
                    {{-- {{ $item['sentiment'] }} --}}
                    {{ $item['uploaded_by'] ?? 'Unknown User' }}
                </span>
            </div>

            <div class="cvr-card-meta">
                <div class="cvr-meta-item">
                    DATE: <span>{{ $item['date'] }}</span>
                </div>
                <div class="cvr-meta-item">
                    CONTACT: <span>{{ $item['contact'] }}</span>
                </div>
                {{-- <div class="cvr-meta-item">
                    UPLOADED BY: <span>{{ $item['uploaded_by'] ?? 'Unknown User' }}</span>
                </div> --}}
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
@endif
