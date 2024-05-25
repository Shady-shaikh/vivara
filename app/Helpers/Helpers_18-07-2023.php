<?php

use PHPMailer\PHPMailer;
use App\Models\frontend\Cart;
use App\Models\backend\Company;
use Illuminate\Support\Facades\DB as FacadesDB;
// use App\Models\frontend\Orders;
use App\Models\frontend\Orders;
use App\Models\backend\Location;
use App\Models\backend\StateCodes;
use Spatie\Permission\Models\Role;
use App\Models\backend\ActivityLog;
use App\Models\backend\AdminNotification;
use App\Models\backend\AdminUsers;
use App\Models\backend\Designation;
use App\Models\frontend\Department;
use App\Models\frontend\CartCoupons;
use Illuminate\Support\Facades\Session;
use App\Models\backend\OrderCancelManagement;
use App\Models\backend\OrderReturnManagement;
use App\Models\frontend\Notification;
use App\Models\frontend\Users;
use Carbon\Carbon;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerPHPMailer;
use Weble\ZohoClient\OAuthClient;
use Webleit\ZohoBooksApi\Client;

if (!function_exists('get_shipping_charges')) {
  // $md(string) : modeBilling mode of shipment(E: Express/ S: Surface)(mandatory)
  // $cgm(int32) : Weight of shipment in grams(Mandatory)
  // $o_pin(int32) : Origin center's Pin Code (optional)
  // $d_pin(int32) : Pin code of destination city (optional)
  // $ss(string) : Status of shipment Delivered,RTO,DTO(Mandatory)

  function get_shipping_charges($md, $cgm, $o_pin, $ss, $d_pin)
  {
    // dd($cgm);
    $accesstoken = 'c7bd1bd7f2ed46a36775d63e8c9ee43617ffee49';
    $url = "https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?md=" . $md . "&cgm=" . $cgm . "&=" . $o_pin . "&ss=" . $ss . "&d_pin=" . $d_pin;
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
  }
}

//cart total
//discounted price total
if (!function_exists('get_cart_total')) {
  function get_cart_total()
  {
    $cart_total = new stdClass();
    $total = 0;
    $mrp_total = 0;
    if (isset(auth()->user()->id)) {
      $user_id = auth()->user()->id;
      if ($user_id) {
        // $cart_total = Cart::where('user_id',$user_id)->with(['products'])->select(DB::raw('sum(products.product_discounted_price*cart.qty) as cart_total'))->first();
        // $cart_total = Cart::where('user_id',$user_id)->join('products', 'products.product_id', '=', 'cart.product_id')->select(DB::raw('sum(products.product_discounted_price*cart.qty) as cart_total'))->first();
        $cart = Cart::where('user_id', $user_id)->with(['products', 'product_variant'])->get();
        foreach ($cart as $item) {
          $join_table = 'products';
          if ($item->product_type == "configurable") {
            $join_table = 'product_variant';
          }
          $total += $item->{$join_table}->product_discounted_price * $item->qty;
        }
      }
    }
    $cart_total->cart_total = $total;
    return $cart_total;
  }
}

if (!function_exists('get_cart_mrp_total')) {
  function get_cart_mrp_total()
  {
    $cart_total = new stdClass();
    // $cart_total;
    $total = 0;
    if (isset(auth()->user()->id)) {
      $user_id = auth()->user()->id;
      if ($user_id) {
        // $cart_total = Cart::where('user_id',$user_id)->with(['products'])->select(DB::raw('sum(products.product_discounted_price*cart.qty) as cart_total'))->first();
        // $cart_total = Cart::where('user_id',$user_id)->join('products', 'products.product_id', '=', 'cart.product_id')->select(DB::raw('sum(products.product_price*cart.qty) as cart_total'))->first();
        $cart = Cart::where('user_id', $user_id)->with(['products', 'product_variant'])->get();
        foreach ($cart as $item) {
          $join_table = 'products';
          if ($item->product_type == "configurable") {
            $join_table = 'product_variant';
          }
          if ($item->{$join_table}->product_discounted_price != null && $item->{$join_table}->product_discount != 0) {
            $total += $item->{$join_table}->product_price * $item->qty;
          } elseif ($item->{$join_table}->product_discounted_price != null && $item->{$join_table}->product_discount == 0) {
            $total += $item->{$join_table}->product_discounted_price * $item->qty;
          } else {
            $total += $item->{$join_table}->product_price * $item->qty;
          }
        }
      }
    }
    $cart_total->cart_total = $total;
    return $cart_total;
  }
}

if (!function_exists('get_coupon_usage_count')) {
  function get_coupon_usage_count($coupon_code)
  {
    $coupon_count = 0;
    if (isset(auth()->user()->id)) {
      $user_id = auth()->user()->id;
      if ($user_id) {
        $coupon_count = Orders::where('user_id', $user_id)->where('coupon_code', $coupon_code)->count();
      }
    }

    return $coupon_count;
  }
}

