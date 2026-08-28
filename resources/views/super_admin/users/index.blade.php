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
                           
                            <a href="{{route('admin.users.create')}}"
                            class="btn btn-primary">

                            Add User

                            </a>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-hover companyTable">
                                    <tr>

                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>

                                    </tr>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                {{$user->name}}
                                            </td>
                                            <td>
                                                {{$user->email}}
                                            </td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                <span class="badge bg-success">
                                                {{$role->name}}
                                                </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{route('admin.users.edit',$user)}}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{route('admin.users.destroy',$user)}}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </section>

@endsection


@push('scripts')



@endpush
