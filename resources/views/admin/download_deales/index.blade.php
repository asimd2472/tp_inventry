@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Download Dealer</div>
                        <div class="user-body">

                            <div class="row justify-content-center">
                                <div class="col-xl-8 col-md-10 col-12">
                                    <div class="dealer-email-card">
                                        <!-- <h4 class="dealer-email-title">Send dealer list</h4>
                                        <p class="dealer-email-subtitle">Enter an email address to receive the latest dealer PDF.</p> -->

                                        <form id="dealerEmailForm" method="POST" action="{{ url('admin/send_dealers') }}" novalidate>
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="dealer_email">Email Address</label>
                                                <input
                                                    type="email"
                                                    class="form-control dealer-email-input"
                                                    id="dealer_email"
                                                    name="email"
                                                    placeholder="Enter email address"
                                                    required
                                                >
                                                <div class="invalid-feedback d-block" id="dealerEmailError"></div>
                                            </div>

                                            <button type="submit" class="btn btn-primary dealer-email-btn" id="dealerEmailSubmit">
                                                Submit
                                            </button>
                                        </form>

                                        <div id="dealerEmailAlert" class="alert mt-3 d-none" role="alert"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')






<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('dealerEmailForm');
        const emailInput = document.getElementById('dealer_email');
        const errorBox = document.getElementById('dealerEmailError');
        const alertBox = document.getElementById('dealerEmailAlert');
        const submitBtn = document.getElementById('dealerEmailSubmit');
        const submitUrl = '{{ url('admin/send_dealers') }}';

        const clearMessage = () => {
            alertBox.classList.add('d-none');
            alertBox.classList.remove('alert-success', 'alert-danger');
            alertBox.textContent = '';
            errorBox.textContent = '';
            emailInput.classList.remove('is-invalid');
        };

        const setError = (message) => {
            emailInput.classList.add('is-invalid');
            errorBox.textContent = message;
        };

        const setAlert = (type, message) => {
            alertBox.classList.remove('d-none');
            alertBox.classList.add(type === 'success' ? 'alert-success' : 'alert-danger');
            alertBox.textContent = message;
        };

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            clearMessage();

            const email = (emailInput.value || '').trim();

            if (!email) {
                setError('Please enter an email address.');
                emailInput.focus();
                return;
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                setError('Please enter a valid email address.');
                emailInput.focus();
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

            fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
                .then(async (response) => {
                    const data = await response.json().catch(() => ({}));

                    if (!response.ok) {
                        throw new Error(data.msg || data.message || 'Unable to send dealer email.');
                    }

                    return data;
                })
                .then((data) => {
                    setAlert('success', data.msg || 'Dealer email sent successfully.');
                    form.reset();
                })
                .catch((error) => {
                    setAlert('error', error.message || 'Something went wrong. Please try again.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit';
                });
        });
    });
</script>
<style>
    .dealer-email-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        padding: 28px 24px;
    }

    .dealer-email-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .dealer-email-subtitle {
        color: #6b7280;
        margin-bottom: 22px;
    }

    .dealer-email-input {
        height: 46px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        padding: 0.75rem 0.9rem;
    }

    .dealer-email-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.12);
    }

    .dealer-email-btn {
        min-width: 140px;
        border-radius: 10px;
        font-weight: 600;
        padding: 0.7rem 1.2rem;
    }

    .dealer-email-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .invalid-feedback {
        font-size: 0.8rem;
        color: #dc2626;
        margin-top: 5px;
    }
</style>
@endpush