if (!function_exists('verify_pincode')) {
  function verify_pincode($pincode)
  {
    $accesstoken = 'ec1ee821dc6ca3355a018d48828d3e2ccb892de7'; //c7bd1bd7f2ed46a36775d63e8c9ee43617ffee49
    $url = "https://staging-express.delhivery.com/c/api/pin-codes/json/?token=" . $accesstoken . "&filter_codes=" . $pincode;
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    // dd($data);
    return $data;
  }
}

if (!function_exists('order_creation')) {
  // $md(string) : modeBilling mode of shipment(E: Express/ S: Surface)(mandatory)
  // $cgm(int32) : Weight of shipment in grams(Mandatory)
  // $o_pin(int32) : Origin center's Pin Code (optional)
  // $d_pin(int32) : Pin code of destination city (optional)
  // $ss(string) : Status of shipment Delivered,RTO,DTO(Mandatory)

  function order_creation($current_order)
  {
    $accesstoken = 'ec1ee821dc6ca3355a018d48828d3e2ccb892de7';
    $url = "https://staging-express.delhivery.com/api/cmu/create.json";

    $add = $current_order->shipping_address_line1 . ', ' . $current_order->shipping_address_line2 . ', ' . $current_order->shipping_landmark . ', ' . $current_order->shipping_city . ', ' . $current_order->shipping_district . ', ' . $current_order->shipping_state;
    $phone = $current_order->shipping_mobile_no;
    $total_amount = $current_order->total;
    $cod_amount_text = '';
    $cod_amount = '';

    if ($current_order->payment_mode == 'payumoney') {
      $payment_mode = "Prepaid";
    } else if ($current_order->payment_mode == 'cod') {
      $payment_mode = "COD";
    } else {
      $payment_mode = "COD";
    }
    $name = $current_order->shipping_full_name;
    $pin = $current_order->shipping_pincode;
    $order = $current_order->orders_counter_id;
    $order_id = $current_order->order_id;
    $city = $current_order->shipping_city;
    $order_total = $current_order->total;
    $product_weight = 0;
    $shipments = '';
    $order_qty = 0;
    $items = '';
    if (isset($current_order->orderproducts) && $current_order->orderproducts->count() > 0) {
      $items .= '"item": [';
      foreach ($current_order->orderproducts as $item) {
        $item_qty = $item->qty;
        $item_total_amount = $item->qty * $item->product_discounted_price;
        $products_desc = $item->product_sub_title . ' (' . $item->product_title . ')';
        $item_id = $item->orders_product_details_id;
        // if($current_order->payment_mode=='cod')
        // {
        //   $cod_amount = ',"cod_amount": "'.$item_total_amount.'"';
        // }
        // if ($shipments!='')
        // {
        //   $shipments .=',';
        // }
        $product_weight += $item->product_weight * $item->qty;
        // Damaged Product/Return reason of the product
        // img1-static image url

        $items .= '
        {
          "images": "' . $item->product_thumb . '",
          "color": "' . $item->product_color . '",
          "reason": "N/A",
          "descr": "' . $products_desc . '",
          "ean": "EAN no. that needs to be checked for a product (apparels)",
          "imei": "IMEI no. that needs to be checked for a product (mobile phones)",
          "brand": "' . $item->product_sub_title . '",
          "pcat": "apparels",
          "si": "special instruction for FE",
          "item_quantity" : ' . $item_qty . '
        },';
        // $shipments .= '{
        //   "add": "'.$add.'",
        //   "phone": "'.$phone.'",
        //   "payment_mode": "'.$payment_mode.'",
        //   "name": "'.$name.'",
        //   "pin": '.$pin.',
        //   "order": "'.$item_id.'",
        //   "city": "'.$city.'",
        //   "weight": "'.$product_weight.'",
        //   "products_desc": "'.$products_desc.'",
        //   "total_amount": '.$item_total_amount.',
        //   "quantity": "'.$item_qty.'"
        //   '.$cod_amount.'
        // }';
        $order_qty = $order_qty + $item_qty;
      }
      if ($current_order->payment_mode == 'cod') {
        $cod_amount = ',"cod_amount": "' . $current_order->total . '"';
      }
      $items = rtrim($items, ',');
      $items .= ']';
      $shipments .= '{
        "return_pin":"421004",
        "return_city":"Ulhasnagar",
        "return_phone":"7498042995",
        "return_add":"403, Harnam Apartment, 4th Floor, Section 30, Ulhasnagar 421004, Thane, Maharashtra",
        "return_state":"Maharashtra",
        "return_country":"India",
        "seller_name":"G.R. Parwani Trading Co.",
        "seller_add":"403, Harnam Apartment, 4th Floor, Section 30, Ulhasnagar 421004, Thane, Maharashtra",
        "country":"India",
        "add": "' . $add . '",
        "phone": "' . $phone . '",
        "payment_mode": "' . $payment_mode . '",
        "name": "' . $name . '",
        "pin": ' . $pin . ',
        "order": "' . $order_id . '",
        "state":"' . $current_order->shipping_state . '",
        "city": "' . $city . '",
        "weight": "' . $product_weight . '",
        ' . $items . ',
        "total_amount": ' . $order_total . ',
        "quantity": "' . $order_qty . '"
        ' . $cod_amount . '
      }';
    }
    // dd($shipments);
    $postRequest =  'format=json&data={
                  "shipments": [' . $shipments . '],
                  "pickup_location": {
                  "name": "GR 0068088"
                  }
                  }';
    // $postRequest = json_encode($postRequest);
    // dd($postRequest);
    // "waybill": "'.$bulk_waybills.'",
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '' . $postRequest);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
  }
}
//cart total with all prices
if (!function_exists('get_cart_amounts')) {
  function get_cart_amounts()
  {
    $cart_total = new stdClass();
    $cart_mrp_total = 0;
    $cart_discounted_total = 0;
    $coupon_discount = 0;
    $total_discount = 0;
    // dd('test');
    if (isset(auth()->user()->id)) {
      $user_id = auth()->user()->id;
      if ($user_id) {
        // $cart_total = Cart::where('user_id',$user_id)->with(['products'])->select(DB::raw('sum(products.product_discounted_price*cart.qty) as cart_total'))->first();
        // $cart_total = Cart::where('user_id',$user_id)->join('products', 'products.product_id', '=', 'cart.product_id')->select(DB::raw('sum(products.product_price*cart.qty) as cart_mrp_total, sum(products.product_discounted_price*cart.qty) as cart_discounted_total'))->first();
        $cart = Cart::where('user_id', $user_id)->with(['products', 'product_variant'])->get();
        foreach ($cart as $item) {
          $join_table = 'products';
          if ($item->product_type == "configurable") {
            $join_table = 'product_variant';
          }
          if ($item->{$join_table}->product_discounted_price != null && $item->{$join_table}->product_discount != 0) {
            $cart_mrp_total += $item->{$join_table}->product_price * $item->qty;
            $cart_discounted_total += $item->{$join_table}->product_discounted_price * $item->qty;
          } elseif ($item->{$join_table}->product_discounted_price != null && $item->{$join_table}->product_discount == 0) {
            $cart_mrp_total += $item->{$join_table}->product_discounted_price * $item->qty;
            $cart_discounted_total += $item->{$join_table}->product_discounted_price * $item->qty;
          } else {
            $cart_mrp_total += $item->{$join_table}->product_price * $item->qty;
            $cart_discounted_total += $item->{$join_table}->product_discounted_price * $item->qty;
          }
        }
        $cart_total->cart_mrp_total = $cart_mrp_total;
        $cart_total->cart_discounted_total = $cart_discounted_total;
      }

      if ($cart_total) {
        //total_discount
        $total_discount = $cart_total->cart_mrp_total - $cart_total->cart_discounted_total;
        //coupon discount
        $cart_coupon = CartCoupons::where('user_id', $user_id)->with('coupon')->first();

        if (isset($cart_coupon->coupon)) {
          $paymentDate = date('Y-m-d');
          $paymentDate = date('Y-m-d', strtotime($paymentDate));
          $contractDateBegin = date('Y-m-d', strtotime($cart_coupon->coupon->start_date));
          $contractDateEnd = date('Y-m-d', strtotime($cart_coupon->coupon->end_date));

          if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
            if ($cart_coupon->coupon->coupon_type == 'flat') {
              $coupon_value = $cart_coupon->coupon->value;
              $coupon_discount = $coupon_value;
            } else {
              $coupon_value = $cart_coupon->coupon->value;
              if (isset($cart_total->cart_discounted_total)) {
                $coupon_discount = ($cart_total->cart_discounted_total * $coupon_value) / 100;
              }
            }
          } else {
          }
        }
      }
    }

    return (object)['cart' => $cart_total, 'total_discount' => $total_discount, 'coupon_discount' => $coupon_discount];
  }
}

