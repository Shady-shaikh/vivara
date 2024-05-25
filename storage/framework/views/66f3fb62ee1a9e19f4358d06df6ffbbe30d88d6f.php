
<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>

    <a href="<?php echo e(url('/')); ?>/user/dashboard" class="btn m-3 btn-secondary">Back</a>


    <h1 style="text-align: center;">My Orders</h1>
    <hr>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Total</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            $i = 1;
            ?>
            <?php if(!empty($invoices)): ?>
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if($row->current_sub_status !="draft" && !empty($row->current_sub_status)): ?>
                    <tr>

                        <td><?php echo e($i); ?></td>
                        <td><?php echo e($row->invoice_number); ?></td>
                        <td><?php echo e($row->date); ?></td>
                        <td><?php echo e($row->total); ?></td>
                        <td><?php echo e($row->balance); ?></td>
                        <td>
                            <a href="<?php echo e(route('invoices.ordersview', ['id' => $row->invoice_id])); ?>" class="btn btn-light btn-sm">
                                View</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php
                    $i++;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>


        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/myorders/orders.blade.php ENDPATH**/ ?>