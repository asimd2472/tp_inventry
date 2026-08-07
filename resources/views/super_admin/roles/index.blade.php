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
                                
                                {{-- <a href="{{route('roles.create')}}" class="btn btn-primary">Add Role</a> --}}
                                <table class="table mt-3">
                                    <tr>
                                        <th>Role</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>{{$role->name}}</td>
                                            <td>
                                                @foreach($role->permissions as $permission)
                                                <span class="badge bg-info">
                                                    {{$permission->name}}
                                                </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{route('roles.edit',$role)}}" class="btn btn-warning btn-sm">Edit</a>
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