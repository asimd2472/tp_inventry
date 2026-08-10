@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        
                        <section class="cvr-details">

                            <div class="cvr-details-header">
                                <div class="cvr-details-back">
                                    <a href="{{ route('admin.repository') }}" class="back-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </div>
                                <div class="cvr-details-title">
                                    <h1>CVR Details</h1>
                                </div>
                                <div class="cvr-details-actions">
                                    <button type="button" id="printCvrBtn" class="action-btn" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button type="button" id="emailCvrBtn" class="action-btn" title="Share">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </div>
                            </div>
                        
                            <div class="cvr-details-body">
                        
                                {{-- Dealer Information Card --}}
                                <div class="info-card">
                                    <div class="info-row">
                                        <div class="info-col">
                                            <label>Dealer Name</label>
                                            <p>{{ $dealerName }}</p>
                                        </div>
                                        <div class="info-col">
                                            <label>Sentiment</label>
                                            <p>
                                                <span class="sentiment-badge {{ strtolower($sentiment) }}">
                                                    {{ $sentiment }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-col">
                                            <label>Distributor/RSP</label>
                                            <p>{{ $distributor ?: '—' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-col">
                                            <label>SE Name</label>
                                            <p>{{ $visitor ?: '—' }}</p>
                                        </div>
                                        <div class="info-col">
                                            <label>Contact of Host</label>
                                            <p>{{ $contact ?: '—' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-col">
                                            <label>Location</label>
                                            <p>{{ $location ?: '—' }}</p>
                                        </div>
                                        <div class="info-col">
                                            <label>Date & Time</label>
                                            <p>{{ $date }} {{ $time }}</p>
                                        </div>
                                    </div>
                                </div>
                        
                                {{-- Executive Summary & Transcript --}}
                                <div class="section-tabs">
                                    <div class="tabs-header">
                                        <button class="tab-btn active" data-tab="summary">
                                            <i class="fas fa-file-alt"></i>
                                            Summary & Actions
                                        </button>
                                        <button class="tab-btn" data-tab="transcript">
                                            <i class="fas fa-align-left"></i>
                                            Full Transcript
                                        </button>
                                    </div>
                        
                                    <div class="tabs-content">
                        
                                        {{-- Summary Tab --}}
                                        <div class="tab-pane active" id="summary">
                        
                                            <div class="section">
                                                <div class="section-head">
                                                    <h3>Executive Summary</h3>
                                                    <button class="edit-btn" id="editSummaryBtn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>
                                                </div>
                                                <div class="section-body" id="executiveSummaryText">
                                                    @if($summary)
                                                        <p>{{ $summary }}</p>
                                                    @else
                                                        <p class="text-muted">No summary available.</p>
                                                    @endif
                                                </div>
                                            </div>
                        
                                            {{-- Action Points Section --}}
                                            <div class="section">
                                                <div class="section-head">
                                                    <h3>Action Points</h3>
                                                    <button class="add-btn" id="openAddAp" title="Add Item">
                                                        <i class="fas fa-plus"></i>
                                                        Add Item
                                                    </button>
                                                </div>
                                                <div class="section-body">
                                                    @if($actionPoints->count() > 0)
                                                        <div class="action-points-list" id="actionPointsList">
                                                            @foreach($actionPoints as $ap)
                                                                @include('admin.cvr.partials.action-point-item', ['ap' => $ap])
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted" id="noApMessage">No action points recorded.</p>
                                                        <div class="action-points-list" id="actionPointsList" style="display:none"></div>
                                                    @endif
                                                </div>
                                            </div>
                        
                                            {{-- Complaints/Issues Section --}}
                                            <div class="section">
                                                <div class="section-head">
                                                    <h3>Key Issues & Complaints</h3>
                                                    <button class="add-btn" id="openAddComp" title="Add Item">
                                                        <i class="fas fa-plus"></i>
                                                        Add Issue
                                                    </button>
                                                </div>
                                                <div class="section-body">
                                                    @if($complaints->count() > 0)
                                                        <div class="complaints-list" id="complaintsList">
                                                            @foreach($complaints as $comp)
                                                                @include('admin.cvr.partials.complaint-item', ['comp' => $comp])
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted" id="noCompMessage">No complaints recorded.</p>
                                                        <div class="complaints-list" id="complaintsList" style="display:none"></div>
                                                    @endif
                                                </div>
                                            </div>
                        
                                        </div>
                        
                                        {{-- Transcript Tab --}}
                                        <div class="tab-pane" id="transcript">
                                            <div class="section">
                                                <div class="section-body">
                                                    @if($summary)
                                                        <div class="transcript-text">
                                                            {{ $summary }}
                                                        </div>
                                                    @else
                                                        <p class="text-muted">No transcript available.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                        
                                    </div>
                                </div>
                        
                                {{-- Action Button --}}
                                {{-- <div class="details-footer">
                                    <button class="btn-close-report">
                                        Close Report
                                    </button>
                                </div> --}}
                        
                            </div>
                        
                        </section>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');

            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    const csrf = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '';
    const summaryBtn = document.getElementById('editSummaryBtn');
    const summaryText = document.getElementById('executiveSummaryText');
    const openAddAp = document.getElementById('openAddAp');
    const openAddComp = document.getElementById('openAddComp');
    const printCvrBtn = document.getElementById('printCvrBtn');
    const emailCvrBtn = document.getElementById('emailCvrBtn');

    function createModal(html) {
        const wrapper = document.createElement('div');
        wrapper.className = 'simple-modal';
        wrapper.innerHTML = html;
        document.body.appendChild(wrapper);
        return wrapper;
    }

    function closeModal(modal) {
        if (modal && modal.parentNode) modal.parentNode.removeChild(modal);
    }

    function buildCvrEmailBody() {
        const dealerName = document.querySelector('.info-card .info-col p')?.textContent?.trim() || 'N/A';
        const sentiment = document.querySelector('.sentiment-badge')?.textContent?.trim() || 'Neutral';
        const distributor = Array.from(document.querySelectorAll('.info-card .info-col')).find(function (col) {
            const label = col.querySelector('label')?.textContent || '';
            return label.includes('Distributor');
        })?.querySelector('p')?.textContent?.trim() || 'N/A';
        const location = Array.from(document.querySelectorAll('.info-card .info-col')).find(function (col) {
            const label = col.querySelector('label')?.textContent || '';
            return label.includes('Location');
        })?.querySelector('p')?.textContent?.trim() || 'N/A';
        const dateText = Array.from(document.querySelectorAll('.info-card .info-col')).find(function (col) {
            const label = col.querySelector('label')?.textContent || '';
            return label.includes('Date');
        })?.querySelector('p')?.textContent?.trim() || 'N/A';

        const summaryHtml = summaryText ? summaryText.innerText.trim() : 'No summary available.';

        const actionItems = Array.from(document.querySelectorAll('.action-point-item')).map(function (item) {
            const text = item.innerText.replace(/\s+\n/g, '\n').replace(/\n+/g, '\n').trim();
            return '- ' + text;
        });

        const complaints = Array.from(document.querySelectorAll('.complaint-item')).map(function (item) {
            const text = item.innerText.replace(/\s+\n/g, '\n').replace(/\n+/g, '\n').trim();
            return '- ' + text;
        });

        return [
            'FIELD CONNECT CVR REPORT',
            '=========================',
            '',
            'Dealer Name: ' + dealerName,
            'Distributor: ' + distributor,
            'Location: ' + location,
            'Date & Time: ' + dateText,
            'Sentiment: ' + sentiment,
            '',
            'EXECUTIVE SUMMARY',
            '-----------------',
            summaryHtml || 'No summary available.',
            '',
            'ACTION POINTS',
            '-------------',
            (actionItems.length ? actionItems.join('\n') : '- No action points added.'),
            '',
            'KEY ISSUES & COMPLAINTS',
            '-----------------------',
            (complaints.length ? complaints.join('\n') : '- No issues reported.'),
            '',
            'Generated by Tata Pravesh Inventory'
        ].join('\n');
    }

    if (printCvrBtn) {
        printCvrBtn.addEventListener('click', function () {
            window.print();
        });
    }

    if (emailCvrBtn) {
        emailCvrBtn.addEventListener('click', function () {
            const html = `
                <div class="simple-modal-backdrop"></div>
                <div class="simple-modal-inner" style="max-width: 480px;">
                    <h3>Send CVR by Email</h3>
                    <label for="emailRecipientsInput" style="display:block; margin-bottom:8px; font-weight:600;">Recipient emails</label>
                    <textarea id="emailRecipientsInput" rows="4" placeholder="name@example.com, second@example.com" style="width:100%; resize:vertical;"></textarea>
                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:12px;">
                        <button type="button" id="emailCancelBtn" class="btn btn-light">Cancel</button>
                        <button type="button" id="emailSubmitBtn" class="btn btn-primary">Send</button>
                    </div>
                </div>
            `;

            const modal = createModal(html);
            const emailInput = modal.querySelector('#emailRecipientsInput');

            modal.querySelector('#emailCancelBtn').addEventListener('click', function () {
                closeModal(modal);
            });

            modal.querySelector('#emailSubmitBtn').addEventListener('click', function () {
                const recipients = (emailInput.value || '').split(',').map(function (item) {
                    return item.trim();
                }).filter(Boolean).join(',');

                if (!recipients) {
                    alert('Please enter recipient email addresses.');
                    return;
                }

                const dealerName = document.querySelector('.info-card .info-col p')?.textContent?.trim() || 'Unknown';
                const subject = 'CVR Report: ' + dealerName;
                const body = buildCvrEmailBody();
                const mailtoUrl = 'mailto:' + encodeURIComponent(recipients) + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);

                window.location.href = mailtoUrl;
                closeModal(modal);
            });
        });
    }

    if (summaryBtn) {
        summaryBtn.addEventListener('click', function () {
            const currentSummary = (summaryText ? summaryText.innerText : '').trim();
            const html = `
                <div class="simple-modal-backdrop"></div>
                <div class="simple-modal-inner">
                    <h3>Update Executive Summary</h3>
                    <textarea id="summaryEditor" rows="8" style="width:100%; resize: vertical;">${currentSummary.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</textarea>
                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:12px;">
                        <button id="summaryCancel" class="btn btn-light">Cancel</button>
                        <button id="summarySubmit" class="btn btn-primary">Save Summary</button>
                    </div>
                </div>
            `;

            const modal = createModal(html);
            modal.querySelector('#summaryCancel').addEventListener('click', function () {
                closeModal(modal);
            });

            modal.querySelector('#summarySubmit').addEventListener('click', function () {
                const value = modal.querySelector('#summaryEditor').value.trim();
                fetch('{{ route('admin.cvr.updateSummary', $cvr->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ summary: value })
                }).then(r => r.json()).then(data => {
                    if (data.success) {
                        if (summaryText) {
                            summaryText.innerHTML = data.summary ? '<p>' + data.summary.replace(/\n/g, '<br>') + '</p>' : '<p class="text-muted">No summary available.</p>';
                        }
                        closeModal(modal);
                    } else {
                        alert('Could not update summary');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Network error');
                });
            });
        });
    }

    if (openAddAp) {
        openAddAp.addEventListener('click', function () {
            const html = `
                <div class="simple-modal-backdrop"></div>
                <div class="simple-modal-inner">
                    <h3>Add Action Item</h3>
                    <input type="text" id="ap_task" placeholder="Enter new action item..." />
                    <input type="date" id="ap_deadline" />
                    <input type="text" id="ap_owner" placeholder="Owner (optional)" />
                    <select id="ap_priority">
                        <option value="High">High</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="Low">Low</option>
                    </select>
                    <button id="ap_submit" class="btn btn-primary">Add Action Point</button>
                    <button id="ap_cancel" class="btn btn-link">Cancel</button>
                </div>
            `;

            const modal = createModal(html);

            modal.querySelector('#ap_cancel').addEventListener('click', function () {
                closeModal(modal);
            });

            modal.querySelector('#ap_submit').addEventListener('click', function () {
                const task = modal.querySelector('#ap_task').value.trim();
                if (!task) {
                    alert('Please enter a task');
                    return;
                }

                const payload = {
                    task: task,
                    owner: modal.querySelector('#ap_owner').value.trim(),
                    deadline: modal.querySelector('#ap_deadline').value || null,
                    priority: modal.querySelector('#ap_priority').value || 'Medium'
                };

                fetch('{{ route('admin.cvr.addActionPoint', $cvr->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(data => {
                    if (data.success) {
                        const list = document.getElementById('actionPointsList');
                        const noMsg = document.getElementById('noApMessage');
                        if (noMsg) noMsg.style.display = 'none';
                        list.style.display = 'flex';
                        const temp = document.createElement('div');
                        temp.innerHTML = data.html;
                        const newEl = temp.firstElementChild;
                        if (newEl) {
                            newEl.classList.add('new-item');
                            list.insertBefore(newEl, list.firstChild);
                        }
                        closeModal(modal);
                    } else {
                        alert('Could not add action point');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Network error');
                });
            });
        });
    }

    if (openAddComp) {
        openAddComp.addEventListener('click', function () {
            const html = `
                <div class="simple-modal-backdrop"></div>
                <div class="simple-modal-inner">
                    <h3>Add Complaint</h3>
                    <input type="text" id="comp_category" placeholder="Category" />
                    <textarea id="comp_description" placeholder="Description"></textarea>
                    <div>
                        <label>Severity</label>
                        <select id="comp_severity">
                            <option value="Critical">Critical</option>
                            <option value="Major" selected>Major</option>
                            <option value="Minor">Minor</option>
                        </select>
                    </div>
                    <button id="comp_submit" class="btn btn-primary">Add Complaint</button>
                    <button id="comp_cancel" class="btn btn-link">Cancel</button>
                </div>
            `;

            const modal = createModal(html);

            modal.querySelector('#comp_cancel').addEventListener('click', function () {
                closeModal(modal);
            });

            modal.querySelector('#comp_submit').addEventListener('click', function () {
                const description = modal.querySelector('#comp_description').value.trim();
                if (!description) {
                    alert('Please enter a description');
                    return;
                }

                const payload = {
                    category: modal.querySelector('#comp_category').value.trim(),
                    description: description,
                    severity: modal.querySelector('#comp_severity').value || 'Minor'
                };

                fetch('{{ route('admin.cvr.addComplaint', $cvr->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(data => {
                    if (data.success) {
                        const list = document.getElementById('complaintsList');
                        const noMsg = document.getElementById('noCompMessage');
                        if (noMsg) noMsg.style.display = 'none';
                        list.style.display = 'flex';
                        const temp = document.createElement('div');
                        temp.innerHTML = data.html;
                        const newEl = temp.firstElementChild;
                        if (newEl) {
                            newEl.classList.add('new-item');
                            list.insertBefore(newEl, list.firstChild);
                        }
                        closeModal(modal);
                    } else {
                        alert('Could not add complaint');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Network error');
                });
            });
        });
    }

    document.querySelectorAll('.ap-status-select').forEach(function (select) {
        select.addEventListener('change', function () {
            const url = this.dataset.url;
            const status = this.value;
            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status: status })
            }).then(r => r.json()).then(data => {
                if (!data.success) {
                    alert('Could not update status');
                }
            }).catch(function () {
                alert('Network error');
            });
        });
    });

    document.querySelectorAll('.delete-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const url = this.dataset.deleteUrl;
            if (!url) return;

            if (!confirm('Are you sure you want to delete this item?')) {
                return;
            }

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    const item = this.closest('.action-point-item, .complaint-item');
                    if (item) item.remove();
                    const list = item && item.classList.contains('action-point-item') ? document.getElementById('actionPointsList') : document.getElementById('complaintsList');
                    if (list && list.querySelectorAll('.action-point-item, .complaint-item').length === 0) {
                        list.style.display = 'none';
                        const noMessage = list.id === 'actionPointsList' ? document.getElementById('noApMessage') : document.getElementById('noCompMessage');
                        if (noMessage) noMessage.style.display = 'block';
                    }
                } else {
                    alert('Could not delete item');
                }
            }).catch(function () {
                alert('Network error');
            });
        });
    });
});
</script>
@endpush





