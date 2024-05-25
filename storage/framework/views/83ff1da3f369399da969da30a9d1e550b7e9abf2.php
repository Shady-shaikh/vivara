<?php

use App\Models\backend\BackendMenubar;
use App\Models\backend\BackendSubMenubar;
use App\Models\backend\AdminUsers;
use App\Models\backend\UserMaster;
use Spatie\Menu\Laravel\Menu;
use Spatie\Permission\Models\Role;
$user_id = Auth()->guard('admin')->user()->admin_user_id;
//dd(Auth()->guard('admin')->user()->role);
$role_id = Auth()->guard('admin')->user()->role;

$user = Auth()->guard('admin')->user();

$user_role = Role::where('id',$role_id)->first();
//dd($user_role->submenu_ids);
$menu_ids=explode(",",$user_role->menu_ids);
$submenu_ids=explode(",",$user_role->submenu_ids);

$backend_menubar = BackendMenubar::WhereIn('menu_id',$menu_ids)->Where(['visibility'=>1])->orderBy('sort_order')->get();
// dd($submenu_ids);
?>



<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
  <div class="container-fluid px-0">
    <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
      <div class="d-flex align-items-center">
        <!-- Search form -->

        <!-- / Search form -->
      </div>
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center">

        <li class="nav-item dropdown ms-lg-3">
          <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="media d-flex align-items-center">
        
              <img class="avatar rounded-circle" src="<?php echo e(asset('public/backend-assets/images/dummy.png')); ?>">
              <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                <span class="mb-0 font-small fw-bold text-gray-900"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('admin.profile',['id' => $user_id])); ?>">
              <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>
              My Profile
            </a>
            <div role="separator" class="dropdown-divider my-1"></div>
            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('admin.logout')); ?>">
              <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>                
              Logout
            </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>





<div class="horizontal-menu  text-center  " style="position: relative !important;">
  <?php
  $menu_lists = ['id'=>1,'name'=>'Dashboard'];

  // Code for active class
  $current_route = Route::current()->getName();
  $home_active = $current_route == 'admin.dashboard'?'active':'';
  $submenu_active = '';

  $user_management_active = $current_route == 'admin.users' || $current_route == 'admin.externalusers'?'active':'';
  ?>

  <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
      <ul class="nav flex-column pt-3 pt-md-0">

          <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link d-flex align-items-center mb-3">

              <img src="<?php echo e(asset('public/backend-assets/images/logo/logo.png')); ?>"  width="50%" alt="Volt Logo">
          </a>

 

        <?php
        $i=0;
        foreach($backend_menubar as $menu)
        {
          // dd($menu->toArray());
        if($menu->has_submenu == 1)
        {
        $backend_submenubar = BackendSubMenubar::WhereIn('submenu_id',$submenu_ids)->Where(['menu_id'=>$menu->menu_id])->get();
        if($backend_submenubar)
        {
        ?>
        <li class="nav-item">
          <span
            class="nav-link  collapsed  d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" data-bs-target="#submenu-app_<?php echo $i;?>">
            <span>
              <span class="sidebar-icon">
                <i class="fa-solid fa-<?php echo e($menu->menu_icon); ?>"></i>
              </span> 
              <span class="sidebar-text"><?php echo e($menu->menu_name); ?></span>
            </span>
            <span class="link-arrow">
              <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </span>
          </span>
          <div class="multi-level collapse "
            role="list" id="submenu-app_<?php echo $i;?>" aria-expanded="false">
            <ul class="flex-column nav">
              <?php
                            foreach($backend_submenubar as $submenu)
                            {
                            $suburl = ($submenu->submenu_controller_name != "#" && $submenu->submenu_controller_name != '')?route($submenu->submenu_controller_name):'#';
                            ?>
              <li class="nav-item ">
                <a class="nav-link text-start" href="<?php echo e($suburl); ?>">
                  <span class="sidebar-text"><?php echo e($submenu->submenu_name); ?></span>
                </a>
              </li>
              <?php
                            }
                            ?>
            </ul>
          </div>
        </li>
        <?php
                }
                }else
                {
                $url = ($menu->menu_controller_name != "#" && $menu->menu_controller_name != '')?route($menu->menu_controller_name):'#';
                $route_condition = $menu->menu_controller_name == $current_route ? 'active': '';

                // dump($route_condition);
                ?>
                <li class="nav-item <?php echo e($route_condition); ?>">
                    <a class="" href="<?php echo e($url); ?>">
                      <span
            class="nav-link  collapsed  d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" data-bs-target="#submenu-app_<?php echo $i;?>">
            <span>
              <span class="sidebar-icon">
                <i class="fa-solid fa-<?php echo e($menu->menu_icon); ?>"></i>
              </span> 
              <span class="sidebar-text"><?php echo e($menu->menu_name); ?></span>
            </span>
          </span>
                    </a>
                </li>
                <?php
                }
                $i++;
                }
                ?>

      </ul>
    </div>
  </nav>
</div>
   <?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/includes/header.blade.php ENDPATH**/ ?>