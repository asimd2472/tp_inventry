
@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Upload File</div>
                        <div class="user-body">

                            <div class="row justify-content-center">
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{route('admin.inventry_upload')}}" id="inventryUploadForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">Select File</label>
                                                    <input class="form-control" type="file" id="formFile" name="file" required>
                                                </div>
                                                <button type="submit" id="forgot_btn" class="btn btn-primary">Upload</button>
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
    </section>

@endsection


