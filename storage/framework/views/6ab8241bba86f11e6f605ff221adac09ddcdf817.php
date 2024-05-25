<?php $__env->startSection('title', 'Update Carousel Item'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        
    ?>

    <div class="content-header row">
        <div class="py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.productcarousel')); ?>">Products Carousel</a></li>
                    <li class="breadcrumb-item active" aria-current="page">edit</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Edit Carousel Item</h1>
                </div>
                <div>
                    <a href="<?php echo e(route('admin.productcarousel')); ?>"
                        class="btn btn-outline-gray-600 d-inline-flex align-items-center">
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
                                'url' => ['admin/productcarousel/update'],
                                'class' => 'form',
                                'enctype' => 'multipart/form-data',
                            ]); ?>

                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="product_car_id" value="<?php echo e($coupon->product_car_id); ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        
                                        <div class="form-group">
                                            <?php echo e(Form::label('name', 'Item : ')); ?>

                                            <?php echo e(Form::select('name', $items, null, ['class' => 'form-control', 'placeholder' => 'Select Item'])); ?>


                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <?php echo e(Form::label('image', 'Carousel Item Image *')); ?>

                                            <?php echo e(Form::file('image', null, ['class' => 'form-control', 'placeholder' => 'Enter Carousel Item Image'])); ?>

                                        </div>
                                    </div>


                                    <div class="col-12 d-flex justify-content-start mt-2">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/productcarousel/edit.blade.php ENDPATH**/ ?>