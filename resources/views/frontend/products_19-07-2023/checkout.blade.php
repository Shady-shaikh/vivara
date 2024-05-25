@extends('frontend.layouts.app')
@section('title', 'Checkout Page')


<?php
use App\Models\frontend\Users;
?>

@section('content')



    <a href="{{ url('/cart') }}" class="btn m-3 btn-secondary">Back</a>

    <h1 style="text-align: center;">Checkout Page</h1>


    <div class="container-fluid">
        <div class="row g-5">
            @php
                
            @endphp
            <div class="col-md-5 col-lg-4 order-md-last">

                @csrf
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>

                </h4>

                <?php
                $total_amt = 0;
                $total_quant = 0;
                $final_tax = 0;
                $final_amount = 0;
                ?>


                @if (!empty($item))
                    @foreach ($item as $row)
                        <?php
                        
                        $total_amt += $row->get_items[0]['rate'] * $row->quantity;
                        
                        ?>

                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Item name</h6>
                                </div>
                                <span class="text-body-secondary">{{ $row->get_items[0]->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Rate</h6>
                                </div>
                                <span class="text-body-secondary" id="rate">{{ $row->get_items[0]->rate }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Quantity</h6>
                                </div>
                                <span class="text-body-secondary" id="rate">{{ $row->quantity }}</span>
                            </li>
                        </ul>


                        <?php
                        // dd($row->get_items[0]);
                        $tax_specification = '';
                        $tax_total = 0;
                        
                        $total_amonut_wo_tax = $total_amt;
                        
                        //user data
                        $user_id = Auth()->user()->user_id;
                        $customer_data = Users::where('user_id', $user_id)->first();
                        // dd($customer_data);
                        
                        //org data
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
                            $taxt_amount = ($total_amonut_wo_tax * $row->get_items[0]->intra_tax_percent) / 100;
                            $total_amount_w_tax = $total_amonut_wo_tax + $taxt_amount;
                        } elseif ($tax_specification == 'inter') {
                            $taxt_amount = ($total_amonut_wo_tax * $row->get_items[0]->inter_tax_percent) / 100;
                            $total_amount_w_tax = $total_amonut_wo_tax + $taxt_amount;
                        }
                        
                        // echo $final_tax . ' : ' . $final_amount;
                        
                        ?>
                    @endforeach
                @endif

                <?php
                $final_tax += $taxt_amount;
                $final_amount += $total_amount_w_tax;
                // dd($final_tax , $final_amount);
                ?>


                Total : {{ $total_amonut_wo_tax }}
                <br>
                Total Tax: {{ $final_tax }}
                <br>
                After Tax Amount : <b>{{ $final_amount }}</b>
                <br>
                <form id="coupon-form" action="{{ route('products.getdiscountedamount') }}" method='POST'>
                    @csrf
                    <input type="text" name="coupon" class="form-control w-50" placeholder="Enter Coupon Code"
                        value="{{ session('code') }}">
                    <input type="hidden" name="amount" value="<?= $total_amount_w_tax ?>">
                    <button type="submit" class="btn btn-sm mt-2 btn-primary">Verify</button>
                </form>
                <br>
                Amount To Pay: <b><?= session('data') ?? $total_amount_w_tax ?></b>




                <?php $product_info = trim($item, ', '); ?>
                <form
                    action="{{ route('products.payment', ['id' => $customer_data->contact_id, 'item_id' => $item_data]) }}"
                    method="POST" name="payuForm">

                    @csrf
                    <input type="hidden" name="key" value="<?php echo 'rjQUPktU'; ?>" />
                    <input type="hidden" name="hash" value="" />
                    <input type="hidden" name="txnid" value="<?= $increment_id ?>" />
                    <input type="hidden" name="udf1" value="<?php echo $customer_data->contact_id; ?>" />
                    <input type="hidden" name="udf2" value="<?php echo $item_data; ?>" />
                    <input type="hidden" name="udf3" value="<?php echo (float) session('discount') ?? 0 ; ?>" />
                    <input type="hidden" name="udf4" value="<?php echo $check ?? '' ; ?>" />
                    <input type="hidden" name="amount" value="<?php echo (float) !empty(session('data'))?session('data'):$total_amount_w_tax; ?>" />
                    <input type="hidden" name="firstname" id="firstname" value="{{ trim($customer_data->name) }}" />
                    <input type="hidden" name="email" id="email" value="{{ $customer_data->email }}" />
                    <input type="hidden" name="phone" value="{{ $customer_data->mobile_no }}" />
                    <textarea style="display:none;" name="productinfo">Test</textarea>
                    <input type="hidden" name="surl" value="{{ route('products.payment_success') }}" size="64" />
                    <input type="hidden" name="furl" value="{{ route('products.payment_failure') }}" size="64" />
                    <input type="hidden" name="service_provider" value="payu_paisa" size="64" />



                    <button style="margin:20px 0;" class="btn waves-effect waves-light right orange lighten-1 btn-success"
                        type="submit">Pay</button>

                </form>

            </div>


            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">First name</label>
                        <input type="text" class="form-control" id="firstName" placeholder=""
                            value="{{ $customer_data->name }}" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="lastName" placeholder=""
                            value="{{ $customer_data->last_name }}" readonly>

                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email <span
                                class="text-body-secondary">(Optional)</span></label>
                        <input type="email" class="form-control" id="email" value="{{ $customer_data->email }}"
                            readonly>

                    </div>

                    <div class="col-12">
                        <label for="mobile" class="form-label">Mobile </label>
                        <input type="text" class="form-control" id="mobile"
                            value="{{ $customer_data->mobile_no }}" readonly>

                    </div>





                </div>

                <hr class="my-4">

                <h4 class="mb-3">Payment</h4>

                <div class="my-3">
                    <div class="form-check">
                        <input id="credit" name="paymentMethod" type="radio" class="form-check-input"
                            checked="">
                        <label class="form-check-label" for="credit">Online</label>
                    </div>
                </div>




            </div>
        </div>
    </div>



@endsection
