<?php

namespace App\Http\Controllers\frontend;



use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use App\Models\frontend\Users;
use App\Http\Controllers\Controller;
use App\Models\backend\Cart;
use App\Models\backend\Coupons;
use App\Models\backend\Invoices as BackendInvoices;
use App\Models\backend\ItemImages;
use App\Models\backend\Items;
use App\Models\backend\MissingPayments;
use App\Models\backend\PaymentInfo;
use App\Models\backend\Shipping;
use App\Models\backend\Schemes;
use App\Models\frontend\Address;
use App\Models\Rolesexternal;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FacadesSession;
use phpmailerException;
use Session;
use Webleit\ZohoBooksApi\Models\CustomerPayment;
use Webleit\ZohoBooksApi\Modules\CustomerPayments;
// use Webleit\ZohoBooksApi\Modules\Settings\Invoices;
use Webleit\ZohoBooksApi\Modules\Invoices;
use Webleit\ZohoBooksApi\Modules\Items as ModulesItems;
use Webleit\ZohoBooksApi\Modules\Settings;
use Webleit\ZohoBooksApi\Modules\Settings\Countries;
use Webleit\ZohoBooksApi\ZohoBooks;

class ProductsController extends Controller
{




    public function index($id = null)
    {



        if (!empty($_GET)) {

            // $category = $_GET['category'];
            // $color = $_GET['color'];
            // $packet = $_GET['packet'];


            // // dd($_GET);
            // if ((!empty($category) && strpos($category, ':') == false) && (!empty($color) && strpos($color, ':') == false) && (!empty($packet) && strpos($packet, ':') == false)) {
            //     $availableItems = Items::where(['category' => $category, 'variant' => $color])->with('get_offers')->get();
            // } elseif ((!empty($category) && strpos($category, ':') == false) && (!empty($color) && strpos($color, ':') == false)) {
            //     $availableItems = Items::where(['category' => $category, 'variant' => $color])->with('get_offers')->get();
            // } elseif ((!empty($category) && strpos($category, ':') == false)) {
            //     $availableItems = Items::where(['category' => $category])->with('get_offers')->get();
            // } elseif (!empty($color) && strpos($color, ':') == false) {
            //     $availableItems = Items::where(['variant' => $color])->with('get_offers')->get();
            // }else{
            //     $availableItems = Items::with('get_offers')->get();
            // }
            $conditions = [];

            $category = $_GET['category'];
            $color = $_GET['color'];
            $packet = $_GET['packet'];

            if (!empty($category) && strpos($category, ':') === false) {
                $conditions['category'] = $category;
            }

            if (!empty($color) && strpos($color, ':') === false) {
                $conditions['variant'] = $color;
            }

            // if (!empty($packet) && strpos($packet, ':') === false) {
            //     $conditions['packet'] = $packet;
            // }

            // Build the query dynamically based on conditions
            $query = Items::with('get_offers');

            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }

            $availableItems = $query->get();


            return view('frontend.products.index', compact('availableItems'));
        }