if (!function_exists('order_status')) {
  function order_status($orders)
  {
    $progress = "PROCESSING";
    if ($orders->order_return_flag == 1 && $orders->order_return_status == 1) {
      $progress = "RETURNED & REFUNDED";
    } else if ($orders->order_return_flag == 1 && $orders->order_return_status == 0 && $orders->order_return_status != NULL) {
      // dd($orders);
      $progress = "RETURNED";
    } else if ($orders->order_return_flag == 1) {
      $progress = "RETURNING";
    } else {
      if ($orders->cancel_order_flag == 1) {
        $progress = "CANCELLED";
      } else {
        if ($orders->confirmed_stage == 1) {
          $progress = "CONFIRMED";
        }
        if ($orders->preparing_order_stage == 1) {
          $progress = "PREPARING YOUR ORDER";
        }
        if ($orders->shipped_stage == 1) {
          $progress = "SHIPPED";
        }
        if ($orders->out_for_delivery_stage == 1) {
          $progress = "OUT FOR DELIVERY";
        }
        if ($orders->delivered_stage == 1) {
          $progress = "DELIVERED";
        }
      }
    }

    return $progress;
  }
}

if (!function_exists('order_return_days_status')) {
  function order_return_days_status($orders)
  {
    $return_status = false;

    if ($orders->delivered_stage == 1 && $orders->delivered_date != '') {
      $order_return = OrderReturnManagement::first();

      $todayDate = date('Y-m-d H:i:s');
      $todayDate = date('Y-m-d H:i:s', strtotime($todayDate));

      $deliveryDate = $orders->delivered_date;
      $deliveryDate = date('Y-m-d H:i:s', strtotime($deliveryDate));

      $contractDateEnd = date('Y-m-d H:i:s', strtotime($deliveryDate . ' +' . $order_return->order_return_max_days . ' days'));
      // dd($todayDate);
      if ($todayDate <= $contractDateEnd) {
        $return_status = true;
      }
    }


    return $return_status;
  }
}

