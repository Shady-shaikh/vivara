@extends('frontend.layouts.app')
@section('title', 'User Dashboard')

@section('content')
    @php
        use App\Models\backend\Items;
        
        $items = Items::orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        // dd($items);
    @endphp
    <!-- Hero Section -->
    <section class="hero">
        <div class="owl-carousel owl-theme hero-carousel">
            @if (!empty($carousel_items))
                @foreach ($carousel_items as $item)
                    <div class="item">
                        @php
                            // if (!empty($item->redirect_link)) {
                            //     $url = route('products.index', ['id' => $item->redirect_link]);
                            // } else {
                            //     $url = route('products.index');
                            // }
                            $url = route('products.view', ['id' => $item->name]);
                        @endphp
                        <a href="{{ $url }}" class="box">
                            <img src="{{ asset('public/uploads/') . '/' . $item->image }}" alt=""
                                style="max-height:529px!important;" />
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section class="section about">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="text">
                        <h5 class="sub-heading mb-2">Vivara Warehouse</h5>
                        <h4 class="heading mb-4">The Box Shop</h4>
                        <p class="mb-2">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam
                            quod vero blanditiis pariatur nihil aliquam consequuntur itaque
                            repellendus aspernatur. Sint, exercitationem magni harum ipsum
                            sed repellat eligendi voluptatem ducimus? Unde tempora debitis
                            corporis quae quibusdam!
                        </p>
                        <p class="mb-5">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Error
                            doloremque aliquid voluptate accusantium deleniti minima, totam
                            quos? Sapiente, rem amet.
                        </p>
                        <a href="./about.tml" class="button">
                            <span>Read More</span>
                            <i class="fal fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image">
                        <img src="{{ asset('public/frontend-assets/images/about/about-1.jpg') }}" alt="" />
                        <img src="{{ asset('public/frontend-assets/images/about/about-2.jpg') }} " alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="section category bg-light-alt">
        <div class="container">
            <div class="text-center">
                <h5 class="sub-heading mb-2">A wide Variety of Boxes</h5>
                <h4 class="heading mb-5">Explore Categories</h4>
            </div>
            <div class="owl-carousel owl-theme category-carousel">
                @if (!empty($category_items))
                    @foreach ($category_items as $item)
                        <div class="item">
                            @php
                                if (!empty($item->name)) {
                                    $url = route('products.index', ['id' => $item->name]);
                                } else {
                                    $url = route('products.index');
                                }
                            @endphp
                            <a href="{{ $url }}" class="box">
                                <div class="icon">
                                    <img src="{{ asset('public/uploads/') . '/' . $item->image }}" alt="" />
                                </div>
                                <div class="text">
                                    <h6>{{ $item->name }}</h6>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <!-- Product Section -->
    <section class="section product pt-5">
        <div class="container">
            <div class="text-center">
                <h5 class="sub-heading mb-2">A wide Variety of Boxes</h5>
                <h4 class="heading mb-5">Explore Products</h4>
            </div>
            <div class="row g-2">
                @foreach ($items as $row)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="product-card">
                            <button class="cart-btn add_cart" id="{{ $row->item_id }}" title="Add to cart">
                                <i class="fal fa-shopping-cart"></i>
                            </button>
                            <div class="image">
                                @if (!empty($row->item_image))
                                    <img src="{{ asset('/public/frontend-assets/images/') . '/' . $row->item_image }} "
                                        alt="" />
                                @else
                                    <div style="height: 310px; padding:36%;">
                                        <img src="{{ asset('/public/frontend-assets/images/') . '/' . 'demo_image.png' }} "
                                            alt="" style="width:100px;" />
                                    </div>
                                @endif
                            </div>
                            <div class="text">
                                <div class="content">
                                    <a href="#">
                                        <h5>{{ $row->category }}</h5>
                                    </a>
                                    <a href="#">
                                        <h4 title="{{ $row->name }}">{{ $row->name }}</h4>
                                    </a>
                                    <h6>
                                        <b>&#8377; &nbsp;{{ '  ' . $row->rate }}/-</b>
                                    </h6>
                                    <div class="btns">
                                        {{-- <a href="#" id="{{$row->item_id}}" class="add_cart">Add To Cart</a> --}}

                                        <a href="{{ route('products.view', ['id' => $row->item_id]) }}">View Product</a>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('products.index') }}" style="text-decoration:underline;">See All Products</a>
            </div>
        </div>
    </section>

    <!-- features Section -->
    <section class="section features bg-light-alt py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('public/frontend-assets/images/features/easy-return.png') }}"
                                alt="" />
                        </div>
                        <div class="text">
                            <h5>Easy Return</h5>
                            <h6>10 Days Easy Return</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('public/frontend-assets/images/features/safe-payment.png') }}"
                                alt="" />
                        </div>
                        <div class="text">
                            <h5>Safe Payments</h5>
                            <h6>Easy Installment Process</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('public/frontend-assets/images/features/fastest-shipping.png') }}"
                                alt="" />
                        </div>
                        <div class="text">
                            <h5>Fastest Shipping</h5>
                            <h6>Delivery at your doorsteps</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('public/frontend-assets/images/features/online-support.png') }}"
                                alt="" />
                        </div>
                        <div class="text">
                            <h5>Online Support</h5>
                            <h6>Shop with confident</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
