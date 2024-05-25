<?php


namespace App\Http\Controllers;

use App\Models\backend\Invoices;
use App\Models\backend\ItemImages;
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
            $model = Items::where(['item_id'=> $array['item']['item_id'],'name'=>$array['item']['name']])->first();

            $desiredColumns = ['item_id', 'name', 'item_type', 'product_type', 'hsn_or_sac', 'sku', 'rate', 'unit', 'stock_on_hand', 'available_stock', 'description']; // Specify the desired column names
            $data = array_intersect_key($array['item'], array_flip($desiredColumns)); // Extract only the desired columns

            // add taxes as per condition
            $tax_percent_intra = $array['item']['item_tax_preferences'][0]['tax_percentage'] ?? '';
            $tax_percent_inter = $array['item']['item_tax_preferences'][1]['tax_percentage'] ?? '';


            //for warehouses as well

            //edit any item will go in this if
            if ($model) {

                // if (!empty($array['item']['custom_fields'])) {
                //     $model->category = $array['item']['custom_fields'][0]['value'];
                //     $model->variant = $array['item']['custom_fields'][1]['value'];
                // }

                //for attributes
                if (!empty($array['item']['attribute_option_name1'])) {
                    $model->category = $array['item']['attribute_option_name1'];
                }
                if (!empty($array['item']['attribute_option_name2'])) {
                    $model->variant = $array['item']['attribute_option_name2'];
                }
                if (!empty($array['item']['attribute_option_name3'])) {
                    $model->size = $array['item']['attribute_option_name3'];
                }


                // $model->category = $array['item']['attribute_option_name1'];
                // $model->variant = $array['item']['attribute_option_name2'];
                // $model->size = $array['item']['attribute_option_name3'];

                $model->group_id = $array['item']['group_id'] ?? '';
                $model->group_name = $array['item']['group_name'] ?? '';
                $model->inter_tax_percent = $tax_percent_inter;
                $model->intra_tax_percent = $tax_percent_intra;
                $model->fill($data);

                // $group_data_array = '';
                // if grpup id i have then
                // if (!empty($array['item']['group_id'])) {
                //     // fetch group_data then fetch document ids then get images for each doc_id and save it
                //     $group_data = get_group_data_with_group_id($array['item']['group_id']);
                //     $model->group_data = $group_data;

                //     $group_data_array = json_decode($group_data, true);
                // }

                $images_arr = '';
                $image_name = '';

                // first insert images got form item group if not group then fetch docs directly
                // if (!empty($group_data_array)) {
                //     // store images got from item group if no image for items
                //     if (!empty($group_data_array['item_group']['documents'])) {
                //         foreach ($group_data_array['item_group']['documents'] as $row) {
                //             $image = get_image_with_document_id($row['document_id'], $row['file_type']);
                //             $images_arr .= $image . ',';
                //         }
                //     }

                //     if (!empty($group_data_array['item_group']['items'])) {
                //         foreach ($group_data_array['item_group']['items'] as $row) {
                //             if ($row['item_id'] == $array['item']['item_id']) {
                //                 $image_name = get_image_with_document_id($row['image_document_id'], $row['image_type']);
                //             }
                //         }
                //     }
                // } else
                if (!empty($array['item']['documents'])) {
                    foreach ($array['item']['documents'] as $row) {
                        $image = get_image_with_document_id($row['document_id'], $row['file_type']);
                        $images_arr .= $image . ',';
                    }
                    // store single item image first image
                    $image_name = $array['item']['documents'][0]['document_id'] . '_' . '.' . $array['item']['documents'][0]['file_type'];
                }

                //save item image
                $model->item_image = $image_name;
                $model->save();

                //store images in item group
                $group_images = ItemImages::where('item_id', $array['item']['item_id'])->first();
                if (empty($group_images)) {
                    $group_images = new ItemImages();
                }
                if (!empty($images_arr)) {
                    $group_images->item_id = $array['item']['item_id'];
                    $group_images->group_id = $array['item']['group_id'];
                    $images_arr = rtrim($images_arr, ',');
                    $group_images->image_name = $images_arr;
                    $group_images->save();
                }


                // warehouses
                if (isset($array['item']['warehouses'])) {
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
                }
            } else {
                $model = new Items();

                //for attributes
                $model->category = $array['item']['attribute_option_name1'] ?? '';
                $model->variant = $array['item']['attribute_option_name2'] ?? '';
                $model->size = $array['item']['attribute_option_name3'] ?? '';


                $model->group_id = $array['item']['group_id'] ?? '';
                $model->group_name = $array['item']['group_name'] ?? '';
                $model->inter_tax_percent = $tax_percent_inter;
                $model->intra_tax_percent = $tax_percent_intra;
                $model->fill($data);

                $images_arr = '';
                $image_name = '';

                // first insert images got form items
                if (!empty($array['item']['documents'])) {
                    foreach ($array['item']['documents'] as $row) {
                        $image = get_image_with_document_id($row['document_id'], $row['file_type']);
                        $images_arr .= $image . ',';
                    }
                    // store single item image first image
                    $image_name = $array['item']['documents'][0]['document_id'] . '_' . '.' . $array['item']['documents'][0]['file_type'];
                }

                //save item image
                $model->item_image = $image_name;
                $model->save();

                //store images in item group
                $group_images = ItemImages::where('item_id', $array['item']['item_id'])->first();
                if (empty($group_images)) {
                    $group_images = new ItemImages();
                }
                if (!empty($images_arr)) {
                    $group_images->item_id = $array['item']['item_id'];
                    $group_images->group_id = $array['item']['group_id'];
                    $images_arr = rtrim($images_arr, ',');
                    $group_images->image_name = $images_arr;
                    $group_images->save();
                }

                if (isset($array['item']['warehouses'])) {
                    foreach ($array['item']['warehouses'] as $key => $val) {
                        $warehouse = new Warehouses();
                        $warehouse->item_id = $array['item']['item_id'];

                        $warehouse->warehouse_id = $array['item']['warehouses'][$key]['warehouse_id'];
                        $warehouse->warehouse_name = $array['item']['warehouses'][$key]['warehouse_name'];
                        $warehouse->warehouse_stock_on_hand = $array['item']['warehouses'][$key]['warehouse_stock_on_hand'];
                        $warehouse->initial_stock = $array['item']['warehouses'][$key]['initial_stock'];
                        $warehouse->initial_stock_rate = $array['item']['warehouses'][$key]['initial_stock_rate'];
                        $warehouse->warehouse_available_stock = $array['item']['warehouses'][$key]['warehouse_available_stock'];
                        $warehouse->warehouse_actual_available_stock = $array['item']['warehouses'][$key]['warehouse_actual_available_stock'];
                        $warehouse->warehouse_available_for_sale_stock = $array['item']['warehouses'][$key]['warehouse_available_for_sale_stock'];
                        $warehouse->warehouse_actual_available_for_sale_stock = $array['item']['warehouses'][$key]['warehouse_actual_available_for_sale_stock'];
                        $warehouse->save();
                    }
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
                // $model->payment_date = $array['payment']['date'];
                $model->fill($data);
                $model->save();
            } else {
                $model = new PaymentInfo();
                $model->invoice_id = $array['payment']['invoices'][0]['invoice_id'];
                // $model->payment_date = $array['payment']['date'];
                $model->fill($data);
                $model->save();
            }
        }




        //deleteion management
        if ($request->type == 'item_delete') {
            $model = Items::where('item_id', $array['item']['item_id'])->first();
            $model->delete();

            $group_images = ItemImages::where('group_id', $array['item']['group_id'])->orWhere('item_id', $array['item']['item_id'])->get();
            foreach ($group_images as $row) {
                $row->delete();
            }
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
