<?php

namespace App\Http\Controllers\frontend;



use App\Models\frontend\Users;
use App\Http\Controllers\Controller;


use App\Models\backend\Invoices;
use App\Models\backend\PaymentInfo;

class PaymentController extends Controller
{


    public function index()
    {
        $user_id = Auth()->user()->user_id;

        $customer_data = Users::where('user_id', $user_id)->first();

        $data = PaymentInfo::where('customer_id',$customer_data->contact_id)->orderByDesc('created_at')->get();
        // dd($data->get_items());
        return view('frontend.payment.index',compact('data'));
    }


    public function view($id)
    {
        $item = PaymentInfo::where('payment_id',$id)->first();
        // dd($item->get_items());
        return view('frontend.payment.view',compact('item'));
    }
}
