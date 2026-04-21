@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Gallery</div>
                        
                        <div class="user-body">
                           
                            <div class="row justify-content-center mb-4">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{route('admin.brochure_upload')}}" id="brochureUploadForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="file_name" class="form-label">Select File</label>
                                                    <input class="form-control" type="file" id="file_name" name="file_name[]" multiple required>
                                                </div>
                                                <button type="submit" id="forgot_btn" class="btn btn-primary">Upload Brochure</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{route('admin.dealers_upload')}}" id="dealersUploadForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="file_name" class="form-label">Select File</label>
                                                    <input class="form-control" type="file" id="file_name" name="file_name[]" required>
                                                </div>
                                                <button type="submit" id="dealers_btn" class="btn btn-primary">Upload Dealers</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row justify-content-center">
                                
                                <div class="col-xl-12 col-md-12 col-12">

                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Brochure
                                            </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="table-responsive mt-1">
                                                        <table class="table table-bordered table-hover companyTable">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">File</th>
                                                                    <td>Action</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($brochure as $item)
                                                                    <tr>
                                                                        <td>{{$item->file_name}}</td>
                                                                        <td>
                                                                            <a href="{{asset('storage/gallery/'.$item->file_name)}}" target="_blank" class="btn btn-sm btn-info editUserBtn">View</a>
                                                                            <form action="{{ route('admin.brochure_delete', $item->id) }}" method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                                    onclick="return confirm('Are you sure?')">
                                                                                    Delete
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Dealers
                                            </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="table-responsive mt-1">
                                                        <table class="table table-bordered table-hover companyTable">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">File</th>
                                                                    <td>Action</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($dealers as $item)
                                                                    <tr>
                                                                        <td>{{$item->file_name}}</td>
                                                                        <td>
                                                                            <a href="{{asset('storage/gallery/'.$item->file_name)}}" target="_blank" class="btn btn-sm btn-info editUserBtn">View</a>
                                                                            <form action="{{ route('admin.dealers_delete', $item->id) }}" method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                                    onclick="return confirm('Are you sure?')">
                                                                                    Delete
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                
                                                            </tbody>
                                                        </table>
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
            </div>
        </div>
    </section>

@endsection

@push('scripts')

<script>

</script>



<style>

  </style>
@endpush
