<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use App\Models\frontend\Users;
use App\Models\backend\Company;
use App\Models\backend\Location;
use App\Models\backend\Designation;
use App\Models\frontend\Department;
use App\Http\Controllers\Controller;
use App\Models\backend\AdminUsers;
use App\Models\backend\CategoryCarousel;
use App\Models\backend\Items;
use App\Models\backend\ProductCarousel;
use App\Models\frontend\Address;
use App\Models\Rolesexternal;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session as FacadesSession;
use phpmailerException;
use Session;
use Webleit\ZohoBooksApi\Modules\Contacts;

class UserController extends Controller
{
    public function register()
    {
        return view('frontend.account.registration');
    }

    public function dashboard()
    {
        $carousel_items = ProductCarousel::take(8)->get();
        $category_items = CategoryCarousel::take(8)->get();
        return view('frontend.users.dashboard',compact('carousel_items','category_items'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validated =  $request->validate([
            'name' => 'required|alpha_spaces',
            'last_name' => 'required|alpha_spaces',
            // 'company_name' => 'required',
            // 'contact_type' => 'required',
            'email' => 'email|required|unique:users',
            'mobile_no' => ['required', 'regex:/^(8|9|7|6)+[0-9]{9}$/'],
            'password' => 'required|confirmed|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'country' => 'required',
            'state' => 'required',
        ]);

        //create customer on zoho
        $zohoClient = get_zoho_client();
        $contacts = new Contacts($zohoClient);


        $customerData = [
            'contact_name' => request('name') . " " . request('last_name'),
            'company_name' => request('company_name'),
            'country_code' => request('country'),
            'place_of_contact' => request('state'),
            // 'contact_type' => request('contact_type'),
            'contact_persons' => [
                [
                    'first_name' => request('name'),
                    'last_name' => request('last_name'),
                    'email' => request('email'),
                    'mobile' => request('mobile_no'),
                ],
            ]
        ];

        try {
            $newCustomer = $contacts->create($customerData);
            // dd($newCustomer);


            if ($newCustomer) {
                $user = new Users();
                $user->contact_id = $newCustomer->contact_id;
                $user->fill($request->all());
                $user->state = request('state');
                if ($user->save()) {





                    // dd($newCustomer);


                    Session::put('email', $request->email);
                    Session::put('user_id ', $user->user_id);
                    // Verification mail
                    // try {
                    //     $email = $request->email;
                    //     // dd($email);
                    //     $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    //     $randomString = '';
                    //     for ($i = 0; $i < 10; $i++) {
                    //         $index = rand(0, strlen($characters) - 1);
                    //         $randomString .= $characters[$index];
                    //     }


                    //     $mail = new PHPMailer\PHPMailer(true);
                    //     $mail->IsSMTP();
                    //     $mail->CharSet = "utf-8"; // set charset to utf8
                    //     $mail->SMTPAuth = true; // authentication enabled
                    //     $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
                    //     $mail->Host = "smtp.gmail.com";
                    //     $mail->Port = 587; // port - 587/465
                    //     $mail->Username = "ideaportal@jmbaxi.com";
                    //     $mail->Password = 'cflcunvcsjgswsyo';



                    //     $mail->SMTPOptions = array(
                    //         'ssl' => array(
                    //             'verify_peer' => false,
                    //             'verify_peer_name' => false,
                    //             'allow_self_signed' => true
                    //         )
                    //     );

                    //     $mail->isHTML(true);
                    //     $mail->setFrom("abuosamas@parasightsolutions.com", 'Vivara');
                    //     $mail->addAddress($email);


                    //     $mail->Subject = "Vivara Account Verification";
                    //     // $mail->Body = 'Password reset <a href="url("resettoken/{token}")' . $randomString.'">Click Here to change Password</a>';
                    //     $mail->Body = '
                    //                 <p style="font-size:1.2em"><strong>Username : </strong>' . $request->name . ' ' . $request->last_name . '<br>
                    //                <strong>E-Mail : </strong>' . $request->email . '</p><br>
                    //                 <a href="' . url("/verify_mail/" . $randomString) . '">Click Here to Verify Your mail</a>';
                    //     $mail->Send();

                    //     if ($user->verify_token != null) {

                    //         $user = Users::where('email', $email)->update('verify_token', $randomString);
                    //     } else {
                    //         $user->verify_token = $randomString;
                    //         $user->save();
                    //     }
                    //     return redirect()->route('user.login')->with('success', 'Registered successfully \n Verification Email has been sent to your mail');

                    //     // return redirect()->to('/verify_mail/' . $randomString);
                    // } catch (phpmailerException $e) {
                    //     echo $e->errorMessage();
                    // } catch (Exception $e) {
                    //     echo $e->getMessage();
                    // }
                    return redirect()->route('user.login')->with('success', 'User Has Been Registered');
                } else {
                    return redirect()->back()->with('error', 'Something went wrong');
                }
            }
        } catch (Exception $e) {
            // dd($e);
            return redirect()->route('user.register')->with('error', $e);
        }
        // dd(route('frontend.users.dashbard'));

    }
    public function verifyMailToken(Request $request)
    {
        $user = Users::where('verify_token', $request->token)->get();
        if (count($user) > 0) {
            // dd(count($user) > 0);
            $user = Users::where('verify_token', $request->token)->update(['email_verification' => 1]);
            if ($user) {
                return redirect()->route('verify_mail.success');
            } else {
                return redirect()->route('user.login')->with('error', 'Failed to verify the mail');
            }
        } else {
            return redirect()->route('user.login')->with('error', 'Failed to verify the mail');
        }
    }
    public function verifyMailSuccess()
    {
        return view('frontend.account.verified');
    }
    public function login()
    {

        return view('frontend.account.userLogin');
    }
    public function auth(Request $request)
    {
        // return $request->input('email');



        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);




        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (auth()->user()->email_verification) {

                //update organization

                $data =  DB::table('organization')->get(['organization_id']);
                // dd($data);
                if ($data->isEmpty()) {
                    $zohoBooks = get_all_modules_zoho();
                    $org_data = $zohoBooks->organizations->get(env('ZOHO_ORGANIZATION_ID'));

                    DB::table('organization')->updateOrInsert([
                        'organization_id' => $org_data->organization_id,
                        'state_code' => $org_data->address['state_code'],
                        // 'name' => $org_data->name,
                    ]);
                }



                return redirect()->route('user.dashboard');
            } else {
                Session::flash('error', 'Email Verification Failed');
                return redirect()->route('user.login', ['status' => 'error']);
            }
        } else {
            return redirect()->back()->with('error','The email or password is incorrect, please try again');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        Session::flash('success', 'Logout Successfully!');
        return redirect('/');
    }

    public function profile()
    {
        $id = Auth::id();
        $userdata = Users::where('user_id', $id)->first();
        return view('frontend.users.editProfile', compact('userdata'));
    }

    public function address()
    {
        $id = Auth::id();
        $userdata = Users::where('user_id', $id)->first();
        $bill_add = Address::where(['contact_id' => $userdata->contact_id, 'address_type' => 'bill'])->first();
        $ship_add = Address::where(['contact_id' => $userdata->contact_id, 'address_type' => 'ship'])->first();

        // dd($bill_add,$ship_add);
        return view('frontend.users.address', compact('userdata', 'id', 'bill_add', 'ship_add'));
    }

    public function updateAddress(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'attention' => 'required',
            'country' => 'required',
            'street1' => 'required',
            'street2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        $customer_Data = Users::where('user_id', $request->user_id)->first();

        $check_data = Address::where('contact_id', $customer_Data->contact_id)->first();

        $zohoClient = get_zoho_client();
        $contacts = new Contacts($zohoClient);


        $address_data = [
            'billing_address' => [

                'attention' => $customer_Data->name,
                'address' => request('street1'),
                'street2' => request('street2'),
                'state_code' => request('state'),
                'city' => request('city'),
                'state' => request('state'),
                'zip' => request('zip_code'),
                'country' => request('country'),
                'fax' => request('fax'),
                'phone' => request('phone'),

            ],
            'shipping_address' => [

                'attention' => $customer_Data->name,
                'address' => request('street1_ship'),
                'street2' => request('street2_ship'),
                'state_code' => request('state_ship'),
                'city' => request('city_ship'),
                'state' => request('state_ship'),
                'zip' => request('zip_code_ship'),
                'country' => request('country_ship'),
                'fax' => request('fax_ship'),
                'phone' => request('phone_ship'),

            ]

        ];

        // dd($address_data);

        try {
            $contacts->update($customer_Data->contact_id, $address_data);
            $customer_Data->state = request('state');
            $customer_Data->save();
            
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', 'Technical Issue In Address Update, Please Retry!');
        }

        // dd($check_data);
        if (!empty($check_data)) {
            // foreach ($check_data as $row) {
            $bill_add = Address::where(['contact_id' => $customer_Data->contact_id, 'address_type' => 'bill'])->first();
            $ship_add = Address::where(['contact_id' => $customer_Data->contact_id, 'address_type' => 'ship'])->first();

            if (!empty($bill_add)) {
                // dd('bill');
                $bill_add->filladdress = $request->filladdress ? true : false;
                $bill_add->fill($request->all());
                $bill_add->save();
            }
            if (!empty($ship_add)) {
                $ship_add->attention = $request->attention_ship;
                $ship_add->country = $request->country_ship;
                $ship_add->street1 = $request->street1_ship;
                $ship_add->street2 = $request->street2_ship;
                $ship_add->city = $request->city_ship;
                $ship_add->state = $request->state_ship;
                $ship_add->zip_code = $request->zip_code_ship;
                $ship_add->phone = $request->phone_ship;
                $ship_add->fax = $request->fax_ship;
                $ship_add->filladdress = $request->filladdress ? true : false;
                $ship_add->save();
            }
            // }
            return redirect()->back()->with('success', 'User Address Has Been Updated');
        } else {
            $model  = new Address();
            $model->address_type = 'bill';
            $model->contact_id = $customer_Data->contact_id;
            $model->filladdress = $request->filladdress ? true : false;
            $model->fill($request->all());

            if ($model->save()) {

                $data = new Address;
                $data->address_type = 'ship';
                $data->user_id = $request->user_id;
                $data->contact_id = $customer_Data->contact_id;
                $data->attention = $request->attention_ship;
                $data->country = $request->country_ship;
                $data->street1 = $request->street1_ship;
                $data->street2 = $request->street2_ship;
                $data->city = $request->city_ship;
                $data->state = $request->state_ship;
                $data->zip_code = $request->zip_code_ship;
                $data->phone = $request->phone_ship;
                $data->fax = $request->fax_ship;
                $data->filladdress = $request->filladdress ? true : false;

                if ($data->save()) {
                    return redirect()->back()->with('success', 'User Address Has Been Updated');
                }
            } else {
                return redirect()->back()->with('error', 'Something went wrong, please try again!');
            }
        }
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
            'mobile_no' => 'required|numeric|digits:10',
            // 'company_name' => 'required',
            'country' => 'required',
            'state' => 'required',
            // 'contact_type' => 'required',
        ]);




