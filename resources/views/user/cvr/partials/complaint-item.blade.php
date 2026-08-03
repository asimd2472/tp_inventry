<div class="complaint-item" data-id="{{ $comp->id }}">
    <div class="comp-header">
        <div class="comp-title">
            <h4>{{ $comp->category ?? 'Issue' }}</h4>
        </div>
        <div class="comp-actions">
            <button class="icon-btn delete-btn" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="comp-body">
        {{ $comp->description ?? 'No description' }}
    </div>
    <div class="comp-footer">
        <span class="severity-badge {{ strtolower($comp->severity ?? 'minor') }}">
            {{ $comp->severity ?? 'Minor' }}
        </span>
    </div>
</div>
