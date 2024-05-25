<?php

namespace App\Http\Controllers\frontend;



use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use App\Models\frontend\Users;
use App\Http\Controllers\Controller;
use App\Models\backend\Cart;
use App\Models\backend\Coupons;
use App\Models\backend\Items;
use App\Models\backend\MissingPayments;
use App\Models\backend\PaymentInfo;
use App\Models\backend\Warehouses;
use App\Models\Rolesexternal;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FacadesSession;
use phpmailerException;
use Session;
// use Webleit\ZohoBooksApi\Modules\Settings\Invoices;
use Webleit\ZohoBooksApi\Modules\Invoices;


class CartController extends Controller
{




    public function index()
    {
        $user_id = Auth()->user()->user_id;

        $customer_data = Users::where('user_id', $user_id)->first();

        // $availableItems = Cart::where(['contact_id' => $customer_data->contact_id, 'paid_status' => 0])->with('get_items')->get();

        $availableItems = Cart::join('items', 'cart.item_id', '=', 'items.item_id')
            ->leftjoin('schemes', 'schemes.schemes_id', '=', 'items.offer')
            ->where(['cart.contact_id' => $customer_data->contact_id, 'cart.paid_status' => 0])
            ->select('cart.*', 'items.*', 'schemes.*')
            ->get();

        // dd($availableItems);

        // dd($availableItems);
        return view('frontend.cart.index', compact('availableItems'));
    }

    public function store($id)
    {
        $user_id = Auth()->user()->user_id;
        $customer_data = Users::where('user_id', $user_id)->first();

        $data = Cart::where(['item_id' => $id, 'contact_id' => $customer_data->contact_id, 'paid_status' => 0])->first();

        // dd($data);
        if (!empty($data)) {
            $count = $data->quantity + 1;
            $operated = DB::table('cart')
                ->where('item_id', '=', $id)
                ->where('contact_id', '=', $customer_data->contact_id)
                ->where('paid_status', '=', 0)
                ->update(['quantity' => $count]);
        } else {
            $operated = DB::table('cart')->insert([
                'contact_id' => $customer_data->contact_id,
                'item_id' => $id,
            ]);
        }


        if ($operated) {
            if (!empty($_GET['check'])) {
                return json_encode(['status' => 'Item Added to Cart Successfully']);
            }
            return redirect()->back()->with('success', 'Item Added to Cart Successfully');
        } else {
            return redirect()->route('products.index')->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        // dd($id);
        $user_id = Auth()->user()->user_id;
        $customer_data = Users::where('user_id', $user_id)->first();
        $item = Cart::where(['item_id' => $id, 'contact_id' => $customer_data->contact_id])->with('get_items')->first();

        return view('frontend.cart.edit', compact('item'));
    }

    public function update(Request $request)
    {
        $user_id = Auth()->user()->user_id;
        $customer_data = Users::where('user_id', $user_id)->first();
        foreach ($request->item_id as $key => $val) {

            // $avail_item_count = Items::where('item_id', $val)->first();
            $avail_item_count = Warehouses::where('item_id', $val)->first();
            if (1 > $avail_item_count->warehouse_available_stock) {
                return redirect()->back()->with('error', $avail_item_count->warehouse_available_stock . ' stock is available for Item ' . $avail_item_count->get_item->name . '!');
            }


            $model = Cart::where(['contact_id' => $customer_data->contact_id, 'item_id' => $val, 'paid_status' => 0])->first();
            if (empty($model)) {
                $model = new Cart();
            }

            $model->item_id = $val;
            $model->contact_id = $customer_data->contact_id;
            $model->quantity = $request->quantity[$key];
            $model->save();
        }


        return redirect()->back()->with('success', 'Cart Item Updated Successfully');
        // return redirect()->route('cart.index')->with('success', 'Cart Item Updated Successfully');
    }



    public function view($id)
    {

        $user_id = Auth()->user()->user_id;
        $customer_data = Users::where('user_id', $user_id)->first();
        $item = Cart::where(['item_id' => $id, 'contact_id' => $customer_data->contact_id, 'paid_status' => 0])->with('get_items')->first();
        // dd($item->toArray());

        return view('frontend.cart.view', compact('item'));
    }

    public function destroy($id)
    {
        $model = Cart::where('cart_id', $id)->first();
        $model->delete();
        return redirect()->route('cart.index')->with('success', 'Item Has Been Removed From Cart Successfully');
    }
}
