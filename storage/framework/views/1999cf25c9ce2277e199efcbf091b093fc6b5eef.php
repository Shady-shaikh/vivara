<?php
    
    use App\Models\frontend\Notification;
    use App\Models\frontend\Users;
    use App\Models\backend\Cmspages;
    use App\Models\Rolesexternal;
    use App\Models\backend\Items;

    $user_id = Auth()->user()->user_id;
    $user = Auth()->user();
    // dd(Auth()->check());
    $userdata = Users::where('user_id', Auth::id())->first();

    $cmspages = Cmspages::all();

    $items = Items::get();
    $uniqueCategories = $items->pluck('category','item_id')->unique()->toArray();

    // dd($uniqueCategories);
    
?>

    <!-- Header -->
    <header class="header">
        <div class="container-fluid px-lg-5">
          <div class="row align-items-center">
            <div class="col-lg-4">
              <div class="social">
                <a href="#" target="_blank">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" target="_blank">
                  <i class="fab fa-twitter"></i>
                </a>
                <a href="#" target="_blank">
                  <i class="fab fa-instagram"></i>
                </a>
                <a href="#" target="_blank">
                  <i class="fab fa-pinterest-p"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-4">
              <a href="#" class="logo">
                <img src="<?php echo e(asset('public/frontend-assets/images/logo.png')); ?>" alt="" />
              </a>
            </div>
            <div class="col-lg-4">
              <div class="info">
                <button>
                  <i class="far fa-search"></i>
                </button>
                <button>
                  <i class="far fa-heart"></i>
                </button>
                <button>
                <a href="<?php echo e(route('cart.index')); ?>" class="text-dark">
                  <i class="far fa-shopping-cart"></i>
                </a>
                </button>
              </div>
            </div>
          </div>
        </div>
      </header>
  
      <!-- Navvbar -->
      <nav class="navbar navbar-expand-lg menu">
        <div class="container-fluid px-lg-5">
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar"
            aria-controls="navbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <i class="fal fa-bars"></i>
          </button>
  
          <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" href="<?php echo e(route('user.dashboard')); ?>">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  Products
                </a>
                <ul class="dropdown-menu">
                    <?php $__currentLoopData = $uniqueCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li>
                    <a class="dropdown-item" href="<?php echo e(route('products.index',['id'=>$val])); ?>"><?php echo e($val); ?></a>
                  </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </li>

              <?php $__currentLoopData = $cmspages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($row->column_type == 'quick_links' && $row->show_hide  && $row->cms_pages_top ): ?>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('pages.index',['id'=>$row->cms_slug])); ?>"><?php echo e($row->cms_pages_title); ?></a>
              </li>

              <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="dropdown">
              <button
                class="nav-button"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="fal fa-user"></i>
                <span>My Account</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo e(route('user.profile', ['id' => $user_id])); ?>"> Edit Profile</a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('user.address', ['id' => $user_id])); ?>"> Address</a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('myorders.orders')); ?>"> Order History</a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('payment.index')); ?>"> Payment History</a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('user.changePassword')); ?>">Change Password</a></li>
                <li><a class="dropdown-item text-danger" href="<?php echo e(route('user.logout')); ?>">Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
<?php /**PATH /home/parasigh/public_html/vivara/resources/views/frontend/includes/header.blade.php ENDPATH**/ ?>