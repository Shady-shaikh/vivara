<?php $__env->startSection('title', 'Backend Menus'); ?>

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
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Backend Menu</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Backend Menu</h1>
        </div>
        <div>
            <a href="<?php echo e(route('admin.backendmenu.create')); ?>" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                Add
            </a>
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
                                      <th>Name</th>
                                      <th>Controller Name</th>
                                      <th>Method Name</th>
                                      <th>Icon</th>
                                      <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php if(isset($backendmenus) && count($backendmenus)>0): ?>
                                    <?php $srno = 1; ?>
                                    <?php $__currentLoopData = $backendmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                      <td><?php echo e($srno); ?></td>
                                      <td><?php echo e($menu->menu_name); ?></td>
                                      <td><?php echo e($menu->menu_controller_name); ?></td>
                                      <td><?php echo e($menu->menu_action_name); ?></td>
                                      <td><?php echo e($menu->menu_icon); ?></td>
                                      <!-- <td><i class="menu-livicon" data-icon="<?php echo e(($menu->menu_icon)?$menu->menu_icon:''); ?>"></i></td> -->
                                      <td>
                                        <?php
                                          if($menu->has_submenu)
                                          {
                                        ?>
                                            <a href="<?php echo e(url('admin/backendsubmenu/menu/' . $menu->menu_id)); ?>" class="btn btn-primary btn-sm">Submenu</a>
                                        <?php
                                          }
                                        ?>
                                        <a href="<?php echo e(url('admin/backendmenu/edit/'.$menu->menu_id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <?php echo Form::open([
                                            'method'=>'GET',
                                            'url' => ['admin/backendmenu/delete', $menu->menu_id],
                                            'style' => 'display:inline'
                                        ]); ?>

                                            <?php echo Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm','onclick'=>"return confirm('Are you sure you want to Delete this Entry ?')"]); ?>

                                        <?php echo Form::close(); ?>

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


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('public/backend-assets/vendors/js/tables/datatable/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/backend-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/backend-assets/vendors/js/tables/datatable/dataTables.buttons.min.js')); ?>"></script>

<script>
  $(document).ready(function()
  {

  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/backendmenu/index.blade.php ENDPATH**/ ?>