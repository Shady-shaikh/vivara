<?php
    
    $user_id = Auth()->user()->user_id;
?>

<?php $__env->startSection('title', 'Change Password'); ?>
<?php $__env->startSection('content'); ?>





    <section class="section profile">
        <div class="container-fluid">
            <div class="row px-lg-5 gap-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="navigation">
                            <div class="back mb-5">
                                <a class="d-flex" href="<?php echo e(route('user.dashboard')); ?>">
                                    <i class="fas fa-chevron-left mini-heading"></i>
                                    <h5 class="mini-heading">Go Back</h5>
                                </a>
                            </div>


                            <div class="parameters">

                                <ul class="">
                                    <li class="mb-2"><a class="dropdown-item"
                                            href="<?php echo e(route('user.profile', ['id' => $user_id])); ?>"> Edit Profile</a></li>
                                    <li class="mb-2"><a class="dropdown-item"
                                            href="<?php echo e(route('user.address', ['id' => $user_id])); ?>"> Address</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="<?php echo e(route('myorders.orders')); ?>"> Order
                                            History</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="<?php echo e(route('payment.index')); ?>"> Payment
                                            History</a></li>
                                    <li class="mb-2"><a class="dropdown-item"
                                            href="<?php echo e(route('user.changePassword')); ?>">Change Password</a></li>
                                    <li class="mb-2"><a class="dropdown-item text-danger"
                                            href="<?php echo e(route('user.logout')); ?>">Logout</a></li>
                                </ul>


                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-7">
                    <div class="card">


                        <div class="profile-details">
                            <div class="name mb-5">
                                <h1 class="heading">Change Your Password</h1>
                                
                            </div>

                            <div class="profile-photo mb-5">
                                <h6 class="mini-heading mb-4" style="font-size: 18px;">Password Details</h6>

                            </div>

                            <div class="details-form">
                                <?php echo $__env->make('backend.includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <form class="form" method="POST" action="<?php echo e(route('user.updatePassword')); ?>"
                                    autocomplete="off">
                                    <?php echo e(csrf_field()); ?>


                                    <div class="col-12">
                                        <label>Old Password *</label>
                                        <input type="password" class="form-control" name="old_password"
                                            placeholder="Enter Old Password" required>
                                        <?php echo e(Form::hidden('user_id', $userdata->user_id, ['class' => 'form-control'])); ?>

                                    </div>
                                    
                                    <div class="col-12 mt-2">
                                        <?php echo e(Form::label('new_password', 'New Password *')); ?>

                                        <input type="password" class="form-control" id="new_password" name="new_password"
                                            placeholder="Enter New Password" data-toggle="tooltip" data-placement="top"
                                            title="Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit"
                                            required>
                                        <span style="color:red;font-size: 11px;"><b>Note: </b>Password Must
                                            Contains Atleat 6 Character With One Special Character, Capital
                                            Letter And Digit</span>
                                    </div>


                                    <div class="col-12 mt-2">
                                        <?php echo e(Form::label('password_confirmation', 'Confirm New Password *')); ?>

                                        <input type="password" class="form-control" name="password_confirmation"
                                            placeholder="Enter New Password again" required>
                                    </div>

                                    <div class="col-12 py-4">
                                        <div class="update">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                        </div>
                                    </div>
                                    <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/frontend/users/user_change_password.blade.php ENDPATH**/ ?>