if (!function_exists('order_cancel_days_status')) {
  function order_cancel_days_status($orders)
  {
    $cancel_status = false;

    // if ($orders->delivered_stage == 1 && $orders->delivered_date != '')
    // {
    $order_cancel = OrderCancelManagement::first();

    // $Date1 = '2010-09-17';
    $todayDate = date('Y-m-d H:i:s');
    $tdate = new DateTime($todayDate);
    // $tdate->add(new DateInterval('P1D')); // P1D means a period of 1 day
    $todayDate = $tdate->format('Y-m-d H:i:s');

    // $todayDate = date('Y-m-d h:i:s', strtotime($todayDate));

    $deliveryDate = $orders->created_at;
    $ddate = new DateTime($deliveryDate);
    // $ddate->add(new DateInterval('P1D')); // P1D means a period of 1 day
    $deliveryDate = $ddate->format('Y-m-d H:i:s');
    // $deliveryDate = date('Y-m-d h:i:s', strtotime($deliveryDate));

    $cdate = new DateTime($deliveryDate);
    $cdateincd = 'P' . $order_cancel->order_cancel_max_days . 'D';
    $cdateinch = 'PT' . $order_cancel->order_cancel_max_hours . 'H';
    // $cdate->add(new DateInterval($cdateincd)); // P1D means a period of 1 day
    $cdate->add(new DateInterval($cdateinch)); // P1D means a period of 1 day
    $contractDateEnd = $cdate->format('Y-m-d H:i:s');
    // $contractDateEnd = date('Y-m-d h:i:s', strtotime('+'.$order_cancel->order_cancel_max_days.' days +'.$order_cancel->order_cancel_max_hours.' hours',strtotime($deliveryDate)));
    // dd($cdateinch.' '.$todayDate.' '.$contractDateEnd.' '.$deliveryDate);
    if ($todayDate <= $contractDateEnd) {
      $cancel_status = true;
    }
    // }


    return $cancel_status;
  }
}

if (!function_exists('warehouse_creation')) {
  // $md(string) : modeBilling mode of shipment(E: Express/ S: Surface)(mandatory)
  // $cgm(int32) : Weight of shipment in grams(Mandatory)
  // $o_pin(int32) : Origin center's Pin Code (optional)
  // $d_pin(int32) : Pin code of destination city (optional)
  // $ss(string) : Status of shipment Delivered,RTO,DTO(Mandatory)

  function warehouse_creation()
  {
    $accesstoken = 'ec1ee821dc6ca3355a018d48828d3e2ccb892de7';
    $url = "https://staging-express.delhivery.com/api/backend/clientwarehouse/create/";

    $postRequest =  '{
                    "phone": "7498042995",
                    "city": "Greater Thane",
                    "name": "DILIPKUMAR PARWANI",
                    "pin": "421004",
                    "address": "HARNAM APARTMENT 403, 4TH FLOOR, SECTION 30, ULHASNAGAR, 421004 , Ulhasnagar, Maharashtra ,India 421004",
                    "country": "India",
                    "email": "grparwanitradingco@gmail.com",
                    "registered_name": "GR0068088",
                     "return_address": "HARNAM APARTMENT 403, 4TH FLOOR, SECTION 30, ULHASNAGAR, 421004 , Ulhasnagar, Maharashtra ,India 421004",
                     "return_pin":"421004",
                     "return_city":"Greater Thane",
                     "return_state":"Maharashtra",
                     "return_country": "India"
                  }';
    // $postRequest = json_encode($postRequest);
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '' . $postRequest);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
  }
}

