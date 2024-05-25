<?php $__env->startSection('title'); ?>
    Invoice
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <a href="<?php echo e(route('admin.reports')); ?>" class="btn btn-secondary">Back</a>

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
                        <th>Due Date</th>
                        <th>Total</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo e($invoice->invoice_number); ?></td>
                        <td><?php echo e($invoice->customer_data->name . " ".$invoice->customer_data->last_name); ?></td>
                        <td><?php echo e($invoice->date); ?></td>
                        <td><?php echo e($invoice->date); ?></td>
                        <td><?php echo e($invoice->total); ?></td>
                        <td><?php echo e($invoice->balance); ?></td>
                    </tr>
                </tbody>
            </table>

            <h3 class="card-subtitle text-center mt-3">Items Details</h3>
            <ul class="list-group">

                <?php
                $quantity_arr = explode(',', $invoice->quantity);
                $i = 0;
                ?>
                
                <?php $__currentLoopData = $invoice->item_data(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <hr>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Item Name: <?php echo e($row->name); ?></span>
                        <span>Unit: <?php echo e($row->unit); ?></span>
                        <span>Quantity: <?php echo e($quantity_arr[$i]); ?></span>
                        <span>Rate: <?php echo e($row->rate); ?></span>
                    </li>
                    <?php
                    $i++;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/backend/reports/show.blade.php ENDPATH**/ ?>