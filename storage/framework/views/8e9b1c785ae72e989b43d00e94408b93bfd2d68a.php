<?php $__env->startSection('title', 'Forgot Password'); ?>
<?php $__env->startSection('content'); ?>


<style>
    body {
        display: flex;
        align-items: center;
        justify-items: center;
        justify-content: center;
    }

    .login-box {
        background: #fff;
    }

    .btn-block {
        text-transform: uppercase;
        outline: 0;
        background: #004761;
        border: 0;
        padding: 10px;
        color: #ffffff;
        font-size: 14px;
    }

    .form-control {
        outline: 0;
        background: #eff4f9;
        width: 100%;
        border: 0 !important;
        margin: 0 0 15px;
        padding: 10px;
        border-radius: 0px !important;
        box-sizing: border-box;
        font-size: 14px;
    }

</style>

<!-- login -->
<section class="container-fluidcustom top-padding login-page common-space">
    <div class="login-box mt-5">
        <div class="row py-5">
            <div class="col-md-12">
                <div class="container container-custom">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border-login">
                                <div class="login-inner-head">
                                    <h3>Authentication is necessary in order to change password</h3>
                                </div>
                                <div class="using-box py-4">

                                    <div class="row ">
                                        <div class="col-md-12 col-sm-12 col-12">
                                            <div class="login">
                                                <?php echo $__env->make('frontend.includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <form class="login-form form-field" action="<?php echo e(url('/sendotp')); ?>" method="post">
                                                    <?php echo e(csrf_field()); ?>

                                                    <div class="form-group col-md-12">
                                                        <div class="input-wrapper">
                                                            <label for="user">Enter Email <span class="star">*</span></label>
                                                            <input class="password form-control  form-control-h " name="email" type="email" value="<?php echo e(old('email')); ?>" required>

                                                        </div>
                                                        <p class="mb-0 py-1 set-otp">OTP will be sent to your email</p>

                                                    </div>
                                                    <div class="form-group col-md-12 mb-0 terms-conditions-size1">
                                                        <button type="submit" class="success-btn btn-block  text-center " href="#">Submit</button>
                                                        <!-- <button type="submit" class="cancel-btn btn-block mt-4 text-center " href="#">Resend OTP</button> -->
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- login end-->






<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.fullempty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/frontend/account/forgot_password.blade.php ENDPATH**/ ?>