if (!function_exists('get_state')) {
  function get_state($state_code)
  {
    $state = "";
    if (isset($state_code) && $state_code != '') {
      $state = StateCodes::where('state_code', $state_code)->first();
    }
    return $state;
  }
}

if (!function_exists('create_bulk_waybill')) {
  function create_bulk_waybill($count)
  {
    $accesstoken = 'ec1ee821dc6ca3355a018d48828d3e2ccb892de7'; //c7bd1bd7f2ed46a36775d63e8c9ee43617ffee49
    $cl = 'GR0068088SURFACE-B2C';
    $url = "https://staging-express.delhivery.com/waybill/api/bulk/json/?token=" . $accesstoken . "&cl=" . $cl . "&count=" . $count;
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    // dd($data);
    return $data;
  }
}

if (!function_exists('track_order')) {
  function track_order($waybill)
  {
    $accesstoken = 'ec1ee821dc6ca3355a018d48828d3e2ccb892de7'; //c7bd1bd7f2ed46a36775d63e8c9ee43617ffee49
    $cl = 'GR0068088SURFACE-B2C';
    $url = "https://staging-express.delhivery.com/api/v1/packages/json/?token=" . $accesstoken . "&waybill=" . $waybill;
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    // dd($data);
    return $data;
  }
}

if (!function_exists('packing_slip')) {
  function packing_slip($waybill)
  {
    $accesstoken = 'ec1ee821dc6ca3355a018d48828d3e2ccb892de7'; //c7bd1bd7f2ed46a36775d63e8c9ee43617ffee49
    $cl = 'GR0068088SURFACE-B2C';
    $url = "https://staging-express.delhivery.com/api/p/packing_slip?token=" . $accesstoken . "&wbns=" . $waybill;
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    // dd($data);
    return $data;
  }
}

if (!function_exists('get_cart_product_weight')) {
  function get_cart_product_weight()
  {
    $cart_total = new stdClass();
    if (isset(auth()->user()->id)) {
      $user_id = auth()->user()->id;
      if ($user_id) {
        // $cart_total = Cart::where('user_id',$user_id)->with(['products'])->select(DB::raw('sum(products.product_discounted_price*cart.qty) as cart_total'))->first();
        // $cart_total = Cart::where('user_id',$user_id)->join('products', 'products.product_id', '=', 'cart.product_id')->select(DB::raw('sum(products.product_weight*cart.qty) as cart_total_product_weight'))->first();
        $cart = Cart::where('user_id', $user_id)->with(['products', 'product_variant'])->get();
        $product_wt = 0;
        foreach ($cart as $item) {
          $join_table = 'products';
          if ($item->product_type == "configurable") {
            $join_table = 'product_variant';
          }
          $product_wt = $product_wt + ($item->{$join_table}->product_weight * $item->qty);
        }
        $cart_total->cart_total_product_weight = $product_wt;
        $cart_total = ($cart_total->cart_total_product_weight) ? $cart_total->cart_total_product_weight : 0;
      }
    }

    return $cart_total;
  }
}


if (!function_exists('order_cancellation')) {

  function order_cancellation($waybill)
  {
    $accesstoken = 'ec1ee821dc6ca3355a018d48828d3e2ccb892de7';
    $url = "https://staging-express.delhivery.com/api/p/edit";

    $postRequest =  '{"cancellation": "true",
                    "waybill": "' . $waybill . '"
                  }';
    // $postRequest = json_encode($postRequest);

    // "waybill": "'.$bulk_waybills.'",
    $curl = curl_init();

    $headr = array();
    $headr[] = 'Access: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Token ' . $accesstoken;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '' . $postRequest);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
  }
}

//mahesh 09-02-2022 
//for setting status wise color for orders
if (!function_exists('order_status_color')) {
  function order_status_color($orders)
  {
    $status_color = "order-status-color-default";
    if ($orders->order_return_flag == 1 && $orders->order_return_status == 1) {
      $status_color = "order-status-color-return";
    } else if ($orders->order_return_flag == 1 && $orders->order_return_status == 0 && $orders->order_return_status != NULL) {
      $status_color = "order-status-color-return";
    }
    if ($orders->order_return_flag == 1) {
      $status_color = "order-status-color-return";
    } else {
      if ($orders->cancel_order_flag == 1) {
        $status_color = "order-status-color-cancellation";
      } else {
        if ($orders->confirmed_stage == 1) {
          $status_color = "order-status-color-confirmed";
        }
        if ($orders->preparing_order_stage == 1) {
          $status_color = "order-status-color-preparing";
        }
        if ($orders->shipped_stage == 1) {
          $status_color = "order-status-color-shipped";
        }
        if ($orders->out_for_delivery_stage == 1) {
          $status_color = "order-status-color-out-of-delivery";
        }
        if ($orders->delivered_stage == 1) {
          $status_color = "order-status-color-delivery";
        }
      }
    }

    return $status_color;
  }
}

