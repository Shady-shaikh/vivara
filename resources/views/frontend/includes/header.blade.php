@php

use App\Models\frontend\Notification;
use App\Models\frontend\Users;
use App\Models\backend\Cmspages;
use App\Models\Rolesexternal;
use App\Models\backend\Items;

$user_id = Auth()->user()->user_id??'';
$user = Auth()->user()??'';
$userdata = [];
if(!empty($user_id)){
$userdata = Users::where('user_id', Auth::id())->first();
}

$cmspages = Cmspages::all();

$items = Items::get();

$groupedItems = $items->groupBy('group_name');

$uniqueGroups = [];

foreach ($groupedItems as $group => $items) {
$uniqueGroups[$group] = $items->pluck('category')->unique()->toArray();
}

// dd($uniqueGroups);

@endphp

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
          {{-- <img src="{{ asset('public/frontend-assets/images/logo.png') }}" alt="" /> --}}
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
            <a href="{{ route('cart.index') }}" class="text-dark">
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
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
      aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fal fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbar">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('user.dashboard') }}">Home</a>
        </li>
        <li class="nav-item dropdown">

          <a class="nav-link" type="button"
            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false">
            Products
          </a>
          <ul class="dropdown-menu">
            @foreach($uniqueGroups as $group => $categories)
            <li class="dropdown dropend">
              <a class="dropdown-toggle dropdown-item dropdown-toggle-icon" class="dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ $group }}
              </a>
              <ul class="dropdown-menu" style="width: 90%">
                @foreach($categories as $category)
                <li>
                  <a class="dropdown-item" href="{{ route('products.index', ['id' => $category]) }}">{{
                    $category}}</a>
                </li>
                @endforeach
              </ul>
            </li>
            @endforeach
          </ul>
        </li>

        @foreach($cmspages as $row)
        @if($row->column_type == 'quick_links' && $row->show_hide && $row->cms_pages_top)
        <li class="nav-item">
          <a class="nav-link" href="{{route('pages.index',['id'=>$row->cms_slug])}}">{{$row->cms_pages_title}}</a>
        </li>
        @endif
        @endforeach
      </ul>


      

      





      <div class="dropdown">
        <button class="nav-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fal fa-user"></i>
          <span>My Account</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          @if(!empty($user_id))
          <li><a class="dropdown-item" href="{{ route('user.profile', ['id' => $user_id]) }}"> Edit Profile</a></li>
          <li><a class="dropdown-item" href="{{ route('user.address', ['id' => $user_id]) }}"> Address</a></li>
          <li><a class="dropdown-item" href="{{ route('myorders.orders') }}"> Order History</a></li>
          <li><a class="dropdown-item" href="{{ route('payment.index') }}"> Payment History</a></li>
          <li><a class="dropdown-item" href="{{ route('user.changePassword') }}">Change Password</a></li>
          <li><a class="dropdown-item text-danger" href="{{ route('user.logout') }}">Logout</a></li>
          @else
          <li><a class="dropdown-item" href="{{ route('user.login') }}">Login</a></li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</nav>