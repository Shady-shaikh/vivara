<?php $__env->startSection('title'); ?>
Edit Scheme
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
              <li class="breadcrumb-item"><a href="<?php echo e(route('admin.schemes')); ?>">Offers</a></li>
              <li class="breadcrumb-item active" aria-current="page">edit</li>
          </ol>
      </nav>
      <div class="d-flex justify-content-between w-100 flex-wrap">
          <div class="mb-3 mb-lg-0">
              <h1 class="h4">Edit Offer</h1>
          </div>
          <div>
              <a href="<?php echo e(url('admin/schemes')); ?>" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
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
              <?php echo Form::model($schemes, [
                'method' => 'POST',
                'url' => ['admin/schemes/update'],
                'class' => 'form'
            ]); ?>

                                <?php echo e(Form::hidden('coupon_id', $schemes->schemes_id)); ?>

<div class="row">


                <div class="form-group col-lg-12 <?php echo e($errors->has('scheme_title') ? 'has-error' : ''); ?>">
                <?php echo Form::label('scheme_title', 'Scheme Title: ', ['class' => ' control-label']); ?>

                <div class="">
                    <?php echo Form::text('scheme_title', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('scheme_title', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
                <div class="form-group col-md-6 col-lg-6 <?php echo e($errors->has('min_product_qty') ? 'has-error' : ''); ?>">
                <?php echo Form::label('min_product_qty', 'Mininum Product Qty: ', ['class' => ' control-label']); ?>

                <div class="">
                    <?php echo Form::number('min_product_qty', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('min_product_qty', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
            <div class="form-group col-lg-6 col-md-6 <?php echo e($errors->has('free_product_qty') ? 'has-error' : ''); ?>">
                <?php echo Form::label('free_product_qty', 'Free Product Qty: ', ['class' => ' control-label']); ?>

                <div class="">
                    <?php echo Form::number('free_product_qty', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('free_product_qty', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>

            <div class="form-group col-lg-2 col-md-2 col-3 col-sm-2 mt-2">

            <?php echo Form::submit('Update', ['class' => 'btn btn-primary form-control']); ?>


    </div>
    </div>
    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/schemes/edit.blade.php ENDPATH**/ ?>