if (!function_exists('captureActivity')) {
  function captureActivity($data)
  {
    $user_array = [];
    $id = Auth()->guard('admin')->user()->admin_user_id;
    $username = Auth()->guard('admin')->user()->first_name . ' ' . Auth()->guard('admin')->user()->last_name;
    $ses_id = Session::getId();
    $user_array = [
      'user_id' => $id,
      'user_name' => $username,
      'session_id' => $ses_id
    ];

    // dd($user_array);
    $row = array_merge($user_array, $data);
    // dd($row);
    $log = new ActivityLog();
    $log->fill($row);
    // dd($log->getChanges());
    $log->save();
  }
}

if (!function_exists('captureActivityupdate')) {
  function captureActivityupdate($upd, $data)
  {
    $user_array = [];
    $id = Auth()->guard('admin')->user()->admin_user_id;
    $username = Auth()->guard('admin')->user()->first_name . ' ' . Auth()->guard('admin')->user()->last_name;
    $ses_id = Session::getId();
    $user_array = ['user_id' => $id, 'user_name' => $username, 'session_id' => $ses_id];
    // dd($id_to_names);

    $dataAttributes = array_map(function ($value, $key) {
      return $key . '="' . $value . '" ,';
    }, array_values($upd), array_keys($upd));

    $dataAttributes = implode(' ', $dataAttributes);
    $dataAttributes = rtrim($dataAttributes, ' ,');;

    $data['description'] = $data['description'] . ' ' . $dataAttributes . ')';
    // dd($data['description']);

    $row = array_merge($user_array, $data);
    $log = new ActivityLog();
    $log->fill($row);
    $log->save();
  }
}
if (!function_exists('userCaptureActivityupdate')) {
  function userCaptureActivityupdate($upd, $data, $user_role)
  {
    // dd(count($id_to_names));
    // $id_to_names = $id_to_names ?? '';
    $user_array = [];
    $id = Auth()->guard('admin')->user()->admin_user_id;
    $username = Auth()->guard('admin')->user()->first_name . ' ' . Auth()->guard('admin')->user()->last_name;
    $ses_id = Session::getId();
    $user_array = ['user_id' => $id, 'user_name' => $username, 'session_id' => $ses_id];
    // dd($id_to_names);

    $dataAttributes = array_map(function ($value, $key, $user_role) {
      if ($key == 'department') {
        if (isset($value)) {
          $department = Department::where('department_id', $value)->first();
          $department_name = $department->name ?? '';
        }
        $value = $department_name ?? '';
        $key = 'Department';
      } elseif ($key == 'company_id') {
        if (isset($value)) {
          $company = Company::where('company_id', $value)->first();
          $company_name = $company->company_name ?? '';
        }
        $value = $company_name ?? '';
        $key = 'Company';
      } elseif ($key == 'location_id' || $key == 'location') {
        if (isset($value)) {
          $location = Location::where('location_id', $value)->first();
          $location_name = $location->location_name ?? '';
        }
        $value = $location_name ?? '';
        $key = 'Location';
      } elseif ($key == 'designation_id') {
        if (isset($value)) {
          $designation = Designation::where('designation_id', $value)->first();
          $designation_name = $designation->designation_name ?? '';
        }
        $value = $designation_name ?? '';
        $key = 'Designation';
      } elseif ($key == 'role' && $user_role != 1) {
        if (isset($value)) {
          $role = Role::where('id', $value)->first();
          $role_name = $role->name ?? '';
        }
        $value = $role_name ?? '';
        $key = 'Role';
      } elseif ($key == 'account_status' || $key == 'active_status') {
        if (isset($value)) {
          if ($value == '0') {
            $account_status = 'Inactive';
          } else {
            $account_status = 'Active';
          }
        }
        $value = $account_status ?? '';
        $key = 'Account Status';
      } elseif ($key == 'centralized_decentralized_type') {
        if (isset($value)) {
          if ($value == '1') {
            $centralized_decentralized_type = 'Centralized';
          } else {
            $centralized_decentralized_type = 'Decentralized';
          }
        }
        $value = $centralized_decentralized_type ?? '';
        $key = 'Centralized/Decentralized Type';
      }
      return $key . '="' . $value . '" ,';
    }, array_values($upd), array_keys($upd), $user_role);

    $dataAttributes = implode(' ', $dataAttributes);
    $dataAttributes = rtrim($dataAttributes, ' ,');;

    $data['description'] = $data['description'] . ' ' . $dataAttributes . ')';
    // dd($data['description']);

    $row = array_merge($user_array, $data);
    $log = new ActivityLog();
    $log->fill($row);
    $log->save();
  }
}

