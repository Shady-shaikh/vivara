<?php

namespace App\Http\Controllers\backend;

use Hash;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\frontend\Users;
use App\Models\backend\Company;
use App\Models\backend\Location;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\backend\Designation;
use App\Models\frontend\Department;
use App\Http\Controllers\Controller;
use App\Models\Rolesexternal;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class ExternalusersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //   public function __construct()
    //   {
    //       $this->middleware('auth:admin');
    //   }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::user());
        if (Auth::user()->centralized_decentralized_type == 1) {
            $users = Users::orderBy('user_id', 'desc')->get();
        } else if (Auth::user()->centralized_decentralized_type == 2) {
            $users = Users::where('company_id', Auth::user()->company_id)->orderBy('user_id', 'desc')->get();
        }else{
            $users = Users::where('company_id', Auth::user()->company_id)->orderBy('user_id', 'desc')->get();
        }
        return view('backend.externalusers.index', compact('users'));
    }

    public function create()
    {
        return view('backend.externalusers.externalusers_create');
    }


    public function store(Request $request)
    {
        $validated =  $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,NULL,user_id,deleted_at,NULL',
            // 'email' => 'email|required|unique:users',
            'mobile_no' => 'required',
            'password' => 'required|confirmed',
            'department' => 'required',
            'location' => 'required',
            'company_id' => 'required',
            'designation_id' => 'required',

        ]);
        $user = new Users($validated);
        $user->fill($request->all());
        if ($user->save()) {
            // Activity Log
            $log = ['module' => 'External Users', 'action' => 'Add User', 'description' => 'External User Added : ' . $request->name . ' ' . $request->last_name];
            captureActivity($log);
            return redirect()->route('admin.externalusers')->with('success', 'New User Created');
        } else {
            return redirect()->route('admin.externalusers')->with('error', 'Failed to Create New User');
        }
        // dd(route('frontend.users.dashbard'));
    }

    public function edit($id)
    {
        $userdata = Users::where('user_id', $id)->first();
        // dd($userdata->toArray());
        $department = Department::pluck('name', 'department_id');
        $role = Rolesexternal::pluck('role_name', 'id');
        $location = Location::pluck('location_name', 'location_id');
        $designation = Designation::pluck('designation_name', 'designation_id');
        $company = Company::pluck('company_name', 'company_id');
        $roles_external = Rolesexternal::pluck('role_type', 'id')->toArray();
        // $assessmentUsersMails = DB::table('users')->whereRaw('FIND_IN_SET(?, sub_role)', [$roles_external])->get();
        // dd($roles_external);
        return view('backend.externalusers.edit', compact('role', 'roles_external', 'userdata', 'department', 'location', 'designation', 'company'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
            'mobile_no' => 'required',
            'department' => 'required',
            'location' => 'required',
            'company_id' => 'required',
            'designation_id' => 'required',
        ]);
        $update_data = $request->all();
        //unset($update_data['_token']);
        // dd($update_data);
        $data = Users::where('user_id', $request->user_id)->get();
        if (count($data) > 0) {
            $userdata = Users::where('user_id', $request->user_id)->first();
            $original_user = $userdata->name . ' ' . $userdata->last_name;

            $userdata->fill($request->all());
            if ($userdata->save()) {
                $user_role = [1];
                if ($userdata->getChanges()) {
                    //activity Log
                    $upd = $userdata->getChanges();

                    unset($upd['updated_at']);
                    // dd($upd);
                    $str = ['module' => 'External Users', 'action' => 'Edit User', 'description' => 'External User Edited  : ' . $original_user . ' : ('];

                    userCaptureActivityupdate($upd, $str, $user_role);
                }
                return redirect('/admin/externalusers')->with('success', 'User Has Been Updated');
            } else {
                return redirect('/admin/externalusers')->with('error', 'Failed to Edit User');
            }
        }
    }

    //delete user
    public function destroyUser($id)
    {
        $user = Users::where('user_id', $id)->get();
        if (count($user) > 0) {
            if (Users::where('user_id', $id)->delete()) {
                return redirect('/admin/externalusers')->with('success', 'User Has Been Deleted');
            }
        }
    }

    //update Status
    public function  updatestatus(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'role' => 'required',
            'active_status' => 'required',
        ]);
        $data = Users::where('user_id', $request->user_id)->get();

        $role_data = Rolesexternal::where('id', $request->role)->first();
        // dd($data->toArray());

        if (count($data) > 0) {
            $userdata = Users::where('user_id', $request->user_id)->first();
            $original_user = $userdata->name . ' ' . $userdata->last_name;
            // $userdata->fill($request->all());
            $userdata->token = $request->_token;
            $userdata->user_id = $request->user_id;
            $userdata->active_status = $request->active_status;
            $userdata->role = $role_data->role_type;
            $multiple_role = implode(",", $request->role);
            // dd($multiple_role);
            $userdata->sub_role  = $multiple_role;

            // $userdata->sub_role = $request->role;
            $userdata->centralized_decentralized_type = $request->centralized_decentralized_type;

            // dd($request->role);
            //if data exist for particular user ldete previous roles add new ones
            // $data = DB::select("SELECT * FROM sub_roles WHERE user_id = $request->user_id"); 
            // if (!empty($data)) {
            //     DB::table('sub_roles')->where('user_id', $request->user_id)->delete();
            // }
            // //adding new roles
            // foreach ($request->role as $row) {
            //     try {
            //         DB::table('sub_roles')->insert(['user_id' => $request->user_id, 'sub_role' => $row, 'centralized_decentralized_type' => $request->centralized_decentralized_type]);
            //     } catch (Exception $e) {
            //     }
            // }

            if ($userdata->save()) {
                $user_role = [1];
                if ($userdata->getChanges()) {

                    //activity Log
                    $upd = $userdata->getChanges();

                    unset($upd['updated_at']);
                    // dd($upd);
                    $str = ['module' => 'External Users', 'action' => 'Edit Status and Role', 'description' => 'External User Status and Role Edited  : ' . $original_user . ' : ('];

                    userCaptureActivityupdate($upd, $str, $user_role);
                }

                return redirect('/admin/externalusers')->with('success', 'User Status and User Role Has Been Updated');
            } else {
                return redirect('/admin/externalusers')->with('error', 'Failed to update Status and Role');
            }
        }
    }
}//end of class
