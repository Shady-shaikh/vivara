<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\frontend\Ideas;
use App\Models\frontend\Notification;
use App\Models\frontend\Users;
use App\Models\Rolesexternal;

class RolesexternalController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:admin');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $roles = Rolesexternal::all();
    // dd($roles);
    return view('backend.rolesexternal.index')->with('roles', $roles);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {

    return view('backend.rolesexternal.create');
    // exit;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'role_name' => ['required', 'unique:roles_external,role_name'],
      'role_type'=>'required',
    ]);
    // dd($request->all());
    // echo "string";exit;
    $status_values_ids = ($request->input('status_values')) ? implode(',', $request->input('status_values')) : NULL;
    $menu_values_ids = ($request->input('menu_values')) ? implode(',', $request->input('menu_values')) : NULL;
    $button_values_ids = ($request->input('button_values')) ? implode(',', $request->input('button_values')) : NULL;

    $role = Rolesexternal::create(['role_type'=>$request->input('role_type'),'role_name' => $request->input('role_name'), 'status_values' => $status_values_ids, 'menu_values' => $menu_values_ids, 'button_values' => $button_values_ids]);

    // $log = ['module' => 'Roles', 'action' => 'Role Created', 'description' => 'Role Created : Role Name : ' . $request->input('name')];
    // captureActivity($log);
    // // $role->syncPermissions($request->input('permission'));
    // // $role->givePermissionTo('Update');
    // $role->syncPermissions($request->input('permissions'));
    return redirect()->route('admin.rolesexternal')->with('success', 'New Role Added!');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $role = Rolesexternal::findOrFail($id);
    // $has_permissions = $role->getAllPermissions();
    // $has_permissions = collect($has_permissions)->mapWithKeys(function ($item, $key) {
    //   return [$item['id'] => $item['id']];
    // })->toArray();
    // dd($has_permissions);
    return view('backend.rolesexternal.edit', compact('role'));
    // return view('backend.roles.edit')->with('role', $role);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $this->validate($request, [
      'role_name' => 'required',
      'role_type'=>'required',
    ]);

    $id = $request->input('id');
    // echo "string".$id;exit;
    // dd($request->all());
    $role = Rolesexternal::findOrFail($id);
    $role->role_name = $request->input('role_name');

    $status_values_ids = ($request->input('status_values')) ? implode(',', $request->input('status_values')) : NULL;
    $menu_values_ids = ($request->input('menu_values')) ? implode(',', $request->input('menu_values')) : NULL;
    $button_values_ids = ($request->input('button_values')) ? implode(',', $request->input('button_values')) : NULL;

    // if ($request->input('submenu_id')) {
    //   $role->is_sub = 1;
    // } else {
    //   $role->is_sub = 0;
    // }
    $role->update(['role_type'=>$request->input('role_type'),'role_name' => $request->input('role_name'), 'status_values' => $status_values_ids, 'menu_values' => $menu_values_ids, 'button_values' => $button_values_ids]);
    // $role->update();
    // $log = ['module' => 'Roles', 'action' => 'Role Updated', 'description' => 'Role Updated : Role Name : ' . $request->input('name')];
    // captureActivity($log);
    // dd($request->input('permissions'));

    //     $role->givePermissionTo($db_permission);
    // $role->syncPermissions($request->input('permissions'));
    // Reset Cache
    // Artisan::call('role:cache-reset');
    // app()->make(\Spatie\Role\RoleRegistrar::class)->forgetCachedRoles();

    return redirect()->route('admin.rolesexternal')->with('success', 'Role Name Updated!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $role = Rolesexternal::findOrFail($id);
    $role->delete();
    $idea = Ideas::where('user_id', $id)->pluck('user_id')->get();
    Notification::whereIn('receiver_id', $idea)->delete();
    // $log = ['module' => 'Roles', 'action' => 'Role Deleted', 'description' => 'Role Deleted : Role Name : ' . $role->name];
    // captureActivity($log);
    return redirect()->route('admin.rolesexternal')->with('success', 'Role Deleted!');
  }
}