//mail --change when live
if (!function_exists('mailCommunication')) {
  function mailCommunication($subject, $body, $to_whom = null)
  {

    // dd('inside mail');
    try {
      $mail = new PHPMailer\PHPMailer(true);
      $mail->IsSMTP();
      // $mail->IsMail();
      $mail->CharSet = "utf-8"; // set charset to utf8
      //for local start
      //for local end
      $mail->SMTPAuth = true; // authentication enabled
      $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587; // port - 587/465
      $mail->Username = "ideaportal@jmbaxi.com";
      $mail->Password = 'cflcunvcsjgswsyo';


      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );

      $mail->isHTML(true);
      $mail->setFrom("ideaportal@jmbaxi.com", 'Jmbaxi');

      $cc_mail_data = FacadesDB::table('cc_emails')->where(['assign_cc' => 1])->select('*')->get();
      foreach ($cc_mail_data as $data) {
        $mail->addCC($data->cc_mail, 'Owner');
      }

      //whom to send
      if (!empty($to_whom)) {
        $mail->addAddress($to_whom, 'User');
      }



      $admin = AdminUsers::where(['role' => 1, 'account_status' => 1])->get();
      foreach ($admin as $data) {
        $mail->addAddress($data->email, 'Admin');
      }



      $mail->Subject = $subject;
      $mail->Body = $body;
      return $mail->Send();
      // print('dont exit');
    } catch (Exception $e) {
      dd($e);
    }
  }
  // return 1;
}

if (!function_exists('send_backned_notification')) {
  function send_backned_notification($idea_uni_id, $title, $description, $user_id)
  {
    $data = AdminUsers::get();
    // dd($data->toArray());
    foreach ($data as $row) {
      $notification = new AdminNotification();
      $notification->user_id = $user_id;
      $notification->idea_uni_id = $idea_uni_id;
      $notification->title = $title;
      $notification->description = $description;
      $notification->receiver_id = $row->admin_user_id;
      $notification->save();
    }
  }
}

