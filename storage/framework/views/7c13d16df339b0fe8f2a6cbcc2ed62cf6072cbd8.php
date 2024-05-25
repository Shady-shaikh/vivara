<?php $__env->startSection('title', 'Update Coupon'); ?>

<?php $__env->startSection('content'); ?>
<?php

?>

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
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.coupon')); ?>">Coupons</a></li>
            <li class="breadcrumb-item active" aria-current="page">edit</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Coupon</h1>
        </div>
        <div>
            <a href="<?php echo e(route('admin.coupon')); ?>" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
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
                      <?php echo Form::model($coupon, [
                        'method' => 'POST',
                        'url' => ['admin/coupon/update'],
                        'class' => 'form'
                    ]); ?>

                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::hidden('coupon_id', $coupon->coupon_id)); ?>

                                <?php echo e(Form::label('coupon_title', 'Coupon Name *')); ?>

                                <?php echo e(Form::text('coupon_title', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Name', 'required' => true])); ?>

                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::label('coupon_code', 'Coupon Code *')); ?>

                                <?php echo e(Form::text('coupon_code', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Code', 'required' => true])); ?>

                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::label('start_date', 'Start Date *')); ?>

                                <?php echo e(Form::date('start_date', null, ['class' => 'form-control pickadate', 'placeholder' => 'Enter Start Date', 'required' => true])); ?>

                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::label('end_date', 'End Date *')); ?>

                                <?php echo e(Form::date('end_date', null, ['class' => 'form-control pickadate', 'placeholder' => 'Enter End Date', 'required' => true])); ?>

                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::label('coupon_type', 'Type *')); ?>

                                <?php echo e(Form::select('coupon_type', ['flat'=>'Flat','percentage'=>'Percentage'], null, ['class'=>'select2 form-control'])); ?>

                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::label('value', 'Coupon Value *')); ?>

                                <?php echo e(Form::text('value', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Value', 'required' => true])); ?>

                              </div>
                            </div>
                            <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::label('coupon_purchase_limit', 'Coupon Purchase Limit *')); ?>

                                <?php echo e(Form::text('coupon_purchase_limit', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Purchase Limit', 'required' => true])); ?>

                              </div>
                            </div>
                            
                            
                            <div class="col-md-6 col-12">
                              <div class="form-group">
                                <?php echo e(Form::label('status', 'Status *')); ?>

                                <?php echo e(Form::select('status', ['0'=>'Active','1'=>'Disable'], null, ['class'=>'select2 form-control'])); ?>

                              </div>
                            </div>
                            
                          <div class="col-12 d-flex justify-content-start mt-2">
                            <!-- <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button> -->
                            <?php echo e(Form::submit('Update', array('class' => 'btn btn-primary mr-1 mb-1'))); ?>

                          </div>
                        </div>
                      </div>
                    <?php echo e(Form::close()); ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/backend/coupon/edit.blade.php ENDPATH**/ ?>