
<?php $__env->startSection('title', 'Items'); ?>

<?php
    use App\Models\backend\Items;
    
    $items = Items::get();
    $uniqueCategories = $items
        ->pluck('category', 'item_id')
        ->unique()
        ->toArray();
    
    $uniqueVariant = $items
        ->pluck('variant')
        ->unique()
        ->toArray();
    // dd($uniqueVariant);
?>
<?php $__env->startSection('content'); ?>



    <section class="section product-list mb-4">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="filter-text">
                        <h4 class="heading">Filter</h4>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php
                        $filter_category = '';
                        $filter_color = '';
                        $filter_packet = '';
                        if (!empty(request('id')) || !empty($_GET['category'])) {
                            $filter_category = request('id') ?? $_GET['category'];
                        }
                        if (!empty($_GET['color'])) {
                            $filter_color = $_GET['color'];
                        }
                        if (!empty($_GET['packet'])) {
                            $filter_packet = $_GET['packet'];
                        }
                    ?>
                    
                    <div class="filter">
                        <form action="<?php echo e(route('products.index')); ?>" method="GET">
                            <div class="filter-options">
                                <select class="form-select" name="category">
                                    <option class="main" selected>All Categories:</option>
                                    <?php $__currentLoopData = $uniqueCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($filter_category == $val): ?>
                                            <option value="<?php echo e($filter_category); ?>" selected><?php echo e($filter_category); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <select class="form-select" name="color">
                                    <option class="main" selected>All Color:</option>
                                    <?php $__currentLoopData = $uniqueVariant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!empty($val)): ?>
                                            <?php if($filter_color == $val): ?>
                                                <option value="<?php echo e($filter_color); ?>" selected><?php echo e($filter_color); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <select class="form-select d-none" name="packet">
                                    <option class="main" selected>All Packets:</option>
                                    <option class="opt" value="1">One</option>
                                    <option class="opt" value="2">Two</option>
                                    <option class="opt" value="3">Three</option>
                                </select>


                                <button type="submit" class="btn btn-primary" id="filter">Submit</button>
                            </div>
                        </form>
                        <button class="btn btn-primary mb-3" id="filter-btn" type="submit">
                            Filter
                            <i class="fal fa-bars ms-2"></i>
                        </button>
                    </div>

                </div>
            </div>


            <div class="row g-2">
                <?php
                $i = 1;
                ?>
                <?php if(!$availableItems->isEmpty()): ?>
                    <?php $__currentLoopData = $availableItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="product-card">
                                <button class="cart-btn" title="Add to cart">
                                    <i class="fal fa-shopping-cart"></i>
                                </button>
                                <div class="image">
                                    <?php if(!empty($row->item_image)): ?>
                                        <img src="<?php echo e(asset('/public/frontend-assets/images/') . '/' . $row->item_image); ?>"
                                            alt="" />
                                    <?php else: ?>
                                        <div style="height: 310px; padding:36%;">
                                            <img src="<?php echo e(asset('/public/frontend-assets/images/') . '/' . 'demo_image.png'); ?> "
                                                alt="" style="width:100px;" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text">
                                    <div class="content">
                                        <a href="#">
                                            <h5><?php echo e($row->category ?? ''); ?></h5>
                                        </a>
                                        <a href="#">
                                            <h4 title="Mini Cane Basket"><?php echo e($row->name); ?> <?php if(!empty($row->get_offers)): ?>
                                                    <?php echo e(' (' . $row->get_offers->scheme_title . ')'); ?>

                                                <?php endif; ?>
                                            </h4>
                                        </a>
                                        <h6>
                                            
                                            <b>&#8377; &nbsp;&nbsp;<?php echo e($row->rate); ?> /-</b>
                                        </h6>
                                        <div class="btns">
                                            <button>Add To Cart</button>
                                            <a href="<?php echo e(route('products.view', ['id' => $row->item_id])); ?>">View
                                                Product</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <hr>
                    <div class="text-center">
                        <h5>Products Not Fount For This Category</h5>
                        <a href="<?php echo e(route('products.index')); ?>">See All Products</a>
                    </div>
                <?php endif; ?>

                <script>
                    filterAnimation();
                </script>



            <?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/frontend/products/index.blade.php ENDPATH**/ ?>