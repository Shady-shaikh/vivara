@extends('frontend.layouts.app')
@section('title', 'Summary')

<?php
use App\Models\frontend\Users;
use App\Models\backend\Shipping;
?>



@section('content')

    <div class="container-fluid px-lg-4 py-4">

        <h1 class="text-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Purchase Summary</h1>

        <div class="card shadow border-0">
            <div class="card-body">
                <table class="table table-striped " style="font-size:16px;">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-light">Item Name</th>
                            <!-- <th>Course Duration</th> -->
                            <th class="text-light">Total</th>
                            <!-- <th class="action-column">Action</th> -->
                        </tr>
                    </thead>

                    <tbody>



                        <tr>
                            <td>{{ $item_details->name }}</td>
                            <td>{{ $item_details->rate * $quantity }}</td>
                        </tr>

                        <?php
                        $tax_specification = '';
                        $tax_total = 0;
                        $total_amonut_wo_tax = $item_details->rate * $quantity;
                        
                        //user data
                        
                        // dd($customer_data);
                        
                        //org data
                        // $zohoBooks = get_all_modules_zoho();
                        // $org_data = $zohoBooks->organizations->get(env('ZOHO_ORGANIZATION_ID'));
                        $data = DB::table('organization')->get();
                        
                        $user_state = $user_details->state;
                        $org_state = $data[0]->state_code;
                        
                        // dd($user_state,$org_state);
                        
                        if ($user_state == $org_state) {
                            $tax_specification = 'intra';
                        } else {
                            $tax_specification = 'inter';
                        }
                        
                        // dd($tax_specification);
                        if ($tax_specification == 'intra') {
                            $taxt_amount = ($total_amonut_wo_tax * $item_details->intra_tax_percent) / 100;
                            $total_amount_w_tax = $total_amonut_wo_tax + $taxt_amount;
                        } elseif ($tax_specification == 'inter') {
                            $taxt_amount = ($total_amonut_wo_tax * $item_details->inter_tax_percent) / 100;
                            $total_amount_w_tax = $total_amonut_wo_tax + $taxt_amount;
                        }
                        
                        ?>

                        <tr>
                            <td class="right-block"><strong>Tax</strong></td>
                            <td><strong>
                                    {{ $taxt_amount }}
                                </strong></td>

                        </tr>

                        <tr>
                            <td class="right-block"><strong>Cart Total</strong></td>
                            <td><strong><i class="fa fa-inr" aria-hidden="true"></i>
                                    <?= $total_amount_w_tax ?></strong></td>
                        </tr>

                        <tr>
                            <td class="right-block"><strong>Apply Coupon</strong></td>
                            <td>
                                {{-- {{dd(session('data'))}} --}}
                                <form id="coupon-form" action="{{ route('products.getdiscountedamount') }}" method='POST'>
                                    @csrf
                                    <input type="text" name="coupon" class="form-control w-25"
                                        placeholder="Enter Coupon Code" value="{{ session('code') }}">
                                    <input type="hidden" name="amount" value="<?= $total_amount_w_tax ?>">
                                    <button type="submit" class="btn btn-sm mt-2 btn-primary">Verify</button>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td class="right-block"><strong>Shipping Charges</strong></td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i>
                                <input type="text" class="ship_charge" value="0" readonly
                                    style="border:none;outline:none;background:transparent;">
                        </tr>

                        @php
                          $final_amount =session('data') ?? $total_amount_w_tax  ;
                        @endphp

                        <tr>
                            <td class="right-block"><strong>Final Amount</strong></td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i>
                                <input type="text" id="final_amount_s" value="<?= $final_amount ?>" style="outline:none;border:none;background:transparent;">
                            </td>
                        </tr>


                    </tbody>
                </table>
                <hr>


                <?php $product_info = trim($item_details, ', '); ?>
                <form
                    action="{{ route('products.payment', ['id' => $user_details->contact_id, 'item_id' => $item_details->item_id]) }}"
                    method="POST" name="payuForm">

                    @csrf
                    @php
                        $shipping_data = Shipping::where('shipping_method_status', 1)->get();
                        $selected_shipping_method = old('shipping_charges', session('shipping_charges'));
                    @endphp

                    <div class="form-group">
                        <label for="shipping_charges">Select Shipping Method *</label>
                        <select name="shipping_charges" class="form-control w-25" id="shipping_charges" required>
                            <option value="">Select Method</option>
                            @foreach ($shipping_data as $shipping_method)
                                <option value="{{ $shipping_method->shipping_method_id }}"
                                    {{ $selected_shipping_method == $shipping_method->shipping_method_id ? 'selected' : '' }}>
                                    {{ $shipping_method->shipping_method_name }} - [Charge:
                                    {{ $shipping_method->shipping_method_cost }} ]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="key" value="<?php echo 'gtKFFx'; ?>" />
                    <input type="hidden" name="hash" value="" />
                    <input type="hidden" name="txnid" value="<?= $increment_id ?>" />
                    <input type="hidden" name="udf1" value="<?php echo $user_details->contact_id; ?>" />
                    <input type="hidden" name="udf2" value="<?php echo $item_details->item_id; ?>" />
                    <input type="hidden" name="udf3" value="<?php echo (float) session('discount') ?? 0; ?>" />
                    <input type="hidden" name="udf4" value="<?php echo $check ?? ''; ?>" />
                    <input type="hidden" name="udf5" class="ship_charge" value="0" />
                    <input type="hidden" name="amount" class="final_amount" value="<?php echo (float) $final_amount; ?>" />
                    <input type="hidden" name="firstname" id="firstname" value="{{ trim($user_details->name) }}" />
                    <input type="hidden" name="email" id="email" value="{{ $user_details->email }}" />
                    <input type="hidden" name="phone" value="{{ $user_details->mobile_no }}" />
                    <textarea style="display:none;" name="productinfo">Test</textarea>
                    <input type="hidden" name="surl" value="{{ route('products.payment_success') }}" size="64" />
                    <input type="hidden" name="furl" value="{{ route('products.payment_failure') }}" size="64" />
                    <input type="hidden" name="service_provider" value="payu_paisa" size="64" />


                    <a href="{{ url()->previous() }}" style="margin:20px 0;"
                        class="btn btn-md btn-dark btn-danger">Back</a>

                    <button style="margin:20px 0;" class="btn waves-effect waves-light right orange lighten-1 btn-success"
                        type="submit">Pay</button>

                </form>
            </div>

        </div>
    </div>



@endsection
