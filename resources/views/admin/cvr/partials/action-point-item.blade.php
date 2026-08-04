<div class="action-point-item" data-id="{{ $ap->id }}">
    <div class="ap-header">
        <div class="ap-title">
            <h4>{{ $ap->task ?? 'Untitled' }}</h4>
        </div>
        <div class="ap-actions">
            <button class="icon-btn delete-btn" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="ap-meta">
        <div class="ap-meta-item">
            <strong>Owner:</strong> {{ $ap->owner ?? 'Unassigned' }}
        </div>
        <div class="ap-meta-item">
            {{-- <strong>Follow-up Date:</strong> {{ $ap->deadline ? \Carbon\Carbon::parse($ap->deadline)->format('d M, Y') : '—' }} --}}
            <strong>Follow-up Date:</strong> {{ $ap->deadline }}
        </div>
        <div class="ap-meta-item">
            <strong>Priority:</strong>
            <span class="priority-badge {{ strtolower($ap->priority ?? 'medium') }}">
                {{ $ap->priority ?? 'Medium' }}
            </span>
        </div>
    </div>
</div>
