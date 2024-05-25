@extends('frontend.layouts.app')
@section('title', 'Summary')

<?php
use App\Models\frontend\Users;
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
                        $user_id = Auth()->user()->user_id;
                        $customer_data = Users::where('user_id', $user_id)->first();
                        // dd($customer_data);
                        
                        //org data
                        // $zohoBooks = get_all_modules_zoho();
                        // $org_data = $zohoBooks->organizations->get(env('ZOHO_ORGANIZATION_ID'));
                        $data = DB::table('organization')->get();
                        
                        $user_state = $customer_data->state;
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
                                <form id="coupon-form" action="{{ route('products.getdiscountedamount') }}"
                                    method='POST'>
                                    @csrf
                                    <input type="text" name="coupon" class="form-control w-25"
                                        placeholder="Enter Coupon Code" value="{{ session('code') }}">
                                    <input type="hidden" name="amount" value="<?= $total_amount_w_tax ?>">
                                    <button type="submit" class="btn btn-sm mt-2 btn-primary">Verify</button>
                                </form>
                            </td>
                        </tr>


                        <tr>
                            <td class="right-block"><strong>Final Amount (After Discount)</strong></td>
                            <td><strong><i class="fa fa-inr" aria-hidden="true"></i>
                                    <?= session('data') ?? $total_amount_w_tax ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            </div>
        </div>

        <?php $product_info = trim($item_details, ', '); ?>
        <form
            action="{{ route('products.payment', ['id' => $user_details->contact_id, 'item_id' => $item_details->item_id]) }}"
            method="POST" name="payuForm">

            @csrf
            <input type="hidden" name="key" value="<?php echo 'rjQUPktU'; ?>" />
            <input type="hidden" name="hash" value="" />
            <input type="hidden" name="txnid" value="<?= $increment_id ?>" />
            <input type="hidden" name="udf1" value="<?php echo $user_details->contact_id; ?>" />
            <input type="hidden" name="udf2" value="<?php echo $item_details->item_id; ?>" />
            <input type="hidden" name="udf3" value="<?php echo (float) session('discount') ?? 0 ; ?>" />
            <input type="hidden" name="udf4" value="<?php echo $check ?? '' ; ?>" />
            <input type="hidden" name="amount" value="<?php echo (float) !empty(session('data'))?session('data'):$total_amount_w_tax; ?>" />
            <input type="hidden" name="firstname" id="firstname" value="{{ trim($user_details->name) }}" />
            <input type="hidden" name="email" id="email" value="{{ $user_details->email }}" />
            <input type="hidden" name="phone" value="{{ $user_details->mobile_no }}" />
            <textarea style="display:none;" name="productinfo">Test</textarea>
            <input type="hidden" name="surl" value="{{ route('products.payment_success') }}" size="64" />
            <input type="hidden" name="furl" value="{{ route('products.payment_failure') }}" size="64" />
            <input type="hidden" name="service_provider" value="payu_paisa" size="64" />


            <a href="{{ route('products.index') }}" style="margin:20px 0;" class="btn btn-md btn-dark btn-danger">Back</a>

            <button style="margin:20px 0;" class="btn waves-effect waves-light right orange lighten-1 btn-success"
                type="submit">Pay</button>

        </form>
    </div>





@endsection
