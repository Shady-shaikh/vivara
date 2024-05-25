
<?php $__env->startSection('title'); ?>
    Order Reports
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        use App\Services\RolePermissionService;
        $permissions = RolePermissionService::getUserRolePermissions();
    ?>
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
                <li class="breadcrumb-item active" aria-current="page">Order Reports</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Order Reports</h1>
            </div>
            <div>
                <form action="<?php echo e(route('admin.reports')); ?>" method="GET" id="filter-form">
                    <input type="text" name="daterange" id="daterange-input" value="<?php echo e($_GET['daterange'] ?? ''); ?>"
                        placeholder="Please Select Dates" autocomplete="off" />
                    <input class="form-input" type="text" name="customer_name" id="customer_name"
                        value="<?php echo e($_GET['customer_name'] ?? ''); ?>" placeholder="Enter Customer Name"" />
                    <button type="submit" class="btn btn-sm btn-primary"> Submit</button>
                    <button type="button" onclick="resetFilters()">Reset</button>
                </form>
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
                                            <th>ID</th>
                                            <th>Invoice Number</th>
                                            <th>Customer Name</th>
                                            <th>Invoice Date</th>
                                            <th>Total</th>
                                            <th>Balance</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        ?>
                                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i); ?></td>
                                                <td><?php echo e($item->invoice_number); ?></td>
                                                <td><?php echo e($item->customer_data->name . ' ' . $item->customer_data->last_name); ?>

                                                </td>
                                                <td><?php echo e($item->date); ?></td>
                                                <td><?php echo e($item->total); ?></td>
                                                <td><?php echo e($item->balance); ?></td>
                                                <td>
                                                    <?php if(in_array('View Order Reports', $permissions)): ?>
                                                        <a href="<?php echo e(url('admin/reports/view/' . $item->invoice_id)); ?>"
                                                            class="btn btn-primary btn-sm"><i
                                                                class="fa-solid fa-eye"></i></a>
                                                    <?php endif; ?>
                                                    

                                                </td>
                                            </tr>

                                            <?php
                                            $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php $__env->stopSection(); ?>

                        <?php $__env->startSection('scripts'); ?>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#tbladmin_product').DataTable({
                                        columnDefs: [{
                                            targets: [0],
                                            visible: true,
                                            searchable: false
                                        }, ],
                                        order: [
                                            [0, "asc"]
                                        ],
                                    });
                                });
                            </script>


                            <script>
                                function resetFilters() {
                                    document.getElementById("daterange-input").value = '';
                                    document.getElementById("customer_name").value = '';
                                    var currentUrl = window.location.href;

                                    // Redirect to the same page
                                    var routeUrl = '<?php echo e(route('admin.reports')); ?>';

                                    // Redirect to the route URL
                                    window.location.href = routeUrl;
                                }
                            </script>
                        <?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/backend/reports/index.blade.php ENDPATH**/ ?>