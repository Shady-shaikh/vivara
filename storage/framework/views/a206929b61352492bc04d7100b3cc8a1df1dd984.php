<?php $__env->startSection('title',$product_listing_title); ?>
<?php $__env->startSection('content'); ?>

<!-- Product details start -->
  <div class="container-fluidcustom top-padding container-myaccounts">
    <!-- <div class="images-box"> -->
      <div class="row pt-4">
        <div class=" col-md-12 col-sm-12 col-12">

          <h1 class="inner-title text-center"><?php echo e($page_content->cms_pages_title); ?></h1>
          <hr class="terms-hr">
          <div class="container mt-3 pb-5 contain-full">
            
            <div class="row">
              <?php if($page_content->contactus_form_flag == 1): ?>
              <div class="col-lg-6 col-md-6 col-sm-6 col-12 padd-left">
                <?php echo $page_content->cms_pages_content; ?>

              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-12 padd-right">
                <div class=" pt-4">
                  <h5 class="contact-head1">Submit your query</h5>
                </div>
                <p class="mandatory-fields text-right"><span class="star">*</span>All fields are mandatory</p>


              <form class="contact-form form-field" action="<?php echo e(route('pages.contactus')); ?>" method="post" onsubmit="return mycontact()">
                  <?php echo e(csrf_field()); ?>

                <div class="row">
                <div class="form-group  col-md-12 pb-3">
                <div class="input-wrapper">
                  <input class="form-control form-control-h" type="text" name="name" required>
                  <label class="contfirst-label" for="user">Full Name <span class="star">*</span></label>
                </div>
                </div>

                <div class="form-group col-md-12 pb-3">
                <div class="input-wrapper">
                <input class="form-control form-control-h" type="email" name="email" required>
                <label for="user">Email ID <span class="star">*</span></label>
                </div>
                </div>

                <div class="form-group col-md-12 pb-3">
                <div class="input-wrapper">
                <input class="form-control form-control-h" name="mobile_no" type="text" id="mobnumber" minlength="10" maxlength="10" inputmode="numeric" pattern="[0-9]*" required>

                <label for="user">Mobile Phone Number <span class="star">*</span></label>
                <span class="number-msg" id="messages"></span>
                </div>
                
                </div>

                <div class="form-group col-md-6 pb-3">
                <div class="input-wrapper">
                <input class="form-control form-control-h" type="text" name="order_no" required>
                <label for="user">Order Number <span class="star">*</span></label>
                </div>
                </div>

                <div class="form-group col-md-6 pb-3">
                <div class="input-wrapper select-arrrow">
                <!-- <input class="form-control form-control-h" type="text"  required> -->
                <select class="form-control form-control-h " name="issue" required>
                  <!-- <option class="select-star" selected hidden></option> -->
                  <option value="" hidden=""></option>
                  <option value="Account Related">Account Related</option>
                  <option value="Coupons Related">Coupons Related</option>
                  <option value="Offers Related">Offers Related</option>
                  <option value="Order Related">Order Related</option>
                  <option value="Order Cancellation Related">Order Cancellation Related</option>
                  <option value="Product Return Related">Product Return Related</option>
                  <option value="Refund Related">Refund Related</option>
                  <option value="Others">Others</option>

                </select>
                <label for="user">Select Issue <span class="star">*</span></label>

                </div>
                </div>

                <div class="form-group col-md-12 pb-3">
                   <div class="input-wrapper">
                   <textarea class="form-control " name="comment" rows="2" required=""></textarea>
                   <label for="user">Write Comment Here <span class="star">*</span></label>
                   </div>
                </div>
                </div>

                <input type="hidden" name="recaptcha_response" id="recaptchaResponse" value="03AGdBq261Wc1FM2u3RojhKGilsluD8icOPc8Gb97-zezqYVv_DR1HDocozMVJt3tnB5Pg4cykE5W5vPn-QRg8NzAK0rESFAzfmDepqnHjD6jY1uB8vrMgX8vv8DpUIDsIzbxn2wRQ0Bxf47Xv96MCI-ByhigfbFqtKtxUMNx6xJSSfITa1uC3wfvOqPB0tCGx3KbqynhEKd3_3rNRqHYJ4JcLdCcsECZd9ZuCZ8o9OIfyzMSHC1QZ2pLyo9W-0ceHHRBZaibMdFUylxRL0xGp9P1Tgpl-e2gjzWSC0tPDyjDtKJJmgRDqCYLPbXUPeWGwn4ZvnHIDDFsUt0oI2DYxGPNbQpnNj5XowLUh8n3WR6MqfcS34pziFGJudGw__CL0icpuAz1k8ATeVpNGmKQefFW15zdTOadXsHcgdnrjJjBfY_jx89UXN-Ya5RV9hFPEiMVjdt4fp_pTstp73t7fUsE5-0a6BzVxSA">

              <button type="submit" class="contact-btn">SUBMIT</button>
              </form>
              <script>
                   grecaptcha.ready(function() {
                      grecaptcha.execute('6LdEIBAaAAAAAKfBjn8xfjhX_Z9vfeYFzbShZjky', {action: 'submit'}).then(function(token) {
                         var recaptchaResponse = document.getElementById('recaptchaResponse');
                         recaptchaResponse.value = token;
                      });
                   });
                </script>
            </div>
              <?php else: ?>
                <?php echo $page_content->cms_pages_content; ?>

              <?php endif; ?>
            </div>

          </div>
        </div>

     </div>
    <!-- </div> -->
 </div>
<!-- Product details end -->






<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/pages/index.blade.php ENDPATH**/ ?>