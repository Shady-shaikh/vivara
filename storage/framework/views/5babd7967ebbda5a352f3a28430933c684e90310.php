<?php $__env->startSection('title', 'CMS Pages'); ?>

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
                    <li class="breadcrumb-item active" aria-current="page">CMS Pages</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">CMS Pages</h1>
                </div>
                <div>
                    <?php if(in_array('Create CMS Pages', $permissions)): ?>
                        <a href="<?php echo e(route('admin.cmspages.create')); ?>"
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
                                            <th>#</th>
                                            <th>Page Title</th>
                                            <th>Display at Top</th>
                                            <th>Display at Footer</th>
                                            <th>Visibility</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($cmspages) && count($cmspages) > 0): ?>
                                            <?php $srno = 1; ?>
                                            <?php $__currentLoopData = $cmspages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmspage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($srno); ?></td>
                                                    <td><?php echo e($cmspage->cms_pages_title); ?></td>
                                                    <td><?php echo e($cmspage->cms_pages_top == 1 ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo e($cmspage->cms_pages_footer == 1 ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo e($cmspage->show_hide == 1 ? 'Yes' : 'No'); ?></td>
                                                    <td>

                                                        <?php if(in_array('Update CMS Pages', $permissions)): ?>
                                                            <a href="<?php echo e(url('admin/cmspages/edit/' . $cmspage->cms_pages_id)); ?>"
                                                                class="btn btn-primary"><i
                                                                    class="fa-solid fa-pencil"></i></a>
                                                        <?php endif; ?>

                                                        <?php if(in_array('Delete CMS Pages', $permissions)): ?>
                                                            <?php echo Form::open([
                                                                'method' => 'GET',
                                                                'url' => ['admin/cmspages/delete', $cmspage->cms_pages_id],
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
                                                <?php $srno++; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/cmspages/index.blade.php ENDPATH**/ ?>