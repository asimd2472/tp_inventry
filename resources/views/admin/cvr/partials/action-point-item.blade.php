<div class="action-point-item" data-id="{{ $ap->id }}">
    <div class="ap-header">
        <div class="ap-title">
            <h4>{{ $ap->task ?? 'Untitled' }}</h4>
        </div>
        <div class="ap-actions">
            <div class="ap-status-select-wrap">
                <select class="ap-status-select" data-id="{{ $ap->id }}" data-url="{{ route('admin.cvr.updateActionPointStatus', $ap->id) }}">
                    @foreach(['Pending','In Progress','Completed','Closed'] as $statusOption)
                        <option value="{{ $statusOption }}" {{ ($ap->status ?? 'Pending') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                    @endforeach
                </select>
            </div>
            <button class="icon-btn delete-btn" data-delete-url="{{ route('admin.cvr.deleteActionPoint', $ap->id) }}" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="ap-meta">
        <div class="ap-meta-item">
            <strong>Status:</strong>
            <span class="status-badge {{ strtolower(str_replace(' ', '-', ($ap->status ?? 'pending'))) }}">
                {{ $ap->status ?? 'Pending' }}
            </span>
        </div>
        <div class="ap-meta-item">
            <strong>Owner:</strong> {{ $ap->owner ?? 'Unassigned' }}
        </div>
        <div class="ap-meta-item">
            <strong>Follow-up Date:</strong> {{ $ap->deadline ?: '—' }}
        </div>
        <div class="ap-meta-item">
            <strong>Priority:</strong>
            <span class="priority-badge {{ strtolower($ap->priority ?? 'medium') }}">
                {{ $ap->priority ?? 'Medium' }}
            </span>
        </div>
    </div>
</div>
