<?php

namespace App\Http\Controllers\frontend;



use App\Models\frontend\Users;
use App\Http\Controllers\Controller;


use App\Models\backend\Invoices;

class MyOrdersController extends Controller
{



    public function invoices()
    {

        $user_id = Auth()->user()->user_id;
        $customer_data = Users::where('user_id', $user_id)->first();
        $customerId = $customer_data->contact_id;

        $invoices = Invoices::where('customer_id', $customerId)->get();


        return view('frontend.myorders.invoice', compact('invoices'));
    }


    public function invoiceview($id)
    {
        $invoice = Invoices::where('invoice_id', $id)->first();
        // dd($invoice->item_data->name);
        return view('frontend.myorders.invoiceview', compact('invoice'));
    }


    public function orders()
    {

        $user_id = Auth()->user()->user_id;
        $customer_data = Users::where('user_id', $user_id)->first();
        $customerId = $customer_data->contact_id;


        $invoices = Invoices::where('customer_id', $customerId)->orderByDesc('created_at')->get();
        // dd($invoices);
        return view('frontend.myorders.orders', compact('invoices'));
    }


    public function ordersview($id)
    {

        $invoice = Invoices::where('invoice_id', $id)->first();
        // dd($invoice->item_data());
        return view('frontend.myorders.ordersview', compact('invoice'));
    }
}
