
<?php $__env->startSection('title'); ?>
    Invoice
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php
        use App\Models\backend\Items;
    ?>

    <a href="<?php echo e(route('admin.invoice')); ?>" class="btn btn-secondary">Back</a>

    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Invoice</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Customer Name</th>
                        <th>Invoice Date</th>
                        
                        <th>Total</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo e($invoice->invoice_number); ?></td>
                        <td><?php echo e($invoice->customer_data->name . ' ' . $invoice->customer_data->last_name); ?></td>
                        <td><?php echo e($invoice->date); ?></td>
                        
                        <td><?php echo e($invoice->total); ?></td>
                        <td><?php echo e($invoice->balance); ?></td>
                    </tr>
                </tbody>
            </table>
            <h5 class="card-subtitle mt-3 text-center">Line Items</h5>
            <hr>
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
                <h6 class="card-text">Total:
                    <?php echo e($invoice->total - ($invoice->tax_amount + $invoice->shipping_charges  ) +  $invoice->discount); ?>

                </h6>
                <h6 class="card-text">Total Tax :
                    <?php echo e($invoice->tax_amount); ?></h6>
                <h6 class="card-text">Shipping Charges : <?php echo e($invoice->shipping_charges); ?></h6>
                <h6 class="card-text">Discount : <?php echo e($invoice->discount); ?></h6>
                <h6 class="card-text">Total Amount: <?php echo e($invoice->total); ?></h6>
                <br>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\vivara\resources\views/backend/invoices/show.blade.php ENDPATH**/ ?>