if (!function_exists('send_frontend_notification')) {
  function send_frontend_notification($idea_uni_id, $title, $description, $receiver_id, $role)
  {
    $notification = new Notification();
    $notification->idea_uni_id = $idea_uni_id;
    $notification->title = $title;
    $notification->description = $description;
    $notification->receiver_id = $receiver_id;
    $notification->role = $role;
    $notification->save();
  }


  function get_random_refresh_token()
  {
    $refresh_tokens = [
      '1000.4fee05dd232ad736c8b1d0f35ac86426.10ad82f25ef32e13f430e09345ea9fbb',
      '1000.d1beaaa6edb7e6dd1e32f108620dd3eb.282f8ccd21c0e7296189210917938c9b',
      '1000.633403c8435da4721081d3ac3fc11103.2b05b05770c0ffd470f95913549a5d91',
      '1000.bbe24281e96094ae808776524af304dd.df958308f36bc920962fcd8ed1c4d573',
      '1000.12f56d01a6cfb534eaaaeb7abbd40428.0b0c58768d653328b2ac7c1925968323',
      '1000.dbdccad8ceaf381765d245172b5fdb74.54bf472c08ff190cc0fef33127153008',
      '1000.892bd412a04d72b0dc8eca91024e2972.cd20dfaedb202e6c8904f135c7b1e1d0',
      '1000.7057a3de0c0af9ac0fa868d6143fb7b3.9b8214f1b69c2a019bca028c5e5ad5eb',
      '1000.347c972ea9a2d73a149683116c73be31.4043fbdc806b961e37190215ee87e9d6',
      '1000.9a1e004901bca25a5a704136cf11d549.8a8653ce9e78572897baa382275aad89',
      '1000.67fd2aa129ba1c760387e41469fa7d1f.c83c63d8346cec6cf6ee30b6e380c466',
      '1000.495c5fcfc9f6041377e7e4ba64db173b.9f67e483ae3d1cb75b0e557e436f0b1e',
      '1000.cddb5e44fc55d85cdb498f8a87dfc8d1.08adfe99d180445ee7ad3bc8db45280c',
      '1000.342606c254ad6b2b13e47ac28d536384.6cb779c8a7985e4102feab80dd3b6b79',
      '1000.855c858904feaa47f3302dab1d7717c5.7f618715081d48ffeeb4722b3ab1c685',
      '1000.a977d723ee0f729a3abd471e8dbd84fc.713713dc2a661eabffc69ffe196936b6',
    ];

    $randomRefreshToken = $refresh_tokens[array_rand($refresh_tokens)];

    return $randomRefreshToken;
  }



  function generateAuthclient()
  {
    $clientId = env('ZOHO_CLIENT_ID') ?? '1000.0YKJ3YKVMH7HGAAAVYWPAZVFILSX2G';
    $clientSecret = env('ZOHO_CLIENT_SECRET') ?? 'a4c4e0e9bc40ccc5e64e28642ffe9a0d5b8a820695';

    $refreshToken = get_random_refresh_token();
    // dd($refreshToken);

    $oAuthClient = new \Weble\ZohoClient\OAuthClient($clientId, $clientSecret);
    $oAuthClient->setRefreshToken($refreshToken);
    $oAuthClient->setRegion(\Weble\ZohoClient\Enums\Region::IN);
    $oAuthClient->offlineMode();

    try {
      $oAuthClient->refreshAccessToken();
    } catch (IdentityProviderException $e) {
      
      //new code  
      $maxAttempts = 3;
      static $attempts = 0;

      if ($attempts < $maxAttempts) {
        $attempts++;
        return generateAuthclient();
      } else {
        // Maximum attempts reached, handle the error
        echo "Failed to retrieve data";
        return null;
      }
      
    //   $new_refreshToken = get_random_refresh_token();
    //   $new_oAuthClient = new \Weble\ZohoClient\OAuthClient($clientId, $clientSecret);
    //   $new_oAuthClient->setRefreshToken($new_refreshToken);
    //   $new_oAuthClient->setRegion(\Weble\ZohoClient\Enums\Region::IN);
    //   $new_oAuthClient->offlineMode();

    //   return $new_oAuthClient;
      
    }


    return $oAuthClient;
  }


  if (!function_exists('get_all_modules_zoho')) {
    function get_all_modules_zoho()
    {

      $oAuthClient = generateAuthclient();

      // setup the zoho books client
      $org_id = env('ZOHO_ORGANIZATION_ID') ?? '60022231474';
      $client = new \Webleit\ZohoBooksApi\Client($oAuthClient);
      $client->setOrganizationId($org_id);
      $zohoBooks = new \Webleit\ZohoBooksApi\ZohoBooks($client);
      $zohoBooks->getAvailableModules();

      
      return $zohoBooks;
    }
  }

  if (!function_exists('get_zoho_client')) {
    function get_zoho_client()
    {

      $oAuthClient = generateAuthclient();

      // setup the zoho books client
      $client = new \Webleit\ZohoBooksApi\Client($oAuthClient);
      $client->setOrganizationId(env('ZOHO_ORGANIZATION_ID') ?? '60022231474');

      return $client;
    }
  }


    if (!function_exists('get_authorized_access_token')) {
    function get_authorized_access_token()
    {
      $clientId = env('ZOHO_CLIENT_ID'); // Replace with your actual client ID
      $clientSecret = env('ZOHO_CLIENT_SECRET'); // Replace with your actual client secret
      // $refreshToken = env('ZOHO_REFRESH_TOKEN'); // Replace with your actual refresh token
      $refreshToken = get_random_refresh_token();

      $tokenUrl = 'https://accounts.zoho.in/oauth/v2/token';
      $data = [
        'refresh_token' => $refreshToken,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'grant_type' => 'refresh_token'
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $tokenUrl);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);

      $accessToken = '';
      // dd($response);

      // Check if the request was successful

      if ($response) {
        $responseData = json_decode($response, true);

        if (isset($responseData['access_token'])) {
          $accessToken = $responseData['access_token'];

          // Use the new access token for API requests to Zoho Books
        } else {
          // Handle the case when the access token is not present in the response
          $maxAttempts = 3;
          static $attempts = 0;

          if ($attempts < $maxAttempts) {
            $attempts++;
            return get_authorized_access_token();
          } else {
            // Maximum attempts reached, handle the error
            echo "Failed to retrieve the authorized access token.";
            return null;
          }
        }
      } else {
        // Handle the case when the cURL request fails
        $errorMessage = curl_error($ch);
        echo "cURL Error: $errorMessage";
      }

      curl_close($ch);
      if (empty($accessToken)) {
        // Add a maximum number of attempts to avoid infinite recursion
        $maxAttempts = 3;
        static $attempts = 0;

        if ($attempts < $maxAttempts) {
          $attempts++;
          return get_authorized_access_token();
        } else {
          // Maximum attempts reached, handle the error
          echo "Failed to retrieve the authorized access token.";
          return null;
        }
      }

      return $accessToken;

    }
  }
}