        $data = Users::where('user_id', $request->user_id)->first();


        if (count($data->toArray()) > 0) {
            //update customer details on zoho
            $zohoClient = get_zoho_client();
            $contacts = new Contacts($zohoClient);



            $updatedCustomerData  = [
                'contact_name' => request('name') . " " . request('last_name'),
                'company_name' => request('company_name'),
                'country_code' => request('country'),
                'place_of_contact' => request('state'),
                // 'contact_persons' => [
                //     [
                //         'first_name' => request('name'),
                //         'last_name' => request('last_name'),
                //         'email' => request('email'),
                //         'mobile' => request('mobile_no'),
                //     ],
                // ]
            ];


            // Use the Zoho Books API to update the customer
            try {
                $updatedCustomer = $contacts->update($data->contact_id, $updatedCustomerData);
                // dd($updatedCustomer);
                if ($updatedCustomer) {
                    $data->fill($request->all());
                    // dd($data);
                    if ($data->save()) {
                        return redirect()->back()->with('success', 'User Has Been Updated');
                    }
                }
            } catch (Exception $e) {
                // dd($e);
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    public function changePassword()
    {
        $id = Auth::id();
        $userdata = Users::where('user_id', $id)->first();
        return view('frontend.users.user_change_password', compact('userdata'));
    }


    public function changeRole()
    {
        $id = Auth::id();
        $userdata = Users::where('user_id', $id)->first();
        $multi_role = explode(",", $userdata->sub_role);
        $role = Rolesexternal::whereIn('id', $multi_role)->pluck('role_name', 'id');
        return view('frontend.users.change_role', compact('userdata', 'role', 'multi_role'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|required_with:password_confirmation|same:password_confirmation|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);
        $data = Users::where('user_id', $request->user_id)->first();
        if (count($data->toArray()) > 0) {
            if (Hash::check($request->old_password, $data->password)) {
                // dd('password matches');

                $data->password = $request->new_password;
                if ($data->save()) {
                    return redirect()->back()->with('success', 'Password Has Been Updated');
                }
            } else {
                // dd("Password doesn't match");
                return redirect()->route('user.changePassword')->with('error', "Password doesn't match");
            }
        }
    }
    public function forgot_password()
    {
        return view('frontend.account.forgot_password');
    }
    public function sendotp(Request $request)
    {


        // dd($request->all());
        $this->validate(request(), [
            'email' => 'required',
        ]);
        $user = Users::where('email', $request->email)->first();
        // dd($user->toarray());
        //   $user = $request->admin_user_id;

        if ($user == null) {
            return redirect()->route('user.forgot_password')->withErrors(['Inavlid Email!!!Please Try with Valid Email']);
        }
        try {
            //             $token = random();
            // dd($token);
            $email = $request->email;
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            // dd($randomString);
            // return $randomString;
            $mail = new PHPMailer\PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet = "utf-8"; // set charset to utf8
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "mail.parasightdemo.com";
            $mail->Port = 465; // port - 587/465
            $mail->Username = "vivara@parasightdemo.com";
            $mail->Password = 'HYpm1icOE?6(';
            //for local end
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->isHTML(true);
            $mail->setFrom("vivara@parasightdemo.com", 'Vivara');
            $mail->AddAddress($email);
            $mail->Subject = "Passowrd Reset link";
            // $mail->Body = 'Password reset <a href="url("resettoken/{token}")' . $randomString.'">Click Here to change Password</a>';
            $mail->Body = 'Password reset <a href="' . url("/resettoken/" . $randomString) . '">Click Here to change Password</a>';
            // dd($mail->Body);
            $mail->Send();

            Session::put('email', $email);
            Session::put('admin_user_id ', $user->admin_user_id);

            if ($user->token != null) {
                $user = Users::where('email', $email)->update(['token' => $randomString]);
            } else {
                $user->token = $randomString;
                $user->save();
            }

            return redirect()->to('/thankyou')->with('success', 'Email has been sent');

            // return redirect()->to('/resettoken/' . $randomString)->with('success', 'Email has been sent');
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function forthankyou()
    {
        return view('frontend.account.thankyou');
    }
    public function showResetPasswordForm(request $request)
    {
        // echo"hello";
        $resetdata = Users::where('token', $request->token)->get();
        // dd($resetdata);
        if (isset($request->token) && count($resetdata) > 0) {
            $user = Users::where('email', $resetdata[0]['email'])->get();
        }
        return view('frontend.account.setpasswordform', compact('user'));
    }
    public function changeforgotpassword(request $request)
    {
        // dd($request->all());
        $this->validate(request(), [
            'password' => 'required|required_with:password_conformation|same:password_conformation|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_conformation' => 'required',
        ]);
        $user = Users::find($request->id);
        $user->password = ($request->password);
        $user->save();
        // Session::flash('success','The password has been changed Successfully');
        return redirect()->route('user.login')->with('success', 'The password has been changed Successfully');
    }
}
