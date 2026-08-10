<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
{
    abort_unless(
        auth()->user()->can('user-view'),
        403
    );

    $users = User::with('roles')->get();

    return view(
        'super_admin.users.index',
        compact('users')
    );

}



public function create()
{

    $roles = Role::all();


    $managers = User::role(
        'Sales Manager'
    )->get();


    return view(
        'super_admin.users.create',
        compact(
            'roles',
            'managers'
        )
    );

}




public function store(Request $request)
{

// dd($request->all());

$user = User::create([

'name'=>$request->name,

'email'=>$request->email,

'password'=>Hash::make($request->password),


'manager_id'=>$request->manager_id,
'status'=>1,

]);



$user->assignRole(
$request->role
);



return redirect()
->route('admin.users.index');

}




public function edit(User $user)
{

$managers = User::role(
        'Sales Manager'
    )->get();

$roles = Role::all();


return view(
'super_admin.users.edit',
compact(
'user',
'roles',
'managers'
));

}




public function update(Request $request,User $user)
{


$request->validate([

'name'=>'required',

'email'=>'required|email'

]);



$user->update([

'name'=>$request->name,

'email'=>$request->email,
'manager_id'=>$request->manager_id

]);



if($request->password)
{

$user->update([

'password'=>Hash::make($request->password)

]);

}



$user->syncRoles(
$request->role
);



return redirect()
->route('admin.users.index');

}




public function destroy(User $user)
{

$user->delete();


return back();

}
}
