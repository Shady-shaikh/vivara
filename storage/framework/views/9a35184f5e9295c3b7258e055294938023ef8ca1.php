<?php $__env->startSection('title'); ?>
    Schemes
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        use App\Services\RolePermissionService;
        $permissions = RolePermissionService::getUserRolePermissions();
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
                    <li class="breadcrumb-item active" aria-current="page">Offers</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Offers</h1>
                </div>
                <div>
                    <?php if(in_array('Create Offers', $permissions)): ?>
                        <a href="<?php echo e(url('admin/schemes/create')); ?>"
                            class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                            Add
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration " id="tbl-datatable" style="text-align:center">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Scheme Title</th>
                                            <th>Mininum Product Qty</th>
                                            <th>Free Product Qty</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->schemes_id); ?></td>
                                                <td><?php echo e($item->scheme_title); ?></td>
                                                <td><?php echo e($item->min_product_qty); ?></td>
                                                <td><?php echo e($item->free_product_qty); ?></td>
                                                <td>
                                                    <?php if(in_array('Update Offers', $permissions)): ?>
                                                        <a href="<?php echo e(url('admin/schemes/edit/' . $item->schemes_id)); ?>"
                                                            class="btn btn-primary "><i class="fa-solid fa-pencil"></i></a>
                                                    <?php endif; ?>
                                                    <?php if(in_array('Delete Offers', $permissions)): ?>
                                                        <?php echo Form::open([
                                                            'method' => 'GET',
                                                            'url' => ['admin/schemes/delete', $item->schemes_id],
                                                            'style' => 'display:inline',
                                                        ]); ?>

                                                        <?php echo Form::button('<i class="fa-solid fa-trash"></i>', [
                                                            'type' => 'submit',
                                                            'class' => 'btn btn-danger',
                                                            'onclick' => "return confirm('Are you sure you want to Delete this Entry ?')",
                                                        ]); ?>

                                                        <?php echo Form::close(); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/schemes/index.blade.php ENDPATH**/ ?>