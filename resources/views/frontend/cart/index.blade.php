@extends('frontend.layouts.app')
@section('title', 'My Cart')

<?php
use App\Models\frontend\Users;
use App\Models\backend\Shipping;
?>

@section('content')

    <section class="section my-cart">

        <div class="container-fluid px-lg-5">

            <div class="heading-box mb-5">
                <h1 class="heading">My cart</h1>
            </div>

            <div class="row my-3">

                <div class="col-md-7">
                    <form action="{{ route('cart.update') }}" method="post">
                        @csrf
                        <div class="card">

                            <?php
                            $increment_id = substr(md5(microtime()), rand(0, 20), 20);
                            $total_amt = 0;
                            $total_quant = 0;
                            $final_tax = 0;
                            $final_amount = 0;
                            $total_amount_w_tax = [];
                            $i = 1;
                            $items = [];
                            ?>
                            @if (!$availableItems->isEmpty())
                                @foreach ($availableItems as $row)
                                    @if (!empty($row->get_items))
                                        <?php
                                        
                                        $total_amt += $row->get_items[0]['rate'] * $row->quantity;
                                        
                                        $items[] = $row->item_id;
                                        ?>

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
                                            // dd($row->get_items[0]->intra_tax_percent);
                                            $taxt_amount = ($total_amonut_wo_tax * $row->get_items[0]->inter_tax_percent) / 100;
                                            $total_amount_w_tax = $total_amonut_wo_tax + $taxt_amount;
                                        }
                                        
                                        // echo $final_tax . ' : ' . $final_amount;
                                        
                                        ?>

                                        <div class="row my-4">
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        @if (!empty($row->item_image))
                                                            <img src="{{ asset('/public/frontend-assets/images/') . '/' . $row->item_image }}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('/public/frontend-assets/images/') . '/' . 'demo_image.png' }} "
                                                                alt="" style="width:100px;" />
                                                        @endif
                                                    </div>

                                                    <div class="col-md-7">
                                                        <div class="product-details">
                                                            <h6 class="mb-2 mini-heading">{{ $row->get_items[0]['name'] }}
                                                                @if (!empty($row->scheme_title))
                                                                    {{ ' (' . $row->scheme_title . ')' }}
                                                                @endif
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Category :
                                                                <span>{{ $row->category ?? '' }}</span>
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Color :
                                                                <span>{{ $row->variant ?? '' }}</span>
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Size :
                                                                <span>{{ !empty($row->size) ? $row->size : 'None' }}</span>
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Rate :
                                                                <span>{{ $row->get_items[0]['rate'] }}/-</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <h6 class="mb-2 mini-heading">Each</h6>
                                                <h6 id="rate"><b>&#8377;
                                                        &nbsp;&nbsp;{{ $row->get_items[0]['rate'] }}/-</b></h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h6 class="mb-2 mini-heading">Quantity</h6>

                                                <div class="increment d-flex">
                                                    <input type="number" name="quantity[]" value="{{ $row->quantity }}"
                                                        class="form-group " id="quantityInput"
                                                        oninput="this.value = Math.max(0, this.value);"
                                                        style="width: 100px;">
                                                    <input type="hidden" name="item_id[]" value="{{ $row->item_id }}">
                                                </div>


                                            </div>
                                            <div class="text-center">
                                                <a href="{{ route('cart.destroy', ['id' => $row->cart_id]) }}"
                                                    class="btn btn-danger btn-sm" style="width:40px;"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                        <hr>
                                        <?php
                                        $i++;
                                        ?>
                                    @endif
                                @endforeach

                                <?php
                                $final_tax += $taxt_amount;
                                $final_amount += $total_amount_w_tax;
                                // dd($final_tax , $final_amount);
                                ?>

                                @if (!$availableItems->isEmpty())
                                    <?php
                                    $items = implode(',', $items);
                                    ?>
                                    <div class="text-center">
                                        Total Amount:
                                        <input type="text"
                                            style="width: 75px;border:none;outline:none;background-color:transparent;"
                                            value=" {{ $total_amt }}" readonly>
                                        <button type="submit" class="btn  btn-success">Update</button>
                                    </div>
                    </form>
                    @endif
                @else
                    <td colspan="10" class="text-center">Cart is empty!</td>
                    @endif




                </div>



            </div>
            <div class="col-md-5 px-lg-4">
                @if (!empty($items))
                    <div class="card">



                        <div class="cupoun">
                            <h5 class="mini-heading my-4">Coupon</h5>
                            <form id="coupon-form" action="{{ route('products.getdiscountedamount') }}" method='POST'>
                                @csrf
                                <div class="cupouns d-flex mt-2">
                                    <div class="cupoun-box">
                                        <input type="text" name="coupon" id="cupoun" placeholder="Enter coupon code"
                                            value="{{ session('code') }}">
                                        <input type="hidden" name="amount" value="<?= $total_amount_w_tax ?>">
                                        <label for="cupoun">
                                            <button type="submit" style="outline:none;border:none;background:none;">
                                                <span>Apply</span>
                                            </button>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @php
                            $final_amount = session('data') ?? $total_amount_w_tax;
                        @endphp




                        <?php $product_info = trim($availableItems, ', '); ?>
                        <form
                            action="{{ route('products.payment', ['id' => $customer_data->contact_id, 'item_id' => $items]) }}"
                            method="POST" name="payuForm">

                            @csrf
                            @php
                                $shipping_data = Shipping::where('shipping_method_status', 1)->get();
                                $selected_shipping_method = old('shipping_charges', session('shipping_charges'));
                            @endphp

                            <div class="cupoun mb-5">
                                <h5 class="mini-heading my-4">Select Shipping Method</h5>

                                <div class="cupouns d-flex">
                                    <select name="shipping_charges" class="cupoun-box" id="shipping_charges" required>
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



                                <input type="hidden" name="key" value="<?php echo 'rjQUPktU'; ?>" />
                                <input type="hidden" name="hash" value="" />
                                <input type="hidden" name="txnid" value="<?= $increment_id ?>" />
                                <input type="hidden" name="udf1" value="<?php echo $customer_data->contact_id; ?>" />
                                <input type="hidden" name="udf2" value="<?php echo $items; ?>" />
                                <input type="hidden" name="udf3" value="<?php echo (float) session('discount') ?? 0; ?>" />
                                <input type="hidden" name="udf4" value="c" />
                                <input type="hidden" name="udf5" class="ship_charge" value="0" />
                                <input type="hidden" name="amount" class="final_amount"
                                    value="<?php echo (float) $final_amount; ?>" />
                                <input type="hidden" name="firstname" id="firstname"
                                    value="{{ trim($customer_data->name) }}" />
                                <input type="hidden" name="email" id="email"
                                    value="{{ $customer_data->email }}" />
                                <input type="hidden" name="phone" value="{{ $customer_data->mobile_no }}" />
                                <textarea style="display:none;" name="productinfo">Test</textarea>
                                <input type="hidden" name="surl" value="{{ route('products.payment_success') }}"
                                    size="64" />
                                <input type="hidden" name="furl" value="{{ route('products.payment_failure') }}"
                                    size="64" />
                                <input type="hidden" name="service_provider" value="payu_paisa" size="64" />



                                {{-- <button style="margin:20px 0;"
                                class="btn waves-effect waves-light right orange lighten-1 btn-success"
                                type="submit">Pay</button> --}}




                                <div class="cost-details d-flex mb-2 mt-5">
                                    <h6>Shipping Cost</h6>
                                    <h6><b class="ship_charge">0</b></h6>
                                </div>
                                <div class="cost-details d-flex mb-2 ">
                                    <h6>Discount</h6>
                                    <h6><b>{{ session('discount') ?? 0 }}</b></h6>
                                </div>
                                <div class="cost-details d-flex mb-2">
                                    <h6>Tax</h6>
                                    <h6><b>{{ $final_tax }}</b></h6>
                                </div>
                                <div class="cost-details d-flex">
                                    <h6><b>Estimated Total</b></h6>
                                    <h6> <b id="final_amount_s">
                                            {{ round($final_amount, 2) }}
                                        </b></h6>
                                </div>

                                <hr class="my-4">

                                {{-- <div class="checkout mb-4">
                                <a href="">
                                    <span>Check Out</span>
                                    <i class="fal fa-long-arrow-right"></i>
                                </a>
                            </div> --}}
                                <button type="submit" class="checkout">
                                    <span>Pay</span>&nbsp;
                                    <i class="fal fa-long-arrow-right"></i>
                                </button>

                        </form>

                    </div>
                @endif

            </div>

        </div>
        </div>


    </section>
@endsection
