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

                            <form method="POST"
action="{{route('admin.users.update',$user->id)}}">


@csrf

@method('PUT')



<div class="mb-3">

<label>Name</label>

<input 
type="text"
name="name"
class="form-control"
value="{{$user->name}}">

</div>



<div class="mb-3">

<label>Email</label>

<input 
type="email"
name="email"
class="form-control"
value="{{$user->email}}">

</div>




<div class="mb-3">

<label>Password</label>

<input 
type="password"
name="password"
class="form-control"
placeholder="Leave blank to keep old password">


</div>




<div class="mb-3">

<label>Select Role</label>


<select 
name="role"
class="form-control">


@foreach($roles as $role)


<option 
value="{{$role->name}}"

@if($user->hasRole($role->name))

selected

@endif

>

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


</div>




<button class="btn btn-success">

Update User

</button>



<a href="{{route('admin.users.index')}}"
class="btn btn-secondary">

Back

</a>


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