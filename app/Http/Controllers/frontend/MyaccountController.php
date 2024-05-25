<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Cmspages;
use App\Models\backend\Faqs;
use App\Models\frontend\User;
use App\Models\frontend\ShippingAddresses;
use App\Models\frontend\Orders;
use Illuminate\Validation\Rule;
use Session;
use App\Models\frontend\OrderCancellationReasons;
use App\Models\frontend\OrderReturnReasons;
use App\Models\backend\Company;
use App\Models\backend\OrderCancelManagement;
use PHPMailer\PHPMailer;
use PDF;
use App\Models\frontend\Banks;


class MyaccountController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    
    // return view('frontend.myaccount.index');
    return redirect()->to('/myaccount/profile');
  }

  public function profile()
  {
    $user_id = auth()->user()->id;
    $user = User::find($user_id);
    return view('frontend.myaccount.profile',compact('user'));
  }

  public function storeprofile(Request $request)
  {
    $user_id = auth()->user()->id;
      $this->validate(request(), [
          'name' => 'required',
          'email' => ['required', 'email', Rule::unique(User::class,'email')->ignore($user_id, 'id')],
          // 'password' => 'required|confirmed|min:6',
          // 'referral_id' => 'required',
          // 'terms_condition_confirm' => 'required',
          // 'adhaar_no' => 'required|alpha_num',
          // 'address' => 'required',
          // 'mobile_no' => 'required|unique:users',
          'mobile_no' => ['required','min:10', Rule::unique(User::class,'mobile_no')->ignore($user_id, 'id')],
          'gender' => 'required',
      ]);
      // echo "string";exit;
      $user = User::find($user_id);
      // $current_year = date('y');
      // $current_date = date('d');
      // $current_month = date('m');
      if($user->fill($request->all())->update())
      {
        // $current_user = User::find($user->id);
        //
        // auth()->login($current_user);
        // $this->send_email($request->email,$request->name,$current_user->distributor_id);
        Session::flash('success','Profile Updated Successfully');
        // Session::flash('message','Profile Updated Successfully');
        // Session::flash('message', 'Cart Updated Successfully!');
        // Session::flash('status', 'success');
        return redirect()->to('myaccount');
        //->with('message','Profile Updated Successfully')
      }

    }

    public function changepassword(Request $request)
    {
      $data = $request->all();

      $user_id = auth()->user()->id;
      $user = User::where('id',$user_id)->first();
      if($user)
      {
        //$user->password = Hash::make(trim($request->password));
        $user->setPasswordAttribute($request->change_password);
        $user->save();
        try
        {
          $email = $user->email;
          $password=$request->change_password;
          $text='Email: '. $email .' <br/>'.'  Password: '. $password;
          $mail = new PHPMailer\PHPMailer();
          $mail->IsSMTP();

          $mail->CharSet = "utf-8";// set charset to utf8
          // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
          $mail->SMTPAuth = true; // authentication enabled
          $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
          $mail->Host = "smtp.gmail.com";
          $mail->Port = 587; // or 465
          $mail->Username = "testesatwat@gmail.com";
          $mail->Password = 'Esatwat@0000';
          $mail->SMTPOptions = array(
              'ssl' => array(
                  'verify_peer' => false,
                  'verify_peer_name' => false,
                  'allow_self_signed' => true
              )
          );

          $mail->isHTML(true);
          $mail->SetFrom(' info@dadreeios.com', 'Dadreeios');
          $mail->AddAddress($email);
          $mail->Subject = "Welcome to Dadreeios";
          $mail->Body = "
          <html>
          <head>

          </head>
          <body><div style='margin:auto;'><a href='http://dadreeios.com/'><img src='http://holyhanspariwar.com/public/images/holy-hans.png' width='120'></a></div>
          <h2 style='color:#333;'>Dadreeios</h2><h4 style='color:#333;'>Welcome, Your Password Changed Successfully!!!, Your Updated Login Credentials are here:: </h4>$text</body></html>
          ";
          $mail->Send();

        }
        catch (phpmailerException $e)
        {
          echo $e->errorMessage();
        }
        catch (Exception $e)
        {
          echo $e->getMessage();
        }
        return 'Password Changed Successfully !';
      }
      else
      {
        return 'Something went wrong';
      }


    }

    public function orders()
    {
      $user_id = Auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->with(['orderproducts'])->orderBy('order_id','DESC')->get();
      return view('frontend.orders.index',compact('orders'));
      // return redirect()->to('/myaccount/profile');
    }

    public function vieworders($id)
    {
      $user_id = Auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->where('order_id',$id)->with(['orderproducts','paymentinfo'])->first();
      $order_cancel = OrderCancelManagement::first();

      return view('frontend.orders.order_details',compact('orders','order_cancel'));
      // return redirect()->to('/myaccount/profile');
    }

    public function viewinvoice($id)
    {
      $user_id = Auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->where('order_id',$id)->with(['orderproducts'])->first();

      $company = Company::first();
      return view('frontend.orders.show',compact('orders','company'));
      // return redirect()->to('/myaccount/profile');
    }

    public function cancelorder($id)
    {
      $user_id = Auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->where('order_id',$id)->with('orderproducts')->first();
      if ($orders->cancel_order_flag==1)
      {
        return back()->with('error','Order already cancelled');
      }
      $reasons = OrderCancellationReasons::where('for_dadreeios',0)->get()->pluck('order_cancellation_reason_desc','order_cancellation_reason_id');
      return view('frontend.orders.cancel_order',compact('orders','reasons'));
      // return redirect()->to('/myaccount/profile');
    }

    public function cancelorderstatus(Request $request)
    {
      $id = $request->order_id;
      $user_id = auth()->user()->id;
      $this->validate(request(), [
        'order_id' => 'required',
        'order_cancellation_reason_id' => 'required',
        'confirm' => 'required',
      ]);
      // echo "string";exit;
      $date_time = date('Y-m-d h:i:s');
      $date_time = date('Y-m-d h:i:s', strtotime($date_time));

      $reasons = OrderCancellationReasons::where('order_cancellation_reason_id',$request->order_cancellation_reason_id)->first();
      $orders = Orders::where('user_id',$user_id)->where('order_id',$id)->with('orderproducts')->first();
      if ($orders->cancel_order_flag==1)
      {
        return back()->with('error','Order already cancelled');
      }
      $orders->cancel_order_flag = 1;
      $orders->cancel_order_date = $date_time;
      $orders->order_cancellation_reason_id = $reasons->order_cancellation_reason_id;
      $orders->cancel_reason = $reasons->order_cancellation_reason_desc;
      if($orders->fill($request->all())->update())//->update()
      {
        //cancel delivery order if exists
        if ($orders->package_order_status == 1)
        {
          if (isset($orders->package_waybill) && $orders->package_waybill != "")
          {
            $waybill = $orders->package_waybill;
            if($waybill != '')
            {
              $orderproduct_cancel = order_cancellation($waybill);
              $orderproduct_cancel = simplexml_load_string($orderproduct_cancel);
              $orderproduct_cancel = json_encode($orderproduct_cancel);
              $orderproduct_cancel = json_decode($orderproduct_cancel,true);
              // dd($orderproduct_cancel);
              if($orderproduct_cancel != null && $orderproduct_cancel['status']==true)
              {
                $orders->package_cancel_return_status = 1;
                $orders->package_cancel_return_dump = json_encode($orderproduct_cancel);
              }
              else
              {
                $orders->package_cancel_return_status = 0;
              }
            }
            $orders->update();
          }
        }
        return redirect()->to('myaccount/vieworders/'.$id)->with('success','Order Cancelled Successfully');
      }

    }

    public function orderscancel()
    {
      $user_id = Auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->with(['orderproducts'])->orderBy('order_id','DESC')->get();
      return view('frontend.orders.order_cancel',compact('orders'));
      // return redirect()->to('/myaccount/profile');
    }

    public function ordersreturn()
    {
      $user_id = Auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->with(['orderproducts'])->orderBy('order_id','DESC')->get();
      return view('frontend.orders.order_return',compact('orders'));
      // return redirect()->to('/myaccount/profile');
    }

    public function returnorder($id)
    {
      $user_id = Auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->where('order_id',$id)->with('orderproducts')->first();
      if ($orders->cancel_order_flag==1)
      {
        return back()->with('error','Order already returned');
      }
      $reasons = OrderReturnReasons::get()->pluck('order_return_reason_desc','order_return_reason_id');
      return view('frontend.orders.return_order',compact('orders','reasons'));
      // return redirect()->to('/myaccount/profile');
    }

    public function returnorderstatus(Request $request)
    {
      $id = $request->order_id;
      $user_id = auth()->user()->id;
      $this->validate(request(), [
        'order_id' => 'required',
        'order_return_reason_id' => 'required',
        'confirm' => 'required',
      ]);
      $date_time = date('Y-m-d h:i:s');
      $date_time = date('Y-m-d h:i:s', strtotime($date_time));

      // echo "string";exit;
      $reasons = OrderReturnReasons::where('order_return_reason_id',$request->order_return_reason_id)->first();
      $orders = Orders::where('user_id',$user_id)->where('order_id',$id)->first();
      if ($orders->cancel_order_flag==1)
      {
        return back()->with('error','Order already cancelled');
      }
      if ($orders->order_return_flag==1)
      {
        return back()->with('error','Order already returned');
      }
      // $orders->order_return_flag = 1;
      $orders->order_return_reason_id = $reasons->order_return_reason_id;
      $orders->order_return_reason_desc = $reasons->order_return_reason_desc;
      // $orders->order_return_date = $date_time;
      if($orders->fill($request->all())->update())
      {
        
        // return redirect()->to('myaccount/ordersreturn/')->with('success','Order Return request updated Successfully');
        // if($orders->payment_mode=='cod')
        // {
          return redirect()->to('myaccount/pickupaddress/'.$orders->order_id);//.'/'.$orders->shipping_address_id//->with('success','Order Return request updated Successfully');
        // }
        // elseif($orders->payment_mode == 'payumoney')
        // {
        //   return redirect()->to('myaccount/ordersreturn/')->with('success','Order Return request updated Successfully');
        // }
        // else
        // {
        //   return redirect()->to('myaccount/ordersreturn/')->with('success','Order Return request updated Successfully');
        // }
      }

    }

    public function pickupaddress($order_id)
    {
      $user_id = auth()->user()->id;
      $orders = Orders::where('user_id',$user_id)->where('order_id',$order_id)->first();
      $id = $orders->shipping_address_id;
      $shipping_address = ShippingAddresses::where('user_id',$user_id)->where('shipping_address_id',$id)->first();
      if(!isset($shipping_address))
      {
        $shipping_address = new ShippingAddresses();
      }
      $shipping_addresses = ShippingAddresses::where('user_id',$user_id)->get();
      return view('frontend.orders.pickupaddress',compact('shipping_address','order_id','orders','shipping_addresses'));
    }
    public function storeaddress(Request $request)
    {
      // dd('test');
      if(!auth()->user())
      {
        return back()->withErrors([
          'message' => 'Please login before Adding Address !'
        ])->with('error','Please login before Adding Address !');
      }
      $this->validate(request(), [
        'shipping_full_name' => 'required',
        'shipping_mobile_no' => 'required',
        'shipping_address_line1' => 'required',
        'shipping_address_line2' => 'required',
        'shipping_landmark' => 'required',
        'shipping_city' => 'required',
        'shipping_pincode' => 'required',
        'shipping_district' => 'required',
        'shipping_state' => 'required',
        'shipping_address_type' => 'required',
        'shipping_email' => 'required',
      ]);
  
      // dd($request->all());
      $shipping_address_id = $request->shipping_address_id;
      $order_id = $request->order_id;
      $user_id = auth()->user()->id;
      if(isset($shipping_address_id ) && $shipping_address_id != "")
      {
        $update_shipping_address = ShippingAddresses::where('user_id',$user_id)->where('shipping_address_id',$shipping_address_id)->first();
      }
      else
      {
        $update_shipping_address = new ShippingAddresses();
      }

      $update_shipping_address->fill($request->all());
      $update_shipping_address->user_id = $user_id;
  
      if (isset($request->default_address_flag) && $request->default_address_flag==1)
      {
        ShippingAddresses::where('user_id',$user_id)->update(['default_address_flag'=>0]);
      }
      else
      {
        $shipping_addresses = ShippingAddresses::where('user_id',$user_id)->where('shipping_address_id','!=',$shipping_address_id)->first();
        if (!$shipping_addresses)
        {
          $update_shipping_address->default_address_flag = 1;
        }
      }
  
      if ($update_shipping_address->save())
      {
        $orders=Orders::where('user_id',$user_id)->where('order_id',$order_id)->first();
        $orders->return_shipping_address_id = $update_shipping_address->shipping_address_id;
        $orders->return_shipping_full_name = $update_shipping_address->shipping_full_name;
        $orders->return_shipping_mobile_no = $update_shipping_address->shipping_mobile_no;
        $orders->return_shipping_address_line1 = $update_shipping_address->shipping_address_line1;
        $orders->return_shipping_address_line2 = $update_shipping_address->shipping_address_line2;
        $orders->return_shipping_landmark = $update_shipping_address->shipping_landmark;
        $orders->return_shipping_city = $update_shipping_address->shipping_city;
        $orders->return_shipping_pincode = $update_shipping_address->shipping_pincode;
        $orders->return_shipping_district = $update_shipping_address->shipping_district;
        $orders->return_shipping_state = $update_shipping_address->shipping_state;
        $orders->return_shipping_address_type = $update_shipping_address->shipping_address_type;
        $orders->return_shipping_email = $update_shipping_address->shipping_email;
        if($orders->payment_mode != 'cod')
        {
          $date_time = date('Y-m-d h:i:s');
          $date_time = date('Y-m-d h:i:s', strtotime($date_time));
          $orders->order_return_flag = 1;
          $orders->order_return_date = $date_time;
          $orders->update();
          return redirect()->to('/myaccount/ordersreturn/confirmation/'.$order_id)->with('success','Return order request placed Successfully !');
        }
        $orders->update();
        return redirect()->to('/myaccount/addbank/'.$order_id)->with('success','Address Updated Successfully !');
      }
      else
      {
        return back()->with('error','Something went Wrong !');
      }
    }

    public function addbank($order_id)
    {
      $user_id = Auth()->user()->id;
      $banks = Banks::where('user_id',$user_id)->get();
      // $banks = collect($banks)->mapWithKeys(function ($item, $key) {
      //   return [$item['bank_id'] => $item['bank_name']];
      // });
      return view ('frontend.orders.addbank',compact('order_id','banks'));
    }

    public function storebank(Request $request)
    {
      $this->validate(request(), [
        'customer_name' => 'required',
        'account_number' => 'required|confirmed',
        'bank_ifsc_code' => 'required',
        'branch_name' => 'required',
        'account_type' => 'required',
        'bank_name' => 'required',
      ]);
      $order_id = $request->order_id;
      unset($request->_token);
      // unset($request->order_id);
      $user_id = Auth()->user()->id;
      if(isset($request->bank_id) && $request->bank_id != "")
      {
        $addbank = Banks::where('user_id',$user_id)->where('bank_id',$request->bank_id)->first();
      }
      else
      {
        $addbank = new Banks();
      }
      // $addbank->customer_name = $request->customer_name;
      // $addbank->account_number = $request->account_number;
      // $addbank->bank_ifsc_code = $request->bank_ifsc_code;
      // $addbank->account_type = $request->account_type;
      // $addbank->Re_enter_account_number = $request->Re_enter_account_number;
      // $addbank->bank_name = $request->bank_name;
      // $addbank->branch_name = $request->branch_name;
      $addbank->fill($request->all());
      $addbank->user_id = $user_id;
      // dd($addbank);
      $addbank->save();
      $date_time = date('Y-m-d h:i:s');
      $date_time = date('Y-m-d h:i:s', strtotime($date_time));
      $orders=Orders::where('user_id',$user_id)->where('order_id',$order_id)->first();
      $orders->order_return_flag = 1;
      $orders->order_return_date = $date_time;
      $orders->bank_id = $addbank->bank_id;
      $orders->bank_ifsc_code = $addbank->bank_ifsc_code;
      $orders->branch_name = $addbank->branch_name;
      $orders->account_type = $addbank->account_type;
      $orders->bank_name = $addbank->bank_name;
      $orders->account_holder_name = $addbank->customer_name;
      $orders->account_number = $addbank->account_number;
      $orders->update();

      return redirect()->to('/myaccount/ordersreturn/confirmation/'.$order_id)->with('success','Return order request placed Successfully !');
    }
    public function confirmation($order_id)
    {
      return view ('frontend.orders.return_confirmation',compact('order_id'));
    }
    public function downloadInvoice($id)
    {
      $user_id = Auth()->user()->id;
      $orders=Orders::where('user_id',$user_id)->where('order_id',$id)->with('orderproducts')->first();
      $company = Company::first();
      $pdf=PDF::loadView('frontend.orders.downloadinvoice',['orders'=>$orders,'company'=>$company]);
      return $pdf->download('dadreeiosinvoice.pdf');
    }


}
