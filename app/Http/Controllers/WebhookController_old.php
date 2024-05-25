<?php


namespace App\Http\Controllers;

use App\Models\backend\Invoices;
use Illuminate\Support\Facades\Auth;
use App\Models\backend\Items;
use App\Models\backend\PaymentInfo;
use App\Models\backend\Taxes;
use App\Models\backend\Warehouses;
use App\Models\frontend\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webleit\ZohoBooksApi\Modules\Items as ModulesItems;

class WebhookController extends Controller
{
    public function handleZohoBooksWebhook(Request $request)
    {


        //for webhook
        $content = file_get_contents('php://input');
        $content_data = str_replace('test1223', '', $content);

        DB::table('webhooks')->insert([
            'type' => $request->type,
            'content' => $content_data,
        ]);

        $array  = json_decode($content_data, true);

        // for item
        if ($request->type == 'item_manage') {
            $model = Items::where('item_id', $array['item']['item_id'])->first();

            $desiredColumns = ['item_id', 'name', 'item_type', 'product_type', 'hsn_or_sac', 'rate', 'unit', 'stock_on_hand', 'available_stock', 'description']; // Specify the desired column names
            $data = array_intersect_key($array['item'], array_flip($desiredColumns)); // Extract only the desired columns

            // add taxes as per condition
            $tax_percent_inter = $array['item']['item_tax_preferences'][0]['tax_percentage'];
            $tax_percent_intra = $array['item']['item_tax_preferences'][1]['tax_percentage'];


            //for warehouses as well



            if ($model) {
                $model->inter_tax_percent = $tax_percent_inter;
                $model->intra_tax_percent = $tax_percent_intra;
                $model->fill($data);
                $model->save();

                foreach ($array['item']['warehouses'] as $key => $val) {
                    // $warehouse = new Warehouses();
                    $warehouse = Warehouses::where(['warehouse_id' => $val['warehouse_id'], 'item_id' => $array['item']['item_id']])->first();
                    if (empty($warehouse)) {
                        $warehouse = new Warehouses();
                    }
                    $warehouse->warehouse_id = $array['item']['warehouses'][$key]['warehouse_id'];
                    $warehouse->warehouse_name = $array['item']['warehouses'][$key]['warehouse_name'];
                    $warehouse->warehouse_stock_on_hand = $array['item']['warehouses'][$key]['warehouse_stock_on_hand'];
                    $warehouse->initial_stock = $array['item']['warehouses'][$key]['initial_stock'];
                    $warehouse->initial_stock_rate = $array['item']['warehouses'][$key]['initial_stock_rate'];
                    $warehouse->warehouse_available_stock = $array['item']['warehouses'][$key]['warehouse_available_stock'];
                    $warehouse->warehouse_actual_available_stock = $array['item']['warehouses'][$key]['warehouse_actual_available_stock'];
                    $warehouse->warehouse_available_for_sale_stock = $array['item']['warehouses'][$key]['warehouse_available_for_sale_stock'];
                    $warehouse->warehouse_actual_available_for_sale_stock = $array['item']['warehouses'][$key]['warehouse_actual_available_for_sale_stock'];

                    $warehouse->item_id = $array['item']['item_id'];
                    $warehouse->save();
                }
            } else {
                $model = new Items();
                $model->inter_tax_percent = $tax_percent_inter;
                $model->intra_tax_percent = $tax_percent_intra;
                $model->fill($data);
                $model->save();

                foreach ($array['item']['warehouses'] as $key => $val) {
                    $warehouse = new Warehouses();
                    $warehouse->warehouse_id = $array['item']['warehouses'][$key]['warehouse_id'];
                    $warehouse->warehouse_name = $array['item']['warehouses'][$key]['warehouse_name'];
                    $warehouse->warehouse_stock_on_hand = $array['item']['warehouses'][$key]['warehouse_stock_on_hand'];
                    $warehouse->initial_stock = $array['item']['warehouses'][$key]['initial_stock'];
                    $warehouse->initial_stock_rate = $array['item']['warehouses'][$key]['initial_stock_rate'];
                    $warehouse->warehouse_available_stock = $array['item']['warehouses'][$key]['warehouse_available_stock'];
                    $warehouse->warehouse_actual_available_stock = $array['item']['warehouses'][$key]['warehouse_actual_available_stock'];
                    $warehouse->warehouse_available_for_sale_stock = $array['item']['warehouses'][$key]['warehouse_available_for_sale_stock'];
                    $warehouse->warehouse_actual_available_for_sale_stock = $array['item']['warehouses'][$key]['warehouse_actual_available_for_sale_stock'];

                    $warehouse->item_id = $array['item']['item_id'];
                    $warehouse->save();
                }
            }
        }

        // for invoice
        if ($request->type == 'invoice_manage') {

            $model = Invoices::where('invoice_id', $array['invoice']['invoice_id'])->first();

            $desiredColumns = [
                'invoice_number', 'customer_id', 'date', 'discount',
                'due_date', 'invoice_id', 'total',
            ]; // Specify the desired column names
            $data = array_intersect_key($array['invoice'], array_flip($desiredColumns)); // Extract only the desired columns

            $invoice_items = "";
            $rates = "";
            $qunats = "";

            if ($model) {
                foreach ($array['invoice']['line_items'] as $key => $val) {
                    $invoice_items .= $array['invoice']['line_items'][$key]['item_id'] . ",";
                    $rates .= $array['invoice']['line_items'][$key]['rate'] . ",";
                    $qunats .= $array['invoice']['line_items'][$key]['quantity'] . ",";
                }
                $model->item_id = $invoice_items;
                $model->rate = $rates;
                $model->quantity = $qunats;
                $model->fill($data);
                $model->save();
            } else {
                $model = new Invoices();
                foreach ($array['invoice']['line_items'] as $key => $val) {
                    $invoice_items .= $array['invoice']['line_items'][$key]['item_id'] . ",";
                    $rates .= $array['invoice']['line_items'][$key]['rate'] . ",";
                    $qunats .= $array['invoice']['line_items'][$key]['quantity'] . ",";
                }
                $model->item_id = $invoice_items;
                $model->rate = $rates;
                $model->quantity = $qunats;
                $model->fill($data);
                $model->save();
            }


            // //update any data of an item to trigger
            // $zohoClient = get_zoho_client();
            // $items = new ModulesItems($zohoClient);
            // $update_any_data_to_trigger = [
            //     'status' => 'active',
            // ];
            // foreach ($array['invoice']['line_items'] as $row) {
            //     $items->update($row['item_id'], $update_any_data_to_trigger);
            // }
        }

        //for customer 
        if ($request->type == 'customer_manage') {

            $model = Users::where('contact_id', $array['contact']['contact_id'])->first();

            $desiredColumns = [
                'contact_id', 'company_name'
            ]; // Specify the desired column names
            $data = array_intersect_key($array['contact'], array_flip($desiredColumns)); // Extract only the desired columns

            if ($model) {
                $model->name = $array['contact']['contact_persons'][0]['first_name'];
                $model->last_name = $array['contact']['contact_persons'][0]['last_name'];
                $model->email = $array['contact']['contact_persons'][0]['email'];
                $model->mobile_no = $array['contact']['contact_persons'][0]['mobile'];
                $model->state = $array['contact']['place_of_contact'];
                $model->fill($data);
                $model->save();
            } else {
                $model = new Users();
                $model->name = $array['contact']['contact_persons'][0]['first_name'];
                $model->last_name = $array['contact']['contact_persons'][0]['last_name'];
                $model->email = $array['contact']['contact_persons'][0]['email'];
                $model->mobile_no = $array['contact']['contact_persons'][0]['mobile'];
                $model->fill($data);
                $model->save();
            }
        }

        //for customer payment
        if ($request->type == 'payment_manage') {

            $model = PaymentInfo::where('payment_id', $array['payment']['payment_id'])->first();

            $desiredColumns = [
                'payment_id', 'payment_mode', 'amount', 'customer_name', 'customer_id',
            ]; // Specify the desired column names
            $data = array_intersect_key($array['payment'], array_flip($desiredColumns)); // Extract only the desired columns

            if ($model) {
                $model->invoice_id = $array['payment']['invoices'][0]['invoice_id'];
                $model->fill($data);
                $model->save();
            } else {
                $model = new PaymentInfo();
                $model->invoice_id = $array['payment']['invoices'][0]['invoice_id'];
                $model->fill($data);
                $model->save();
            }
        }




        //deleteion management
        if ($request->type == 'item_delete') {
            $model = Items::where('item_id', $array['item']['item_id'])->first();
            $model->delete();
        }
        if ($request->type == 'invoice_delete') {
            $model = Invoices::where('invoice_id', $array['invoice']['invoice_id'])->first();
            $model->delete();

            //update any data of an item to trigger
            $zohoClient = get_zoho_client();
            $items = new ModulesItems($zohoClient);
            $update_any_data_to_trigger = [
                'status' => 'active',
            ];
            foreach ($array['invoice']['line_items'] as $row) {
                $items->update($row['item_id'], $update_any_data_to_trigger);
            }
        }
        if ($request->type == 'customer_delete') {
            $model = Users::where('contact_id', $array['contact']['contact_id'])->first();
            $model->delete();
        }
        if ($request->type == 'payment_delete') {
            $model = PaymentInfo::where('payment_id', $array['payment']['payment_id'])->first();
            $model->delete();
        }


        return response()->json(['success' => true]);
    }
}
