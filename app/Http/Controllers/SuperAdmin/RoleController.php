<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
{

    abort_unless(
        auth()->user()->can('role-view'),
        403
    );

$roles = Role::with('permissions')->get();


return view(
'super_admin.roles.index',
compact('roles')
);

}



public function create()
{

$permissions = Permission::all();


return view(
'super_admin.roles.create',
compact('permissions')
);

}




public function store(Request $request)
{


$request->validate([

'name'=>'required|unique:roles'

]);



$role = Role::create([

'name'=>$request->name

]);



$role->syncPermissions(
$request->permission
);



return redirect()
->route('admin.roles.index');

}




public function edit(Role $role)
{


$permissions = Permission::all();


return view(
'super_admin.roles.edit',
compact(
'role',
'permissions'
)
);

}





public function update(Request $request,Role $role)
{


$role->update([

'name'=>$request->name

]);



$role->syncPermissions(
$request->permission
);



return redirect()
->route('admin.roles.index');

}




public function destroy(Role $role)
{

$role->delete();


return back();

}
}
