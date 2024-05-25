<?php
// use Session;
?>
<script>
  // toastr.success("aW32aqlksajdflkajsdf");
  
  <?php if(Session::has('success')): ?>
  
  toastr.success("<?php echo e(Session::get('success')); ?>");
      // alert('test');
  <?php endif; ?>


  <?php if(Session::has('info')): ?>

  		toastr.info("<?php echo e(Session::get('info')); ?>");

  <?php endif; ?>


  <?php if(Session::has('warning')): ?>

  		toastr.warning("<?php echo e(Session::get('warning')); ?>");

  <?php endif; ?>


  <?php if(Session::has('error')): ?>

  		toastr.error("<?php echo e(Session::get('error')); ?>");

  <?php endif; ?>

  <?php if(Session::has('message')): ?>
  // alert('msg');
  		toastr.info("<?php echo e(Session::get('message')); ?>");

  <?php endif; ?>

</script><?php /**PATH /home/parasigh/public_html/vivara/resources/views/frontend/includes/alerts.blade.php ENDPATH**/ ?>