@php
    
    use App\Models\frontend\Notification;
    use App\Models\frontend\Users;
    use App\Models\Rolesexternal;
    $user_id = Auth()->user()->user_id;
    $user = Auth()->user();
    // dd($roles_external->role_name);
    $userdata = Users::where('user_id', Auth::id())->first();
    
@endphp

<header class="navbar navbar-expand-md navbar-dark d-print-none">

    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <!--<span class="navbar-toggler-icon"></span>-->
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ url('/') }}/user/dashboard">
                VIVARA
            </a>
        </h1>

        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <p style="margin: 0 20px;">Hi,  {{ $user->name . " " .$user->last_name }}</p>
            </div>
            <div class="nav-item dropdown">
                <a href="{{ route('products.index') }}" class="btn  btn-success mr-2 ">Items</a>
            </div>
            <div class="nav-item dropdown">
                <a href="{{ route('cart.index') }}" class="btn  btn-info mr-2 "><i class="fa-solid fa-cart-shopping"></i> &nbsp;Cart</a>
            </div>

            <div class="nav-item dropdown">
                <a href="{{ route('products.index') }}" class="btn  btn-warning mr-2   dropdown-toggle" role="button"
                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My
                    Account</a>


                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('user.profile', ['id' => $user_id]) }}">
                        <i class="feather icon-user"></i>&nbsp; Edit Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('user.address', ['id' => $user_id]) }}">
                        <i class="feather icon-user"></i>&nbsp; Address
                    </a>
                    <a class="dropdown-item" href="{{ route('myorders.orders') }}">
                        <i class="feather icon-user"></i>&nbsp; Order History
                    </a>
                    <a class="dropdown-item" href="{{ route('payment.index') }}">
                        <i class="feather icon-user"></i>&nbsp; Payment History
                    </a>
                    <a class="dropdown-item" href="{{ route('user.changePassword') }}">
                        <i class="feather icon-check-square"></i>&nbsp; Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('user.logout') }}">
                        <i class="feather icon-power"></i>&nbsp; Logout
                    </a>
                </div>
            </div>

            {{-- <div class="nav-item dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $user->name }} {{ $user->last_name }}
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('user.profile', ['id' => $user_id]) }}">
                        <i class="feather icon-user"></i>&nbsp; Edit Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('user.changePassword') }}">
                        <i class="feather icon-check-square"></i>&nbsp; Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('user.logout') }}">
                        <i class="feather icon-power"></i>&nbsp; Logout
                    </a>
                </div>
            </div> --}}


        </div>
</header>
