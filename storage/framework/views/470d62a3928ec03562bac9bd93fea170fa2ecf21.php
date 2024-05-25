
<?php $__env->startSection('title', 'View Orders'); ?>

<?php $__env->startSection('content'); ?>

    <?php
        use App\Models\backend\Items;
    ?>

    <a href="<?php echo e(route('myorders.orders')); ?>" class="btn m-3 btn-secondary">Back</a>


    <h1 style="text-align: center;">Orders</h1>


    <div class="card">
        <div class="card-header">
            Invoice Details
        </div>
        <div class="card-body">
            
            <h5 class="card-title">Invoice Number: <?php echo e($invoice->invoice_number); ?></h5>
            <p class="card-text">Customer: <?php echo e($invoice->customer_data->name . ' ' . $invoice->customer_data->last_name); ?></p>
            
            <p class="card-text">Invoice Date: <?php echo e($invoice->date); ?></p>
            

            <h3 class="card-subtitle mt-3">Line Items:</h3>
            <ul class="list-group">

                <?php
                $quantity_arr = explode(',', $invoice->quantity);
                $item_arr = explode(',', $invoice->item_id);
                $rate_arr = explode(',', $invoice->rate);
                $i = 0;
                ?>
                
                <?php $__currentLoopData = $item_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($row)): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Item Name:
                                <?php
                                    $item = Items::where('item_id', $row)->first();
                                    echo $item->name;
                                ?>
                            &nbsp;&nbsp;
                            <?php if(!empty($item->item_image)): ?>
                              <a href="<?php echo e(asset('/public/frontend-assets/images/').'/'.$item->item_image); ?>" target="_blank">
                              <img src="<?php echo e(asset('/public/frontend-assets/images/').'/'.$item->item_image); ?>" alt="No-Image" style='width:50px;'>
                              </a>
                            <?php endif; ?>
                            </span>
                            <span>Quantity: <?php echo e($quantity_arr[$i]); ?></span>
                            <span>Rate:
                                <?php if($rate_arr[$i] == 0): ?>
                                    <?php echo e('Free'); ?>

                                <?php else: ?>
                                    <?php echo e($rate_arr[$i]); ?>

                                <?php endif; ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <?php
                    $i++;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>
            <div class="text-center mt-3">
                <h4 class="card-text">Total:
                    <?php echo e($invoice->total - ($invoice->tax_amount + $invoice->shipping_charges  ) +  $invoice->discount); ?>

                </h4>
                <h4 class="card-text">Total Tax :
                    <?php echo e($invoice->tax_amount); ?></h4>
                <h4 class="card-text">Shipping Charges : <?php echo e($invoice->shipping_charges); ?></h4>
                <h4 class="card-text">Discount : <?php echo e($invoice->discount); ?></h4>
                <h4 class="card-text">Total Amount: <?php echo e($invoice->total); ?></h4>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/frontend/myorders/ordersview.blade.php ENDPATH**/ ?>