        if (!empty($id)) {
            $availableItems = Items::where('category', $id)->with('get_offers')->get();
        } else {
            $availableItems = Items::with('get_offers')->get();
        }
        // dd($availableItems);
        return view('frontend.products.index', compact('availableItems'));
    }

    public function update(Request $request)
    {
        // $availableItems = Items::where('item_id')get();
        return view('frontend.products.index', compact('availableItems'));
    }




    public function view($id)
    {
        $item = Items::where('item_id', $id)->first();

        $item_images = [];
        if (!empty($item)) {
            $group_data = ItemImages::where('item_id', $item->item_id)->first();
            // dd($group_data);
            if (!empty($group_data)) {
                $item_images = explode(',', $group_data->image_name);

            }else{
                $item_images[] = $item->item_image;
            }
        }

        return view('frontend.products.view', compact('item', 'item_images'));
    }

    public function purchase(Request $request, $check, $id)
    {

        $user_id = Auth()->user()->user_id;

        $customer_data = Users::where('user_id', $user_id)->first();
        $quantity = 1;
        if (!empty($request->quantity)) {
            $quantity = $request->quantity;
        }

        $item_details = Items::where(['item_id' => $id])->first();
        $user_details = Users::where(['contact_id' => $customer_data->contact_id])->first();
        $increment_id = substr(md5(microtime()), rand(0, 20), 20);

        $avail_item_count = Items::where('item_id', $id)->first();
        if (1 > $avail_item_count->stock_on_hand) {
            return redirect()->route('products.index')->with('error', 'Only ' . $avail_item_count->stock_on_hand . ' stock is available for Item ' . $avail_item_count->name . '!');
        }

        //for address validation
        $address_data = Address::where('contact_id', $customer_data->contact_id)->first();
        if (empty($address_data)) {
            return redirect()->route('products.index')->with('error', 'Note: Please Add Addresses Before Purchasing Any Item');
        }



        return view('frontend.products.payment.index', compact('user_details', 'check', 'item_details', 'increment_id', 'quantity'));
    }


    //pay u money

    public function payment(Request $request, $id, $item_id = null)
    {
        // echo $course_id;die;
        $user_id = Auth()->user()->user_id;
        $user_details = Users::where(['contact_id' => $id])->orWhere('user_id', $user_id)->first();


        $post_data = $request->all();
        // dd($post_data);

        $transaction_id = "";

        $transaction_id = $post_data['txnid'];
        $this->addMissingPayment($post_data, $transaction_id);

        $cart_amount = $request->amount;

        return view('frontend.products.payment.payment', compact('user_details', 'cart_amount'));
    }

    public function payment_success(Request $request)
    {
        // echo "<pre>";
        // print_r($_POST);
        // die;


        $status = 'complete';
        $firstname = $request->firstname;
        $amount = $request->amount;
        $txnid = $request->txnid;
        $email = $request->email;
        $student_id = $request->udf1;
        $course_id = $request->udf2;
        $discount = $request->udf3;
        $check = $request->udf4;
        $shipping_charges = $request->udf5;

        $date_time = $request->addedon;
        //  dd($check);

        $payment_tracking_code = substr(md5(microtime()), rand(0, 20), 20);
        // check if payment exist for the current transaction id
        $existing_payment = PaymentInfo::where(['transaction_id' => $txnid])->first();
        if (!$existing_payment) // if not
        {
            $items = explode(",", $course_id);
            // create invoice and update payment
            $line_items = [];
            $quantity = 1;

            // dd($items);
            foreach ($items as $key => $val) {

                $items_data = Cart::where(['item_id' => $val, 'paid_status' => 0, 'contact_id' => $student_id])->with('get_items')->first();
                // dd($items_data);
                if (empty($items_data)) {
                    $items_data = Items::where('item_id', $val)->first();
                }
                $rate =  $items_data->get_items[0]['rate'] ?? $items_data->rate;
                $description =  $items_data->get_items[0]['description'] ?? $items_data->description;
                $offer_id =  $items_data->get_items[0]['offer'] ?? $items_data->offer;

                // dd($items_data);
                $offers = Schemes::where('schemes_id', $offer_id)->first();
                // dd($check);
                if ($check == 'c') {

                    $quantity = $items_data->quantity;
                    if (!empty($offers) && $offers->min_product_qty <= $quantity) {

                        $line_item = [
                            'item_id' => $val,
                            'rate' => $rate,
                            'quantity' => $quantity,
                            'description' => $description ?? '',
                        ];
                        $line_items[] = $line_item;

                        $quantity = $offers->free_product_qty;
                        $line_item = [
                            'item_id' => $val,
                            'rate' => 0,
                            'quantity' => $quantity,
                            'description' => $description ?? '',
                        ];
                        $line_items[] = $line_item;
                    } else {
                        $line_item = [
                            'item_id' => $val,
                            'rate' => $rate,
                            'quantity' => $quantity,
                            'description' => $description ?? '',
                        ];
                        $line_items[] = $line_item;
                    }
                } else if ($check == 'd') {

                    if (!empty($offers) && $offers->min_product_qty == 1) {
                        // $quantity = 2;
                        $line_item = [
                            'item_id' => $val,
                            'rate' => $rate,
                            'quantity' => 1,
                            'description' => $description ?? '',
                        ];
                        $line_items[] = $line_item;
                        $s_line_item = [
                            'item_id' => $val,
                            'rate' => 0,
                            'quantity' => 1,
                            'description' => $description ?? '',
                        ];
                        $line_items[] = $s_line_item;
                    } else {
                        $line_item = [
                            'item_id' => $val,
                            'rate' => $rate,
                            'quantity' => 1,
                            'description' => $description ?? '',
                        ];

                        $line_items[] = $line_item;
                    }
                }
            }

            // dd($line_items);



            $currentDate = date('Y-m-d');
            $futureDate = date('Y-m-d', strtotime('+15 days', strtotime($currentDate)));

            //insert invoice into zoho
            $zohoClient = get_zoho_client();
            $invoices = new Invoices($zohoClient);

            $invoiceData = [
                'customer_id' => $student_id,
                'date' => date('Y-m-d'),
                'due_date' => $futureDate,
                'balance ' => 0,
                'is_discount_before_tax' => false,
                'discount_type' => 'entity_level',
                'discount' => $discount,
                'discount_total' => $discount,
                'discount_amount' => $discount,
                'line_items' => $line_items,
                'shipping_charge' => $shipping_charges,
                // need to adjust free item with tax how ? .
                // 'adjustment'=>
            ];
            // dd($invoiceData);

            try {
                $newInvoice = $invoices->create($invoiceData);
            } catch (Exception $e) {
                // dd($e);
                return redirect()->route('products.index')->with('error', 'Something went wrong, Please try again!!!');
            }

            // dd($newInvoice);
            //make payment against that invoice
            if ($newInvoice) {

                $invoice_items = "";
                $rates = "";
                $qunats = "";

                //insert invoice into database
                $model = new BackendInvoices();
                $model->invoice_id = $newInvoice->invoice_id;
                $model->invoice_number = $newInvoice->invoice_number;
                $model->customer_id = $newInvoice->customer_id;
                $model->date = $newInvoice->date;
                $model->due_date = $newInvoice->due_date;
                foreach ($newInvoice->line_items as $key => $val) {
                    $invoice_items .= $newInvoice->line_items[$key]['item_id'] . ",";
                    $rates .= $newInvoice->line_items[$key]['rate'] . ",";
                    $qunats .= $newInvoice->line_items[$key]['quantity'] . ",";
                }

                $model->item_id = $invoice_items;
                $model->rate = $rates;
                $model->quantity = $qunats;
                $model->discount = $discount;
                $model->shipping_charges = $shipping_charges;
                $model->total = $newInvoice->total;
                $model->balance = 0;
                $model->current_sub_status = 'paid';
                $model->save();


                $update_invoice = BackendInvoices::where('invoice_id', $newInvoice->invoice_id)->first();
                $update_invoice->tax_amount  = $newInvoice->bcy_tax_total;
                $update_invoice->save();

                //insert paymnet received in zoho books
                $zohoClient = get_zoho_client();
                $payment = new CustomerPayments($zohoClient);

                $paymentData = [
                    'customer_id' => $newInvoice->customer_id,
                    'payment_mode' => 'Online',
                    'amount' => $newInvoice->total,
                    'date' => $newInvoice->date,
                    'reference_number' => $newInvoice->invoice_number,
                    'is_emailed' => true,
                    'invoices' => [
                        [
                            'invoice_id' => $newInvoice->invoice_id,
                            'amount_applied' => $newInvoice->total,
                        ],
                    ],
                ];


                try {
                    $payment_done = $payment->create($paymentData);

                    //update any data of an item to trigger
                    $zohoClient = get_zoho_client();
                    $itemsApi = new \Webleit\ZohoBooksApi\Modules\Items($zohoClient);

                    $updateData = [
                        'status' => 'active',
                    ];
                    foreach ($newInvoice->line_items as $key => $val) {
                        $itemId = $newInvoice->line_items[$key]['item_id'];
                        $itemsApi->update($itemId, $updateData);
                    }
                } catch (Exception $e) {
                    $model = BackendInvoices::where('invoice_id', $newInvoice->invoice_id)->first();
                    $model->delete();

                    return redirect()->route('products.index')->with('error', 'Something went wrong, Please try again!');
                }
            }
            // dd($payment_done);


            if ($payment_done) {
                //insert payment details into database
                $payment_info = new PaymentInfo();
                $payment_info->payment_id = $payment_done->payment_id;
                $payment_info->status = $status;
                $payment_info->customer_id = $payment_done->customer_id;
                $payment_info->invoice_id = $payment_done->invoices[0]['invoice_id'];
                $payment_info->item_id = $course_id;
                $payment_info->email = $email;
                $payment_info->customer_name = $payment_done->customer_name;
                $payment_info->transaction_id = $txnid;
                $payment_info->amount = $payment_done->amount;
                $payment_info->payment_date = date('Y-m-d H:m:s');
                $payment_info->payment_mode = $payment_done->payment_mode;
                $payment_info->data_dump = json_encode($_POST);
                $payment_info->payment_tracking_code = $payment_tracking_code;
                if ($payment_info->save()) {

                    // update cart response after payment
                    if ($check == 'c') {
                        Cart::whereIn('item_id', $items)
                            ->where('contact_id', $student_id)
                            ->update(['paid_status' => 1]);
                    }


                    $invoice_id = $payment_done->invoices[0]['invoice_id'];
                    $org_id = env('ZOHO_ORGANIZATION_ID');
                    $auth_totken = get_authorized_access_token();

                    //update invoice
                    $send_invoice = [
                        'status' => 'sent',
                        'is_emailed' => true,
                        'contact_persons' => [
                            $newInvoice->contact_persons_details[0]['contact_person_id'],
                        ],
                    ];
                    $invoices->update($invoice_id, $send_invoice);



                    //send invoice
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://www.zohoapis.in/books/v3/invoices/' . $invoice_id . '/email?organization_id=' . $org_id . '',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Zoho-oauthtoken ' . $auth_totken . '',
                            'Cookie: BuildCookie_60022231474=1; 54900d29bf=4216ff12b81b653e886742646e609299; JSESSIONID=C80298BBD9EBA552B1C1DB062894C21D; _zcsr_tmp=c92dfe57-e93a-4990-9351-88dbcfa72d63; zbcscook=c92dfe57-e93a-4990-9351-88dbcfa72d63'
                        ),
                    ));

                    curl_exec($curl);


                    $missing_payments = MissingPayments::where(['user_id' => $payment_info->customer_id, 'transaction_id' => $payment_info->transaction_id, 'email' => $payment_info->email])->first();
                    // echo "<pre>";print_r($missing_payments->toArray());die;
                    $missing_payments->payu_response = 'Y';
                    $missing_payments->data_dump = $payment_info->data_dump;
                    $missing_payments->save();

                    return view('frontend.products.payment.success');
                }
            } else {
                return view('frontend.products.payment.failure');
            }
        } // end existing payment validation block
        else {
            // echo "not exists";die;
            // Yii::$app->session->setFlash('error', 'Payment Has Been Made Already!');
            // return $this->redirect('@web/students/view?id=' . $_POST['udf1']);
        }
    }

    public function payment_failure(Request $request)
    {
        // echo $_POST['hash'];die;
        $status = 'failure';
        $firstname = $request->firstname;
        $amount = $request->amount;
        // echo $amount;die;
        $txnid = $request->txnid;
        $productinfo = $request->productinfo;
        $email = $request->email;
        // $student_id = $_POST['udf1'];
        $date_time = $request->addedon;
        $missing_payments = MissingPayments::where(['transaction_id' => $txnid, 'email' => $email])->first();
        if ($missing_payments) :
            $missing_payments->payu_response = 'N';
            $missing_payments->status = "Failure";
            $missing_payments->data_dump = json_encode($_POST);
            $missing_payments->save();
        endif;
        return view('frontend.products.payment.failure');
    }



    public function checkout($check, $data)
    {


        $user_id = Auth()->user()->user_id;
        $customer_data = Users::where('user_id', $user_id)->first();

        $item_data = $data;
        $data = explode(",", $data);
        // dd($data);
        $item = Cart::whereIn('item_id', $data)->where(['contact_id' => $customer_data->contact_id, 'paid_status' => 0])->get();

        // dd($item);
        $increment_id = substr(md5(microtime()), rand(0, 20), 20);


        //validation stock availability
        foreach ($item as $row) {
            $avail_item_count = Items::where('item_id', $row->item_id)->first();
            if ($row->quantity > $avail_item_count->stock_on_hand) {
                return redirect()->route('cart.index')->with('error', 'Only ' . $avail_item_count->stock_on_hand . ' stock is available for Item ' . $avail_item_count->name . '!');
            }
        }

        //for address validation
        $address_data = Address::where('contact_id', $customer_data->contact_id)->first();
        if (empty($address_data)) {
            return redirect()->route('cart.index')->with('error', 'Note: Please Add Addresses Before Purchasing Any Item');
        }

        return view('frontend.products.checkout', compact('item', 'check', 'customer_data', 'item_data', 'increment_id'));
    }

    public function oauth_callback()
    {
        $model = Coupons::where('coupon_id', 3)->first();
        $model->copoun_desc  = '$request';
        $model->save();
    }

    public function getdiscountedamount(Request $request)
    {
        // dd($request->all());

        $coupons = Coupons::where('status', 0)->where('coupon_code', trim($request->coupon))->first();
        $discount = 0;

        if (!empty($coupons)) {
            if ($coupons->coupon_purchase_limit > $request->amount) {
                return redirect()->back()->with('error', 'Not Enough Amout For This Coupon!');
            } else if ($coupons->start_date >  date('Y-m-d') || $coupons->end_date <  date('Y-m-d')) {
                return redirect()->back()->with('error', 'This coupon is expired!');
            } else {
                if ($coupons->coupon_type == 'flat') {
                    $data =  $request->amount - $coupons->value;
                    $discount = $coupons->value;
                } else {
                    $data =  ($request->amount / 100) * $coupons->value;
                    $discount = $data;
                    $data = round($request->amount - $data, 2);
                }
            }

            return redirect()->back()->with('success', 'Coupon Applied!')->with(['data' => $data, 'code' => $request->coupon, 'discount' => $discount]);
        } else {
            return redirect()->back()->with('error', 'Coupon code is invalid!');
        }
    }

    public function getshipcharge(Request $request)
    {
        // dd($request->id);

        $shipping = Shipping::where('shipping_method_id', $request->id)->first();
        // $update_ship_method = Users::where('user_id',$request->user_id)->first();
        // $update_ship_method->shipping_id = $request->id;
        $data = [];

        if (!empty($shipping)) {
            $data = [
                'ship_cost' => $shipping->shipping_method_cost,
                'final_amount' => $request->final_amount + $shipping->shipping_method_cost
            ];
            $data = json_encode($data);
            return $data;
        } else {
            return redirect()->back()->with('error', 'Coupon code is invalid!');
        }
    }


    public function addMissingPayment($post_data, $transaction_id)
    {

        $payment_info = new MissingPayments();
        $payment_info->status = 'initiated';
        $payment_info->user_id = $post_data['udf1'];
        $payment_info->email = $post_data['email'];
        $payment_info->customer_name = $post_data['firstname'];
        $payment_info->transaction_id = $transaction_id;
        $payment_info->amount = $post_data['amount'];
        $payment_info->payment_date = date('Y-m-d H:m:s');
        $payment_info->data_dump = json_encode($post_data);
        $payment_info->save();
        return;
    }

    public function get_same_group_item(Request $request)
    {
        $group_id = $request->group_id ?? '';
        $color = $request->color ?? '';
        $size = $request->size ?? '';
        $image_id = $request->image_id ?? '';

        // dd($group_id, $color, $size, $image_id);

        $query = Items::where('group_id', $group_id)->with('get_group');

        if (!empty($color)) {
            $query->where('variant', $color);
        }

        if (!empty($size)) {
            $query->where('size', $size);
        }

        if (!empty($image_id)) {
            $query->where('item_image', $image_id);
        }

        $item = $query->first();



        if (empty($item)) {
            return false;
        } else {
            return response()->json($item);
        }
    }

    public function get_item_images(Request $request){

        $item_id = $request->item_id ?? '';
        $query = ItemImages::where('item_id', $item_id);

        $item = $query->first();

        if (empty($item)) {
            return false;
        } else {
            return response()->json($item);
        }
    }
}
