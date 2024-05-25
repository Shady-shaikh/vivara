<?php $__env->startSection('title'); ?>
Edit Shipping Method
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header row">
    <div class="py-4">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
              <li class="breadcrumb-item">
                  <a href="#">
                      <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                  </a>
              </li>
              <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="<?php echo e(route('admin.shipping')); ?>">Shipping</a></li>
              <li class="breadcrumb-item active" aria-current="page">edit</li>
          </ol>
      </nav>
      <div class="d-flex justify-content-between w-100 flex-wrap">
          <div class="mb-3 mb-lg-0">
              <h1 class="h4">Edit Shipping</h1>
          </div>
          <div>
              <a href="<?php echo e(route('admin.shipping')); ?>" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                  Back
              </a>
          </div>
      </div>
  </div>
  </div>


  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <?php echo $__env->make('backend.includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php echo Form::model($shipping, [
                'method' => 'POST',
                'url' => ['admin/shipping/update'],
                'class' => 'form'
            ]); ?>


<?php echo e(Form::hidden('shipping_method_id', $shipping->shipping_method_id)); ?>


<div class="row">


  <div class="form-group col-lg-6 col-md-6">
      <?php echo e(Form::label('shipping_method_name', 'Shipping Method Name')); ?>

      <?php echo e(Form::text('shipping_method_name', Request('shipping_method_name'), array('class' => 'form-control'))); ?>

  </div>
  <div class="form-group col-lg-6 col-md-6">
      <?php echo e(Form::label('shipping_method_code', 'Shipping Method Code')); ?>

      <?php echo e(Form::text('shipping_method_code', Request('shipping_method_code'), array('class' => 'form-control'))); ?>

  </div>
  <div class="form-group col-lg-6 col-md-6">
      <?php echo e(Form::label('shipping_method_cost', 'Shipping Method Cost')); ?>

      <?php echo e(Form::text('shipping_method_cost', Request('shipping_method_cost'), array('class' => 'form-control'))); ?>

  </div>
  <div class="form-group col-lg-6 col-md-6">
      <?php echo e(Form::label('shipping_method_status', 'Active Shipping: ')); ?>

      <?php echo e(Form::select('shipping_method_status', ['1'=>'Yes','0'=>'No'],$shipping->shipping_method_status,['class'=>'form-control'])); ?>

  </div>


  <div class="form-group col-lg-2 col-md-2 col-3 col-sm-2 mt-2">

  <?php echo e(Form::submit('Update', array('class' => 'btn btn-primary'))); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/backend/shipping/edit.blade.php ENDPATH**/ ?>