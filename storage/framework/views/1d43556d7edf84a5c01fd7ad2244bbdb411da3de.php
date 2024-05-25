
<?php $__env->startSection('title', 'My Payments'); ?>

<?php $__env->startSection('content'); ?>
 
<a href="<?php echo e(url('/')); ?>/user/dashboard" class="btn m-3 btn-secondary">Back</a>


<h1 style="text-align: center;">My Payments</h1>
<hr>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Items</th>
                <th scope="col">Payment DateTime</th>
                <th scope="col">Amount</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            $i=1;
            ?>
            <?php if(!$data->isEmpty()): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(!empty($row->get_items())): ?>
           <tr>

            <td><?php echo e($i); ?></td>
           
            <td>
                <?php $__currentLoopData = $row->get_items(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php echo e($item->name); ?>

                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
            <td><?php echo e($row->payment_date); ?></td>
            <td><?php echo e($row->amount); ?></td>
            <td>
                <a class="btn btn-light btn-sm" href="<?php echo e(route('payment.view',['id'=>$row->payment_id])); ?>">View</a>
            </td>
           </tr>
           <?php
           $i++;
           ?>
           <?php endif; ?>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           <?php else: ?>
           <td colspan="10" class="text-center">No Payment Has Been Made Yet!</td>
         <?php endif; ?>

        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/payment/index.blade.php ENDPATH**/ ?>