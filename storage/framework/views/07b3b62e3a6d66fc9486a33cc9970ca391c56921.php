<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>

<a href="<?php echo e(url('/payment')); ?>" class="btn m-3 btn-secondary">Back</a>




<div class="container-fluid">
    <div class="my-3 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">View Payment</h6>
    <div class="pt-3 border-bottom">
      <p class="pb-3 mb-0 small ">
        <strong class="d-block text-gray-dark">Items Name</strong>
        <?php $__currentLoopData = $item->get_items(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($row->name); ?>

            <br>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </p>

    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Transaction ID</strong>
        <?php echo e($item->transaction_id); ?>

      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Amount</strong>
        <?php echo e($item->amount); ?>

      </p>
    </div>
    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Date</strong>
        <?php echo e($item->payment_date); ?>

      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
        <p class="pb-3 mb-0 small lh-sm border-bottom">
          <strong class="d-block text-gray-dark">status</strong>
          <?php echo e($item->status); ?>

        </p>
    </div>




  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/payment/view.blade.php ENDPATH**/ ?>