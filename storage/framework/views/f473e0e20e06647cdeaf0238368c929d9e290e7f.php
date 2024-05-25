<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <title><?php echo $__env->yieldContent('title'); ?></title>
  <?php echo $__env->make('backend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/backend-assets/assets/css/fontawesome/all.min.css')); ?>"
    referrerpolicy="no-referrer" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo e(asset('public/backend-assets/login.css')); ?>">
  <link rel=" stylesheet" type="text/css" href="<?php echo e(asset('public/frontend-assets/css/toastr.min.css')); ?>">

</head>

<body>

  <?php echo $__env->yieldContent('content'); ?>

  <?php echo $__env->make('frontend.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->yieldContent('scripts'); ?>
  <script src="<?php echo e(asset('public/backend-assets/assets/js/jquery-3.6.1.min.js')); ?>" crossorigin="anonymous"></script>
  <script src="<?php echo e(asset('public/backend-assets/assets/js/query-3.3.1.slim.min.js')); ?>" crossorigin="anonymous"></script>
  <script src="<?php echo e(asset('public/backend-assets/assets/js/popper.min.js')); ?>" crossorigin="anonymous"></script>
  <script src="<?php echo e(asset('public/backend-assets/assets/js/bootstrap.min.js')); ?>" crossorigin="anonymous"></script>

  <script src="<?php echo e(asset('public/frontend-assets/js/toastr.min.js')); ?>"></script>
</body>


</html><?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/layouts/fullempty.blade.php ENDPATH**/ ?>