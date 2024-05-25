<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\backend\AdminUsers;
use App\Models\backend\Invoices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\frontend\Ideas;
use App\Models\frontend\Users;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB as FacadesDB;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd('dsgd');
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user_role = Auth::user()->role;
        $customer_count = count(Users::get());
        $revenue = Invoices::sum('total');
        $month = date('m', strtotime(date('Y-m-d')));
        $customer_percent_lm = Users::whereRaw('MONTH(created_at) = ?', [$month])->count();
        // dd($customer_count,$customer_percent_lm);
        if ($customer_count != 0) {
            $customer_percent_lm = round(($customer_percent_lm / $customer_count) * 100, 1);
        } else {
            // Handle the case where $customer_count is zero (optional)
            $customer_percent_lm = 0;
        }

        $revenue_percent_lm = Invoices::whereRaw('MONTH(created_at) = ?', [$month])->sum('total');
        if ($revenue_percent_lm) {
            $revenue_percent_lm = round(($revenue_percent_lm / $revenue) * 100, 2);
        } else {
            $$revenue_percent_lm = 0;
        }


        return view('backend.admin.dashboard', compact('customer_count', 'customer_percent_lm', 'revenue', 'revenue_percent_lm'));
    }

    public function showusers()
    {
        //  dd('welcoome');
        $adminusers = AdminUsers::where('admin_user_id', '!=', 1)->with('userrole')->orderBy('admin_user_id', 'DESC')->get();
        // dd($adminusers);
        return view('backend.admin.index', compact('adminusers'));
    }

    public function create()
    {
        $role = Role::get(['id', 'name'])->toArray();
        return view('backend.admin.create', compact('role'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:admin_users,email,NULL,admin_user_id,deleted_at,NULL',
            'role' => 'required',
            // 'mobile_no' => 'required|numeric|digits:10',
            'password' => 'required|confirmed|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);
        $user = new AdminUsers;
        $user->fill($request->all());
        if ($user->save()) {
            // Activity Log
            $log = ['module' => 'Internal Users', 'action' => 'Add User', 'description' => 'Internal User added : ' . $request->first_name . ' ' . $request->last_name];
            captureActivity($log);
            return redirect('/admin/users')->with('success', 'User Created Successfully');
        } else {
            return redirect('/admin/users')->with('error', 'Failed to add user');
        }
    }

    public function edit($id)
    {
        $userdata = AdminUsers::where('admin_user_id', $id)->first();
        $cc_mail_data = FacadesDB::table('cc_emails')->where('admin_user_id', $id)->select('assign_cc')->get();
        // dd($cc_mail_data->toArray());
        // dd($userdata);
        $role = Role::pluck('name', 'id');
        return view('backend.admin.edit', compact('userdata', 'role', 'cc_mail_data'));
    }
    public function update(Request $request)
    {
        $data = AdminUsers::where('admin_user_id', $request->admin_user_id)->get();
        if (count($data) > 0) {
            // $userdata = InternalUser::where('user_id', $request->id)->update($update_data);
            $userdata = AdminUsers::where('admin_user_id', $request->admin_user_id)->first();
            $original_user = $userdata->first_name . ' ' . $userdata->last_name;
            $userdata->fill($request->all());
            if ($userdata->save()) {
                $user_role = [];
                if ($userdata->getChanges()) {
                    $upd = $userdata->getChanges();
                    unset($upd['updated_at']);
                    $str = ['module' => 'Internal Users', 'action' => 'Edit User', 'description' => 'Internal User Edited  : ' . $original_user . ' : ('];

                    userCaptureActivityupdate($upd, $str, $user_role);
                }
                return redirect()->route('admin.users')->with('success', 'User Has Been Updated');
            } else {
                return redirect('/admin/users')->with('error', 'Failed to update the User');
            }
        }
    }

    //delete user
    public function destroyUser($id)
    {
        $user = AdminUsers::where('admin_user_id', $id)->get();
        if (count($user) > 0) {
            $user = AdminUsers::where('admin_user_id', $id)->first();
            $original_user = $user->first_name . ' ' . $user->last_name;
            if ($user->delete()) {

                // Activity Log
                $log = ['module' => 'Internal User', 'action' => 'Delete User', 'description' => 'User Deleted : ' . $original_user];
                captureActivity($log);

                return redirect('/admin/users')->with('success', 'User Has Been Deleted');
            } else {
                return redirect('/admin/users')->with('error', 'Failed to delete User');
            }
        }
    }

    //update Status
    public function  updateStatusAndRole(Request $request)
    {
        // dd($request->all());
        $data = AdminUsers::where('admin_user_id', $request->admin_user_id)->get();
        if (count($data) > 0) {
            $userdata = AdminUsers::where('admin_user_id', $request->admin_user_id)->first();
            $original_user = $userdata->first_name . ' ' . $userdata->last_name;
            $userdata->fill($request->all());
            $user_role = [];
            // dd($request->assign_cc);
            if ($userdata->save()) {

                if ($request->assign_cc == "1") {
                    // dd('safgg');
                    try {
                        DB::table('cc_emails')->insert(
                            ['admin_user_id' => $request->admin_user_id, 'cc_mail' => $request->email, 'assign_cc' => 1]
                        );
                    } catch (Exception $e) {
                        DB::table('cc_emails')->where('admin_user_id', $request->admin_user_id)->update(
                            ['assign_cc' => 1]
                        );
                    }
                } else {
                    DB::table('cc_emails')->where('admin_user_id', $request->admin_user_id)->update(
                        ['assign_cc' => 0]
                    );
                }
                if ($userdata->getChanges()) {
                    //activity Log
                    $upd = $userdata->getChanges();

                    unset($upd['updated_at']);
                    // dd($upd);
                    $str = ['module' => 'Internal Users', 'action' => 'Edit Status and Role', 'description' => 'Internal User Status and Role Edited  : ' . $original_user . ' : ('];

                    userCaptureActivityupdate($upd, $str, $user_role);
                }
                return redirect('/admin/users')->with('success', 'User Status and Role Been Updated');
            } else {
                return redirect('/admin/users')->with('error', 'Failed to update User Status and Role');
            }
        }
    }
    public function profile($id)
    {
        $adminuser = AdminUsers::where('admin_user_id', $id)->first();
        $role = Role::pluck('name', 'id');
        return view('backend.admin.myprofile', compact('adminuser', 'role'));
    }
    public function  updateProfile(Request $request)
    {
        $data = AdminUsers::where('admin_user_id', $request->admin_user_id)->get();
        if (count($data) > 0) {
            $userdata = AdminUsers::where('admin_user_id', $request->admin_user_id)->first();
            $original_user = $userdata->first_name . ' ' . $userdata->last_name;
            $userdata->fill($request->all());
            if ($userdata->save()) {
                $user_role = [];
                if ($userdata->getChanges()) {
                    //activity Log
                    $upd = $userdata->getChanges();

                    unset($upd['updated_at']);
                    // dd($upd);
                    $str = ['module' => 'Edit Profile', 'action' => 'Edit Profile', 'description' => 'Profile Edited  : ' . $original_user . ' : ('];

                    userCaptureActivityupdate($upd, $str, $user_role);
                }
                return redirect('/admin/users')->with('success', 'Profile has been updated');
            }
        }
    }
    public function changePassword()
    {
        $id = Auth()->guard('admin')->id();
        // dd($id);
        $userdata = AdminUsers::where('admin_user_id', $id)->first();
        return view('backend.admin.changepassword', compact('userdata'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|required_with:password_confirmation|same:password_confirmation|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);
        $data = AdminUsers::where('admin_user_id', $request->user_id)->first();
        if (count($data->toArray()) > 0) {
            if (Hash::check($request->old_password, $data->password)) {
                // dd('Password matches');
                // dd($request->new_password);
                $data->password = $request->new_password;
                if ($data->save()) {

                    // Activity Log
                    $log = ['module' => 'Change Password', 'action' => 'Change Password', 'description' => 'Account Password Changed '];
                    captureActivity($log);

                    return redirect()->back()->with('success', 'Password Has Been Updated');
                } else {
                    return redirect()->back()->with('error', 'Unable to change the password');
                }
            } else {
                // dd("Password doesn't match");
                return redirect()->route('admin.changepassword')->with('error', "Password doesn't match");
            }
        }
    }
}//end of class
//  $2y$10$uP3kg6DjPlGtDoQTSgpOouHGwo/9mBWc9fJkd/1JwwlHRC924JIqS
