<?php $__env->startSection('title', 'Internal Users'); ?>
<?php
use Spatie\Permission\Models\Role;
use App\Models\frontend\Department;
use App\Models\backend\Company;
use App\Models\backend\Designation;
use App\Models\backend\Location;
?>
<?php $__env->startSection('content'); ?>





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

            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.users')); ?>">Internal user</a>
            </li>
            <li class="breadcrumb-item active">add</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Add Internal User</h1>
        </div>
        <div>
            <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                Back
            </a>
        </div>
    </div>
</div>


<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <?php
                        $role = Role::get(['id','name'])->toArray();
                        ?>
                        <?php echo $__env->make('backend.includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo e(Form::open(array('url' => 'admin/user/store'))); ?>

                        <?php echo csrf_field(); ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
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
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('email', 'Email *')); ?>

                                        <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter  Email', 'required' => true])); ?>

                                        
                                        <?php echo e(Form::hidden('password', 'Pass@123', ['class' => 'form-control',
                                        'placeholder' => 'Enter First Name', 'required' => true])); ?>

                                        <?php echo e(Form::hidden('account_status', 1, ['class' => 'form-control', 'placeholder'
                                        => 'Enter First Name', 'required' => true])); ?>

                                    </div>
                                </div>

                                
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('role', 'Role *')); ?>

                                        <select name="role" id="role" class='form-control'>
                                            <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value['id']); ?>"> <?php echo e($value['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                               
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('password', 'Password *')); ?>

                                  
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter Password"  
                                            data-toggle="tooltip" data-placement="top"
                                            title="Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit" 
                                            required>
                                            <span style="color:red;font-size: 11px;"><b>Note: </b>Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('password_confirmation', 'Confirm Password *')); ?>

                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Enter Confirm Password" required>
                                    </div>
                                </div>
                                <div class="col-12 mt-1">
                                    <?php echo e(Form::submit('Create', array('class' => 'btn btn-primary mr-1 mb-1'))); ?>

                                    <button type="reset" class="btn btn-dark mr-1 mb-1">Reset</button>
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                </div>
            </div>

</section>

<script>
    $(document).ready(function() {
        $(function() {
            $("#dob").datepicker();
        });


    });



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/admin/create.blade.php ENDPATH**/ ?>