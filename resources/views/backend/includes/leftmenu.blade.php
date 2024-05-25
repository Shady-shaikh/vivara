@php

use App\Models\backend\BackendMenubar;
use App\Models\backend\BackendSubMenubar;
use App\Models\backend\AdminUsers;
use App\Models\backend\UserMaster;
use Spatie\Menu\Laravel\Menu;
use Spatie\Permission\Models\Role;

$user_id = Auth()->guard('admin')->user()->id;
//dd(Auth()->guard('admin')->user()->role);
$role_id = Auth()->guard('admin')->user()->role;

$user_role = Role::where('id',$role_id)->first();

$menu_ids=explode(",",$user_role->menu_ids);
$submenu_ids=explode(",",$user_role->submenu_ids);

$backend_menubar = BackendMenubar::WhereIn('menu_id',$menu_ids)->Where(['visibility'=>1])->orderBy('sort_order')->get();
//dd($backend_menubar);
@endphp

<!-- BEGIN: Main Menu-->
<!-- <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      @php
      $menu_lists = ['id'=>1,'name'=>'Dashboard'];
      @endphp
      <li class=" nav-item">
        <a href="{{ route('admin.dashboard') }}">
          <i class="feather icon-home"></i>
          <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
        </a>
      </li>
      @php
      foreach($backend_menubar as $menu)
      {
      if($menu->has_submenu == 1)
      {
      $backend_submenubar = BackendSubMenubar::WhereIn('submenu_id',$submenu_ids)->Where(['menu_id'=>$menu->menu_id])->get();
      if($backend_submenubar)
      {
      @endphp
      <li class="nav-item">
        <a href="#">
          <i class="feather icon-users"></i>
          <span class="menu-title" data-i18n="{{$menu->menu_name}}">{{$menu->menu_name}}</span>
        </a>
        <ul class="menu-content">
          @php
          foreach($backend_submenubar as $submenu)
          {
          $suburl = ($submenu->submenu_controller_name != "#" && $submenu->submenu_controller_name != '')?route($submenu->submenu_controller_name):'#';
          @endphp
          <li>
            <a class="menu-item" href="{{ $suburl }}" data-i18n="{{ $submenu->submenu_name }}">{{ $submenu->submenu_name }}</a>
          </li>
          @php
          }
          @endphp
        </ul>
      </li>
      @php
      }
      }
      else
      {
      $url = ($menu->menu_controller_name != "#" && $menu->menu_controller_name != '')?route($menu->menu_controller_name):'#';
      @endphp
      <li class=" nav-item">
        <a href="{{ $url }}">
          <i class="feather icon-mail"></i>
          <span class="menu-title" data-i18n="{{$menu->menu_name}}">{{$menu->menu_name}}</span>
        </a>
      </li>
      @php
      }
      }
      @endphp
    </ul>
  </div>
</div> -->
<!-- END: Main Menu-->
