<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\backend\Shipping;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Webleit\ZohoBooksApi\Client;
use Webleit\ZohoBooksApi\ZohoBooks;
use Webleit\ZohoBooksApi\Modules\Invoices;
use Webleit\ZohoBooksApi\Modules\Settings\Taxes;

class GstController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

    $client = get_zoho_client();
    $zohoBooks = new ZohoBooks($client);

    $taxesModule = new Taxes($client);
    $taxes = $taxesModule->getList();

    return view('backend.gst.index', compact('taxes'));
  }

  public function show($tax_id)
  {
    $client = get_zoho_client();
    $taxesModule = new Taxes($client);
    // Retrieve the tax data
    $tax = $taxesModule->get($tax_id);
    // dd($tax);

    return view('backend.gst.show', compact('tax'));
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
