<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\backend\AdminUsers;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PHPMailer\PHPMailer;
use phpmailerException;
use Route;

class AccountController extends Controller
{

  public function __construct()
  {
    $this->middleware('guest:admin', ['except' => ['logout']]);
  }

  public function showLoginForm()
  {
    return view('backend.account.loginform');
  }

  public function login(Request $request)
  {

    $this->validate($request, [
      'email'   => 'required|email',
      'password' => 'required'
    ]);

    // Attempt to log the user in
    // dd(Hash::check($request->old_password, AdminUsers::where('email', $request->email)->first()));
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], 'account_status', 1)) {
      if (isset(Auth()->guard('admin')->user()->admin_user_id)) {
        // dd(Auth()->guard('admin')->user());
        if (Auth()->guard('admin')->user()->account_status == 0) {
          Auth::guard('admin')->logout();
          return back()->withErrors([
            'message' => 'Your account has been deactivated, Please contact 3P team to reactivate your account.'
          ]);
        }
      }
      return redirect()->intended(route('admin.dashboard'));
      // return redirect()->intended(url()->previous());
    } else {
      // dd('wrong'.$request->password);
      return back()->withErrors([
        'message' => 'The email or password is incorrect, please try again'
      ]);
    }
  }

  public function logout()
  {

    Auth::guard('admin')->logout();
    return redirect('/admin');
  }

  public function forgot_password()
  {
    return view('backend.account.forgot_password');
  }

  public function storeforgotpassword(Request $request)
  {


    $this->validate($request, [
      'new-password' => [
        'required', 'confirmed',
        Password::min(8)->letters()->numbers()
      ],
      'new-password_confirmation' => ['required'],
    ]);

    $token = Str::random(64);
    $id = Session::get('id');
    $email = Session::get('email');



    $new_password = $request->input('new-password');

    $newpassword = Hash::make($new_password);
    DB::table('users')
      ->where('id', $id)
      ->where('email', $email)
      ->update(array(
        'password' => $newpassword,
        'password_reset_token' => $token,

      ));

    return redirect()->to('/login')->with('success', 'Password changed Successfully');
  }

  public function sendotp(Request $request)
  {

    $this->validate(request(), [
      'email' => 'required',
    ]);
    $user = AdminUsers::where('email', $request->email)->first();
    // dd($user->toarray());
    //   $user = $request->admin_user_id;

    if ($user == null) {
      return redirect()->route('admin.forgot_password')->withErrors(['Inavlid Email!!!Please Try with Valid Email']);
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
      //for local start
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
      $mail->Body = 'Password reset <a href="' . route('admin.resettoken', ['token' => $randomString]) . '">Click Here to change Password</a>';
      // dd($mail->Body);
      $mail->Send();

      Session::put('email', $email);
      Session::put('admin_user_id ', $user->admin_user_id);

      if ($user->token != null) {
        // $user = DB::table('admin_users')
        //     ->where('email', $email)
        //     ->update(array(
        //         'token' => $randomString
        //     ));
        $user = AdminUsers::where('email', $email)->update(['token' => $randomString]);
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
    return view('backend.account.thankyou');
  }
  public function showResetPasswordForm(request $request)
  {
    // dd('sdgdfsg');
    $resetdata = AdminUsers::where('token', $request->token)->get();
    // dd($resetdata);
    if (isset($request->token) && count($resetdata) > 0) {
      $user = AdminUsers::where('email', $resetdata[0]['email'])->get();
    }
    return view('backend.account.setpasswordform', compact('user'));
  }
  public function changeforgotpassword(request $request)
  {
    // dd($request->all());
    $this->validate(request(), [
      'password' => 'required|required_with:password_conformation|same:password_conformation|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
      'password_conformation' => 'required',
    ]);
    $user = AdminUsers::find($request->id);
    $user->password = ($request->password);
    $user->save();

    return redirect()->route('admin.login')->with('success', 'The password has been changed Successfully');
  }
}
