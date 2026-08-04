<div class="action-point-item" data-id="{{ $ap->id }}">
    <div class="ap-header">
        <div class="ap-title">
            <h4>{{ $ap->task ?? 'Untitled' }}</h4>
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
        @if(!empty($ap->status_change_by))
            @php
                $updater = \App\Models\User::find($ap->status_change_by);
            @endphp
            <div class="ap-meta-item">
                <strong>Updated By:</strong> {{ $updater?->name ?? 'Admin' }}
            </div>
        @endif
    </div>
</div>
