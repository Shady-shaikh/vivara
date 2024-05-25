
<?php $__env->startSection('title', 'My Cart'); ?>

<?php
use App\Models\frontend\Users;
use App\Models\backend\Shipping;
?>

<?php $__env->startSection('content'); ?>

    <section class="section my-cart">

        <div class="container-fluid px-lg-5">

            <div class="heading-box mb-5">
                <h1 class="heading">My cart</h1>
            </div>

            <div class="row my-3">

                <div class="col-md-7">
                    <form action="<?php echo e(route('cart.update')); ?>" method="post">
                        <?php echo csrf_field(); ?>
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
                            <?php if(!$availableItems->isEmpty()): ?>
                                <?php $__currentLoopData = $availableItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!empty($row->get_items)): ?>
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
                                                        <?php if(!empty($row->item_image)): ?>
                                                            <img src="<?php echo e(asset('/public/frontend-assets/images/') . '/' . $row->item_image); ?>"
                                                                alt="">
                                                        <?php else: ?>
                                                            <img src="<?php echo e(asset('/public/frontend-assets/images/') . '/' . 'demo_image.png'); ?> "
                                                                alt="" style="width:100px;" />
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="col-md-7">
                                                        <div class="product-details">
                                                            <h6 class="mb-2 mini-heading"><?php echo e($row->get_items[0]['name']); ?>

                                                                <?php if(!empty($row->scheme_title)): ?>
                                                                    <?php echo e(' (' . $row->scheme_title . ')'); ?>

                                                                <?php endif; ?>
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Category :
                                                                <span><?php echo e($row->category ?? ''); ?></span>
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Color :
                                                                <span><?php echo e($row->variant ?? ''); ?></span>
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Size :
                                                                <span><?php echo e(!empty($row->size) ? $row->size : 'None'); ?></span>
                                                            </h6>
                                                            <h6 class="mb-1 mini-subheading">Rate :
                                                                <span><?php echo e($row->get_items[0]['rate']); ?>/-</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <h6 class="mb-2 mini-heading">Each</h6>
                                                <h6 id="rate"><b>&#8377;
                                                        &nbsp;&nbsp;<?php echo e($row->get_items[0]['rate']); ?>/-</b></h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h6 class="mb-2 mini-heading">Quantity</h6>

                                                <div class="increment d-flex">
                                                    <input type="number" name="quantity[]" value="<?php echo e($row->quantity); ?>"
                                                        class="form-group " id="quantityInput"
                                                        oninput="this.value = Math.max(0, this.value);"
                                                        style="width: 100px;">
                                                    <input type="hidden" name="item_id[]" value="<?php echo e($row->item_id); ?>">
                                                </div>


                                            </div>
                                            <div class="text-center">
                                                <a href="<?php echo e(route('cart.destroy', ['id' => $row->cart_id])); ?>"
                                                    class="btn btn-danger btn-sm" style="width:40px;"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                        <hr>
                                        <?php
                                        $i++;
                                        ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php
                                $final_tax += $taxt_amount;
                                $final_amount += $total_amount_w_tax;
                                // dd($final_tax , $final_amount);
                                ?>

                                <?php if(!$availableItems->isEmpty()): ?>
                                    <?php
                                    $items = implode(',', $items);
                                    ?>
                                    <div class="text-center">
                                        Total Amount:
                                        <input type="text"
                                            style="width: 75px;border:none;outline:none;background-color:transparent;"
                                            value=" <?php echo e($total_amt); ?>" readonly>
                                        <button type="submit" class="btn  btn-success">Update</button>
                                    </div>
                    </form>
                    <?php endif; ?>
                <?php else: ?>
                    <td colspan="10" class="text-center">Cart is empty!</td>
                    <?php endif; ?>




                </div>



            </div>
            <div class="col-md-5 px-lg-4">
                <?php if(!empty($items)): ?>
                    <div class="card">



                        <div class="cupoun">
                            <h5 class="mini-heading my-4">Coupon</h5>
                            <form id="coupon-form" action="<?php echo e(route('products.getdiscountedamount')); ?>" method='POST'>
                                <?php echo csrf_field(); ?>
                                <div class="cupouns d-flex mt-2">
                                    <div class="cupoun-box">
                                        <input type="text" name="coupon" id="cupoun" placeholder="Enter coupon code"
                                            value="<?php echo e(session('code')); ?>">
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
                        <?php
                            $final_amount = session('data') ?? $total_amount_w_tax;
                        ?>




                        <?php $product_info = trim($availableItems, ', '); ?>
                        <form
                            action="<?php echo e(route('products.payment', ['id' => $customer_data->contact_id, 'item_id' => $items])); ?>"
                            method="POST" name="payuForm">

                            <?php echo csrf_field(); ?>
                            <?php
                                $shipping_data = Shipping::where('shipping_method_status', 1)->get();
                                $selected_shipping_method = old('shipping_charges', session('shipping_charges'));
                            ?>

                            <div class="cupoun mb-5">
                                <h5 class="mini-heading my-4">Select Shipping Method</h5>

                                <div class="cupouns d-flex">
                                    <select name="shipping_charges" class="cupoun-box" id="shipping_charges" required>
                                        <option value="">Select Method</option>
                                        <?php $__currentLoopData = $shipping_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping_method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($shipping_method->shipping_method_id); ?>"
                                                <?php echo e($selected_shipping_method == $shipping_method->shipping_method_id ? 'selected' : ''); ?>>
                                                <?php echo e($shipping_method->shipping_method_name); ?> - [Charge:
                                                <?php echo e($shipping_method->shipping_method_cost); ?> ]
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    value="<?php echo e(trim($customer_data->name)); ?>" />
                                <input type="hidden" name="email" id="email"
                                    value="<?php echo e($customer_data->email); ?>" />
                                <input type="hidden" name="phone" value="<?php echo e($customer_data->mobile_no); ?>" />
                                <textarea style="display:none;" name="productinfo">Test</textarea>
                                <input type="hidden" name="surl" value="<?php echo e(route('products.payment_success')); ?>"
                                    size="64" />
                                <input type="hidden" name="furl" value="<?php echo e(route('products.payment_failure')); ?>"
                                    size="64" />
                                <input type="hidden" name="service_provider" value="payu_paisa" size="64" />



                                




                                <div class="cost-details d-flex mb-2 mt-5">
                                    <h6>Shipping Cost</h6>
                                    <h6><b class="ship_charge">0</b></h6>
                                </div>
                                <div class="cost-details d-flex mb-2 ">
                                    <h6>Discount</h6>
                                    <h6><b><?php echo e(session('discount') ?? 0); ?></b></h6>
                                </div>
                                <div class="cost-details d-flex mb-2">
                                    <h6>Tax</h6>
                                    <h6><b><?php echo e($final_tax); ?></b></h6>
                                </div>
                                <div class="cost-details d-flex">
                                    <h6><b>Estimated Total</b></h6>
                                    <h6> <b id="final_amount_s">
                                            <?php echo e(round($final_amount, 2)); ?>

                                        </b></h6>
                                </div>

                                <hr class="my-4">

                                
                                <button type="submit" class="checkout">
                                    <span>Pay</span>&nbsp;
                                    <i class="fal fa-long-arrow-right"></i>
                                </button>

                        </form>

                    </div>
                <?php endif; ?>

            </div>

        </div>
        </div>


    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/cart/index.blade.php ENDPATH**/ ?>