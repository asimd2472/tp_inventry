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
                                
                                <form method="POST" action="{{route('roles.update',$role->id)}}">
                                    @csrf
                                @method('PUT')



                                <div class="mb-3">

                                <label>
                                Role Name
                                </label>


                                <input 
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{$role->name}}">


                                </div>



                                <h5>
                                Permissions
                                </h5>



                                @foreach($permissions as $permission)



                                <div class="form-check">


                                <input

                                type="checkbox"

                                class="form-check-input"

                                name="permission[]"

                                value="{{$permission->name}}"


                                @if($role->hasPermissionTo($permission->name))

                                checked

                                @endif


                                >



                                <label class="form-check-label">


                                {{$permission->name}}


                                </label>


                                </div>


                                @endforeach

                                <button class="btn btn-success mt-3">
                                    Update Role
                                </button>



                                <a href="{{route('roles.index')}}"
                                class="btn btn-secondary mt-3">
                                Back
                                </a>



                            </form>

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