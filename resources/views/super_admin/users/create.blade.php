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

                            <form method="POST" action="{{route('admin.users.store')}}">
                                @csrf
                                <input class="form-control mb-2" name="name" placeholder="Name">
                                <input class="form-control mb-2" name="email" placeholder="Email">
                                <input class="form-control mb-2" name="password" placeholder="Password">
                                <select name="role" class="form-control mb-2">
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">
                                        {{$role->name}}
                                        </option>
                                    @endforeach
                                </select>

                                <select name="manager_id" class="form-control">
                                    <option value="">No Manager</option>
                                    @foreach($managers as $manager)
                                    <option value="{{$manager->id}}">
                                    {{$manager->name}}
                                    </option>
                                    @endforeach
                                </select>

                                <button class="btn btn-success">
                                    Save
                                </button>
                            </form>

                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </section>

@endsection


@push('scripts')



@endpush