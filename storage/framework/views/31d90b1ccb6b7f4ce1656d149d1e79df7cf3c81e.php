<?php
use App\Models\frontend\Department;
use App\Models\backend\Company;
use App\Models\backend\Designation;
use App\Models\backend\Location;
?>

<?php $__env->startSection('title', 'Edit Profile'); ?>
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
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Edit Profile</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Profile</h1>
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
                        <?php echo Form::model($adminuser, [
                        'method' => 'POST',
                        'url' => ['admin/update_profile'],
                        'class' => 'form'
                        ]); ?>

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <?php echo e(Form::hidden('admin_user_id', $adminuser->admin_user_id)); ?>

                                        <?php echo e(Form::label('first_name', 'First Name *')); ?>

                                        <?php echo e(Form::text('first_name', null, ['class' => 'form-control', 'placeholder' =>
                                        'Enter First Name', 'required' => true])); ?>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('last_name', 'Last Name *')); ?>

                                        <?php echo e(Form::text('last_name', null, ['class' => 'form-control', 'placeholder' =>
                                        'Enter Last Name', 'required' => true])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('email', 'Email *')); ?>

                                        <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter
                                        Email', 'readonly' => 'readonly'])); ?>

                                    </div>
                                </div>
                            </div>
                               
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start mt-2">
                                    <?php echo e(Form::submit('Update', array('class' => 'btn btn-primary mr-1'))); ?>

                                </div>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/backend/admin/myprofile.blade.php ENDPATH**/ ?>