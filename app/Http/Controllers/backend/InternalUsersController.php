<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\backend\InternalUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;


class InternalUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    // public function index_()
    // {
    //     $internalusers = InternalUser::orderBy('user_id', 'DESC')->get();
    //     return view('backend.internalusers.index', compact('internalusers'));
    // }

    // //create new user
    // public function create_()
    // {
    //     $role = Role::get(['id', 'name'])->toArray();
    //     return view('backend.internalusers.create', compact('role'));
    // }

    public function store(Request $request)
    {

        // $request->validate([
        //     'fullname' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'role_id' => 'required',
        //     'dob' => 'required',
        // ]);

        // $user = new InternalUser;
        // $user->fill($request->all());
        // $user->save();
        // return redirect('/admin/internalusers')->with('success', 'New User Registered');
    }


    // public function destroyUser($id)
    // {
    //     $user = InternalUser::where('user_id', $id)->get();
    //     if (count($user) > 0) {
    //         if (InternalUser::where('user_id', $id)->delete()) {
    //             return redirect('/admin/internalusers')->with('success', 'User Has Been Deleted');
    //         }
    //     }
    // }
    // public function edit($id)
    // {
    //     $userdata = InternalUser::where('user_id', $id)->first();
    //     $role = Role::get(['id', 'name']);
    //     return view('backend.internalusers.edit', compact('userdata', 'role'));
    // }
    // public function update(Request $request)
    // {
    //     $update_data = $request->all();
    //     unset($update_data['_token']);
    //     //  dd($update_data);
    //     $data = InternalUser::where('user_id', $request->user_id)->get();
    //     if (count($data) > 0) {
    //         // $userdata = InternalUser::where('user_id', $request->id)->update($update_data);
    //         $userdata = InternalUser::where('user_id', $request->user_id)->first();

    //         $userdata->fill($request->all());
    //         if ($userdata->save()) {
    //             return redirect('/admin/internalusers')->with('success', 'User Has Been Updated');
    //         }
    //     }
    // }
} //end of class
