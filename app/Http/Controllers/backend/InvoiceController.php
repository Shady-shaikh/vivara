<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\backend\Invoices;
use App\Models\backend\Shipping;
use App\Models\backend\ShippingDetails;
use App\Models\frontend\User;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Carbon\Carbon;
use Exception as GlobalException;
use Session;

class InvoiceController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {


    $invoices = Invoices::with('shippingDetails')->orderByDesc('created_at')->get();
    //dd($invoices->toArray());

    return view('backend.invoices.index', compact('invoices'));
  }

  public function show($invoice_id)
  {


    $invoice = Invoices::where('invoice_id', $invoice_id)->first();
    //  dd($invoice);

    return view('backend.invoices.show', compact('invoice'));
  }


  public function shippingDetails($id){

    $invoice = Invoices::where('invoice_id', $id)->first();

    return view('backend.invoices.shipping',compact('invoice'));
  }

  // public function storeShippingDetails(Request $request,$id){
  //   //dd($request->all());
    
  //   //validate data
  //   $validatedData = $request->validate([
  //     'shipping_status' => 'required|in:pending,shipped,in_transit,out_for_delivery,cancelled,delivered',
  //     'order_tracking_no' => 'required|string|max:255',
  //     'remark' => 'nullable|string|max:255',
  //     'date' => 'required|date',
  //   ]);

  //   //dd($validatedData);
    

  //   // Check if a shipping detail already exists for the invoice ID
  //  // $existingShippingDetail = ShippingDetails::where('shipping_id', $id)->first();
  //  // dd($existingShippingDetail);



  //   //if already exists then we can't submit
  //   // if ($existingShippingDetail) {
  //   //   return redirect()->back()->with('error', 'A shipping detail already exists for this invoice ID.');
  //   // }

  //   // Create a new shipping detail record
  //   $shippingDetail = new ShippingDetails();
    
  //   // //for invoice id
  //   $invoiceId = $request->input('invoice_id');
  //   //dd($invoiceId);
  //   $invoice = Invoices::where('invoice_id',$invoiceId)->first();
  //   //dd($invoice);


  //   $shippingDetail->invoice_id = $invoice->invoice_id;
  //   $shippingDetail->shipping_status = $validatedData['shipping_status'];
  //   $shippingDetail->order_tracking_no = $validatedData['order_tracking_no'];
  //   $shippingDetail->remark = $validatedData['remark'];
  //   $shippingDetail->date = $validatedData['date'];
  //   $shippingDetail->save();

  //   return redirect()->back()->with('success', 'Shipping details have been successfully added.');

  // }


  public function storeShippingDetails(Request $request, $id) {
    // Validate data
    $validatedData = $request->validate([
        'shipping_status' => 'required|in:pending,shipped,in_transit,out_for_delivery,cancelled,delivered',
        'order_tracking_no' => 'required|string|max:255',
        'tracking_url' => 'nullable',
        'remark' => 'nullable|string|max:255',
        'expected_delivery_date' => 'required|date',
        'delivery_date' => 'nullable|date',
    ]);
    
    // Retrieve invoice_id from the request
    $invoiceId = $request->input('invoice_id');
    //dd($invoiceId);

    // Check if a shipping detail already exists for the invoice ID
    $existingShippingDetail = ShippingDetails::where('invoice_id', $invoiceId)->first();
    //dd($existingShippingDetail);

    // If a shipping detail already exists for the invoice ID, don't submit the form
    if ($existingShippingDetail) {
        return redirect()->back()->with('error', 'A shipping detail already exists for this invoice ID.');
       // return view('backend.invoices.shippingupdate', compact('existingShippingDetail'));
      //  return redirect()->route('admin.invoice.shippingdetails.edit',['id'=>$existingShippingDetail->invoice_id,'shipping_id'=>$existingShippingDetail->shipping_id]);


    }

    // Create a new shipping detail record
    $shippingDetail = new ShippingDetails();

    // Assign values to the shipping detail
    $shippingDetail->invoice_id = $invoiceId;
    $shippingDetail->shipping_status = $validatedData['shipping_status'];
    $shippingDetail->order_tracking_no = $validatedData['order_tracking_no'];
    $shippingDetail->tracking_url = $validatedData['tracking_url']??null;
    $shippingDetail->remark = $validatedData['remark'];
    $shippingDetail->expected_delivery_date = $validatedData['expected_delivery_date'];
    $shippingDetail->delivery_date = $validatedData['delivery_date'];
    $shippingDetail->save();

    //fetch users email
    $invoice = Invoices::where('invoice_id',$invoiceId)->first();
    //dd($invoice);
    $user = $invoice->customer_data;
    //dd($user);
    $usersEmail = $user->email;
    //dd($usersEmail);

    //send email to user 
    $subject = 'Shipping Status';
    $body = "Dear customer your order is {$shippingDetail->shipping_status} 
             Order Tracking no : {$shippingDetail->order_tracking_no}
             Order Tracking url : {$shippingDetail->tracking_url}
             Remark : {$shippingDetail->remark}
             Date : {$shippingDetail->expected_delivery_date}";

    if ($this->sendShippingDetails($usersEmail, $subject, $body)){
      return redirect()->back()->with('success', 'Shipping details have been successfully added and email sent.');
    }else{
      return redirect()->back()->with('error', 'Failed to send email notification.');
    }         
    
    return redirect()->back()->with('success', 'Shipping details have been successfully added.');
} 

  public function sendShippingDetails($toEmail,$subject,$body){

    //initialize php mailer
    $mail = new PHPMailer(true);

    try{
      //server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'nikhilp@parasightsolutions.com';
      $mail->Password = 'Nick@1412';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;

      // Sender and recipient settings
      $mail->setFrom('nikhilp@parasightsolutions.com', 'Vivara');
      $mail->addAddress($toEmail);

      // Sending plain text email
      $mail->isHTML(true); // Set email format to plain text
      $mail->Subject = $subject;
      $mail->Body    = $body;

      $mail->send();
      return true;

    }catch (Exception $e){
      return false;
    }
  }

  public function updateStatus($id, $shipping_id){
   
    $invoice = Invoices::where('invoice_id', $id)->first();
    //dd($invoice);
    $shipping_details = ShippingDetails::where('shipping_id',$shipping_id)->first();
    //dd($shipping_details);

    return view('backend.invoices.shippingupdate',compact('invoice','shipping_details'));
  }

  
  public function updateShippingDetails(Request $request,$id,$shipping_id){
    //dd($request->all());
    //validate data
    $validatedData = $request->validate([
      'shipping_status' => 'required|in:pending,shipped,in_transit,out_for_delivery,cancelled,delivered',
      'tracking_url' => 'nullable',
      'remark' => 'nullable|string|max:255',
      'delivery_date' => 'nullable|date',
  ]);
   // dd($validatedData);

    //find the existing shipping detail by its id
    //$shippingdetails = ShippingDetails::findOrFail($shipping_id);
    //dd($shippingdetails);
    $shippingdetail = ShippingDetails::where('shipping_id',$shipping_id)->first();
   // dd($shippingdetail);

   //update shipping details with new data
   $shippingdetail->shipping_status = $validatedData['shipping_status'];
   $shippingdetail->tracking_url = $validatedData['tracking_url'];
   $shippingdetail->remark = $validatedData['remark'];
   $shippingdetail->delivery_date = $validatedData['delivery_date'];
   $shippingdetail->save();

   $invoice = Invoices::where('invoice_id',$id)->first();
   //dd($invoice);
   $user = $invoice->customer_data;
   //dd($user);
   $usersEmail = $user->email;
   //dd($usersEmail);

   //send email to user 
   $subject = 'Shipping Status';
   $body = "Dear customer your order is {$shippingdetail->shipping_status} 
            Order Tracking no : {$shippingdetail->order_tracking_no}
            Order Tracking url : {$shippingdetail->tracking_url}
            Remark : {$shippingdetail->remark}
            Expected Delivery Date : {$shippingdetail->expected_delivery_date}";

   if ($this->sendShippingDetails($usersEmail, $subject, $body)){
        return redirect()->back()->with('success', 'Shipping details have been successfully added and email sent.');
      }else{
        return redirect()->back()->with('error', 'Failed to send email notification.');
      }                 

   //redirect with message
   return redirect()->back()->with('success','shipping details updated successfully');

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
