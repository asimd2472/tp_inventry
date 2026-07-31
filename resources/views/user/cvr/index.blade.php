@extends('layouts.app')

@section('content')

<section class="cvr-home">

    <div class="hero">

        <div class="hero-top">
            <div>
                <span class="sub-title">Sales & Marketing</span>
                <h2>FieldConnect</h2>
                <p>Create and manage Customer Visit Reports</p>
            </div>

            <a href="{{route('user.repository')}}" class="repo-btn">
                <i class="fas fa-folder-open"></i>
                Repository
            </a>
        </div>

    </div>

    <div class="container">

        <div class="main-card">

            <div class="icon-circle">
                <i class="fas fa-file-alt"></i>
            </div>

            <h3>New Visit Report</h3>

            <p class="desc">
                Record customer visits, upload Excel files,
                and manage CVRs easily from one place.
            </p>

            <div class="action-buttons">

                {{-- <a href="#" class="btn-main">
                    <i class="fas fa-plus"></i>
                    Create New CVR
                </a> --}}

                <button type="button" id="uploadCvrBtn" class="btn-main outline">
                    <span class="btn-text">
                        <i class="fas fa-upload"></i>
                        Upload CVR (Excel)
                    </span>
                    <span class="btn-loader" style="display:none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Uploading...
                    </span>
                </button>

                <input type="file"
                       id="cvrExcelInput"
                       accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
                       hidden>

            </div>

            <div class="support-box">
                <i class="fas fa-file-excel"></i>
                Supports .xlsx & .xls Files
            </div>

        </div>

    </div>

</section>

@endsection

@push('scripts')
<script type="module">
$(function () {
    var $btn = $('#uploadCvrBtn');
    var $input = $('#cvrExcelInput');
    var $btnText = $btn.find('.btn-text');
    var $btnLoader = $btn.find('.btn-loader');
    var allowedExtensions = ['xlsx', 'xls'];

    function setUploading(isUploading) {
        if (isUploading) {
            $btn.prop('disabled', true);
            $btnText.hide();
            $btnLoader.show();
        } else {
            $btn.prop('disabled', false);
            $btnText.show();
            $btnLoader.hide();
        }
    }

    function validateExcelFile(file) {
        if (!file) {
            return 'Please select a file.';
        }

        var extension = file.name.split('.').pop().toLowerCase();

        if (allowedExtensions.indexOf(extension) === -1) {
            return 'Only .xlsx and .xls files are allowed.';
        }

        return null;
    }

    $btn.on('click', function () {
        if (!$btn.prop('disabled')) {
            $input.val('');
            $input.trigger('click');
        }
    });

    $input.on('change', function () {
        var file = this.files[0];
        var validationError = validateExcelFile(file);

        if (validationError) {
            Swal.fire({
                title: 'Invalid File',
                text: validationError,
                icon: 'warning',
            });
            $input.val('');
            return;
        }

        var formData = new FormData();
        formData.append('excel', file);

        $.ajax({
            url: base_url + '/user/upload-cvr',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            beforeSend: function () {
                setUploading(true);
            },
            success: function (data) {
                setUploading(false);
                $input.val('');

                if (data.success) {
                    Swal.fire({
                        title: 'Success',
                        text: data.message + (data.count ? ' (' + data.count + ' record(s) imported)' : ''),
                        icon: 'success',
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Upload failed.',
                        icon: 'warning',
                    });
                }
            },
            error: function (xhr) {
                setUploading(false);
                $input.val('');

                var message = 'Upload failed. Please try again.';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors && xhr.responseJSON.errors.excel) {
                        message = xhr.responseJSON.errors.excel[0];
                    }
                }

                Swal.fire({
                    title: 'Error',
                    text: message,
                    icon: 'warning',
                });
            }
        });
    });
});
</script>
@endpush
