<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RolesController extends Controller
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
    $roles = Role::get();
    return view('backend.roles.index')->with('roles', $roles);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('backend.roles.create');
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
      'name' => ['required', 'unique:roles,name']
    ]);
    // echo "string";exit;
    // dd($request->all());
    $menu_ids = ($request->input('menu_id')) ? implode(',', $request->input('menu_id')) : NULL;
    $submenu_ids = ($request->input('submenu_id')) ? implode(',', $request->input('submenu_id')) : NULL;
    if ($request->input('submenu_id')) {
      $is_sub = 1;
    } else {
      $is_sub = 0;
    }
    $role = Role::create(['name' => $request->input('name'), 'menu_ids' => $menu_ids, 'submenu_ids' => $submenu_ids, 'is_sub' => $is_sub]);

    $log = ['module' => 'Roles', 'action' => 'Role Created', 'description' => 'Role Created : Role Name : ' . $request->input('name')];
    captureActivity($log);
    // $role->syncPermissions($request->input('permission'));
    // $role->givePermissionTo('Update');
    $role->syncPermissions($request->input('permissions'));
    return redirect()->route('admin.roles')->with('success', 'New Role Added!');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $role = Role::findOrFail($id);
    $has_permissions = $role->getAllPermissions();
    $has_permissions = collect($has_permissions)->mapWithKeys(function ($item, $key) {
      return [$item['id'] => $item['id']];
    })->toArray();
    // dd($has_permissions);
    return view('backend.roles.edit', compact('role', 'has_permissions'));
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
      'name' => 'required'
    ]);
    $id = $request->input('id');
    // echo "string".$id;exit;
    // dd($request->all());
    $role = Role::findOrFail($id);
    $role->name = $request->input('name');
    $role->menu_ids = ($request->input('menu_id')) ? implode(',', $request->input('menu_id')) : NULL;
    $role->submenu_ids = ($request->input('submenu_id')) ? implode(',', $request->input('submenu_id')) : NULL;
    if ($request->input('submenu_id')) {
      $role->is_sub = 1;
    } else {
      $role->is_sub = 0;
    }
    $role->update();
    $log = ['module' => 'Roles', 'action' => 'Role Updated', 'description' => 'Role Updated : Role Name : ' . $request->input('name')];
    captureActivity($log);
    // dd($request->input('permissions'));

    //     $role->givePermissionTo($db_permission);
    $role->syncPermissions($request->input('permissions'));
    // Reset Cache
    // Artisan::call('role:cache-reset');
    // app()->make(\Spatie\Role\RoleRegistrar::class)->forgetCachedRoles();

    return redirect()->route('admin.roles')->with('success', 'Role Name Updated!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $role = Role::findOrFail($id);
    $role->delete();
    $log = ['module' => 'Roles', 'action' => 'Role Deleted', 'description' => 'Role Deleted : Role Name : ' . $role->name];
    captureActivity($log);
    return redirect()->route('admin.roles')->with('success', 'Role Deleted!');
  }
}
