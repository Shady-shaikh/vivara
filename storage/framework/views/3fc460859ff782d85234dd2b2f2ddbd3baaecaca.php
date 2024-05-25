<?php $__env->startSection('title'); ?>
    Inventory
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <a href="<?php echo e(route('admin.warehouse')); ?>" class="btn btn-secondary">Back</a>

    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Inventory</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Rate</th>
                        <th>HSN/SAC</th>
                        <th>Product Type</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Stock On Hand</th>
                        <th>Available Stock</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo e($item->item_id); ?></td>
                        <td><?php echo e($item->name); ?></td>
                        <td><?php echo e($item->rate); ?></td>
                        <td><?php echo e($item->hsn_or_sac); ?></td>
                        <td><?php echo e($item->product_type); ?></td>
                        <td><?php echo e($item->unit); ?></td>
                        <td><?php echo e($item->description); ?></td>
                        <td><?php echo e($item->stock_on_hand); ?></td>
                        <td><?php echo e($item->available_stock); ?></td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Warehouses</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Warehouse Name</th>
                        <th>Stock On Hand</th>
                        <th>Initial Stock</th>
                        <th>Initial Stock Rate</th>
                        <th>Available Stock</th>
                        <th>Actual Available Stock</th>
                        <th>Available For Sale Stock</th>
                        <th>Actual Available For Sale Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $item->warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row['warehouse_id']); ?></td>
                            <td><?php echo e($row['warehouse_name']); ?></td>
                            <td><?php echo e($row['warehouse_stock_on_hand']); ?></td>
                            <td><?php echo e($row['initial_stock']); ?></td>
                            <td><?php echo e($row['initial_stock_rate']); ?></td>
                            <td><?php echo e($row['warehouse_available_stock']); ?></td>
                            <td><?php echo e($row['warehouse_actual_available_stock']); ?></td>
                            <td><?php echo e($row['warehouse_available_for_sale_stock']); ?></td>
                            <td><?php echo e($row['warehouse_actual_available_for_sale_stock']); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/warehouse/show.blade.php ENDPATH**/ ?>