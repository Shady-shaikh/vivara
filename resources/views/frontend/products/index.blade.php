@extends('frontend.layouts.app')
@section('title', 'Items')

@php
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
@endphp
@section('content')



    <section class="section product-list mb-4">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="filter-text">
                        <h4 class="heading">Filter</h4>
                    </div>
                </div>
                <div class="col-lg-8">
                    @php
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
                    @endphp
                    {{-- {{dd($_GET)}} --}}
                    <div class="filter">
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="filter-options">
                                <select class="form-select" name="category">
                                    <option class="main" selected>All Categories:</option>
                                    @foreach ($uniqueCategories as $key => $val)
                                        @if ($filter_category == $val)
                                            <option value="{{ $filter_category }}" selected>{{ $filter_category }}</option>
                                        @else
                                            <option value="{{ $val }}">{{ $val }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <select class="form-select" name="color">
                                    <option class="main" selected>All Color:</option>
                                    @foreach ($uniqueVariant as $key => $val)
                                        @if (!empty($val))
                                            @if ($filter_color == $val)
                                                <option value="{{ $filter_color }}" selected>{{ $filter_color }}</option>
                                            @else
                                                <option value="{{ $val }}">{{ $val }}</option>
                                            @endif
                                        @endif
                                    @endforeach
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
                @if (!$availableItems->isEmpty())
                    @foreach ($availableItems as $row)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="product-card">
                                <button class="cart-btn" title="Add to cart">
                                    <i class="fal fa-shopping-cart"></i>
                                </button>
                                <div class="image">
                                    @if (!empty($row->item_image))
                                        <img src="{{ asset('/public/frontend-assets/images/') . '/' . $row->item_image }}"
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
                                            <h5>{{ $row->category ?? '' }}</h5>
                                        </a>
                                        <a href="#">
                                            <h4 title="Mini Cane Basket">{{ $row->name }} @if (!empty($row->get_offers))
                                                    {{ ' (' . $row->get_offers->scheme_title . ')' }}
                                                @endif
                                            </h4>
                                        </a>
                                        <h6>
                                            {{-- <i>&#8377; 300/-</i> --}}
                                            <b>&#8377; &nbsp;&nbsp;{{ $row->rate }} /-</b>
                                        </h6>
                                        <div class="btns">
                                            <button>Add To Cart</button>
                                            <a href="{{ route('products.view', ['id' => $row->item_id]) }}">View
                                                Product</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                        ?>
                    @endforeach
                @else
                    <hr>
                    <div class="text-center">
                        <h5>Products Not Fount For This Category</h5>
                        <a href="{{ route('products.index') }}">See All Products</a>
                    </div>
                @endif

                <script>
                    filterAnimation();
                </script>



            @endsection
