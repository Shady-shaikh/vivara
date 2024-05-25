<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\backend\Invoices;
use App\Models\backend\Shipping;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class Reports extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        // dd($request->all());
        $today = Carbon::today();
        $invoices = Invoices::where('id', '=', 0)->get();

        // $invoices = Invoices::whereDate('date', $today)->get();

        $data = [
            "daterange" => "07/14/2023 - 07/15/2023"
        ];
        $startDate = '';
        $endDate = '';

        $daterange = $request->daterange;
        $customer_name = $request->customer_name;

        $dates = explode(" - ", $daterange);
        if (!empty($daterange)) {
            $startDate = date("Y-m-d", strtotime($dates[0])); // Format first date
            $endDate = date("Y-m-d", strtotime($dates[1])); // Format second date
        }


        if (!empty($daterange) && !empty($customer_name)) {

            $invoices = Invoices::with('customer_data')
                ->whereHas('customer_data', function ($query) use ($customer_name) {
                    $query->where('name', 'LIKE', '%' . $customer_name . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $customer_name . '%');
                })->whereBetween('date', [$startDate, $endDate])
                ->orderByDesc('created_at')->get();
        } else if (!empty($daterange)) {
            $invoices  = Invoices::whereBetween('date', [$startDate, $endDate])->orderByDesc('created_at')
                ->get();
        } else if (!empty($customer_name)) {
            $invoices = Invoices::with('customer_data')
                ->whereHas('customer_data', function ($query) use ($customer_name) {
                    $query->where('name', 'LIKE', '%' . $customer_name . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $customer_name . '%');
                })->orderByDesc('created_at')->get();
        }




        return view('backend.reports.index', compact('invoices'));
    }

    public function show($invoice_id)
    {


        $invoice = Invoices::where('invoice_id', $invoice_id)->first();
        //  dd($invoice);

        return view('backend.reports.show', compact('invoice'));
    }

    // public function store(Request $request)
    // {
    //   // dd($request->all());
    //   $this->validate(request(), [
    //     'shipping_method_name' => 'required',
    //     'shipping_method_code' => 'required',
    //     'shipping_method_status' => 'required',
    //     'shipping_method_cost' => 'required|integer',
    //   ]);

    //   Shipping::create($request->all());

    //   Session::flash('success', 'Shipping Added!');
    //   Session::flash('status', 'success');

    //   return redirect('admin/shipping');
    // }

    // public function create()
    // {
    //   return view('backend.shipping.create');
    // }


    // public function edit($id)
    // {
    //   $shipping = Shipping::findOrFail($id);

    //   return view('backend.shipping.edit', compact('shipping'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    // public function update( Request $request)
    // {
    //   $this->validate(request(), [
    //     'shipping_method_name' => 'required',
    //     'shipping_method_code' => 'required',
    //     'shipping_method_status' => 'required',
    //     'shipping_method_cost' => 'required|integer',
    //   ]);

    //   if ($request->shipping_method_status == 1) {
    //     //$affected = DB::table('shipping')->update(array('shipping_method_status' => 0));
    //     Shipping::query()->update(['shipping_method_status' => 0]);
    //   }
    //   $shipping = Shipping::findOrFail($request->shipping_method_id);
    //   $shipping->update($request->all());

    //   Session::flash('success', 'Shipping updated!');
    //   Session::flash('status', 'success');

    //   return redirect('admin/shipping');
    // }


    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  *
    //  * @return Response
    //  */

    //  public function destroy($id)
    //  {
    //      $schemes = Shipping::findOrFail($id);

    //      $schemes->delete();

    //      Session::flash('success', 'Shipping deleted!');
    //      Session::flash('status', 'success');

    //      return redirect('admin/shipping');
    //  }

}
