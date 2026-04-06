@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Users</div>
                        
                        <div class="user-body">
                            <a href="#userModal" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#userModal" id="createUserBtn">Create</a>
                            <div class="row justify-content-center">
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="table-responsive mt-1">
                                        <table class="table table-bordered table-hover companyTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">User Type</th>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $item)
                                                <tr>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->email}}</td>
                                                    <td>{{$item->user_access==1 ? 'User' : 'Both'}}</td>
                                                    <td>
                                                        <a href="#userModal" class="btn btn-sm btn-info editUserBtn" data-id="{{$item->id}}" data-name="{{$item->name}}" data-email="{{$item->email}}" data-user_access="{{$item->user_access}}" data-bs-toggle="modal" data-bs-target="#userModal">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                        <tbody>
                                        </tbody>
                                        </table>
                                    </div>
                                    <!-- User Modal -->
                                    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="userModalLabel">Create User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="userForm">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="userName" class="form-label">Name</label>
                                                            <input type="text" class="form-control" id="userName" name="name" required>
                                                            <div class="invalid-feedback">Name is required.</div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="userEmail" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="userEmail" name="email" required>
                                                            <div class="invalid-feedback">Valid email is required.</div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="userType" class="form-label">User Type</label>
                                                            <select class="form-select" id="userType" name="user_access" required>
                                                                <option value="">Select Type</option>
                                                                <option value="1">User</option>
                                                                <option value="2">Both</option>
                                                            </select>
                                                            <div class="invalid-feedback">User type is required.</div>
                                                        </div>
                                                        <input type="hidden" id="userId" name="id">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" id="saveUserBtn">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
    var userModal = document.getElementById('userModal');
    var userForm = document.getElementById('userForm');
    var userModalLabel = document.getElementById('userModalLabel');
    var saveUserBtn = document.getElementById('saveUserBtn');
    var createUserBtn = document.getElementById('createUserBtn');
    var userIdInput = document.getElementById('userId');
    var userNameInput = document.getElementById('userName');
    var userEmailInput = document.getElementById('userEmail');
    var userTypeInput = document.getElementById('userType');

    // Reset modal on open for create
    createUserBtn.addEventListener('click', function () {
        userForm.reset();
        userModalLabel.textContent = 'Create User';
        userIdInput.value = '';
        userNameInput.classList.remove('is-invalid');
        userEmailInput.classList.remove('is-invalid');
        userTypeInput.classList.remove('is-invalid');
    });

    // Fill modal for edit
    document.querySelectorAll('.editUserBtn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            userModalLabel.textContent = 'Edit User';
            userIdInput.value = this.dataset.id;
            userNameInput.value = this.dataset.name;
            userEmailInput.value = this.dataset.email;
            userTypeInput.value = this.dataset.user_access;
            userNameInput.classList.remove('is-invalid');
            userEmailInput.classList.remove('is-invalid');
            userTypeInput.classList.remove('is-invalid');
        });
    });

    // Form validation and AJAX submit
    userForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var valid = true;
        if (!userNameInput.value.trim()) {
            userNameInput.classList.add('is-invalid');
            valid = false;
        } else {
            userNameInput.classList.remove('is-invalid');
        }
        if (!userEmailInput.value.trim() || !/^\S+@\S+\.\S+$/.test(userEmailInput.value)) {
            userEmailInput.classList.add('is-invalid');
            valid = false;
        } else {
            userEmailInput.classList.remove('is-invalid');
        }
        if (!userTypeInput.value) {
            userTypeInput.classList.add('is-invalid');
            valid = false;
        } else {
            userTypeInput.classList.remove('is-invalid');
        }
        if (!valid) return;

        saveUserBtn.disabled = true;
        saveUserBtn.textContent = 'Saving...';

        var formData = new FormData(userForm);
        fetch('/admin/users/store-or-update', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            saveUserBtn.disabled = false;
            saveUserBtn.textContent = 'Save';
            if (data.status === 1) {
                location.reload();
            } else if (data.errors) {
                // Laravel validation errors
                if (data.errors.name) userNameInput.classList.add('is-invalid');
                if (data.errors.email) userEmailInput.classList.add('is-invalid');
                if (data.errors.user_access) userTypeInput.classList.add('is-invalid');
            } else {
                alert(data.msg || 'An error occurred.');
            }
        })
        .catch(() => {
            saveUserBtn.disabled = false;
            saveUserBtn.textContent = 'Save';
            alert('An error occurred.');
        });
    });
});
</script>



<style>

  </style>
@endpush
