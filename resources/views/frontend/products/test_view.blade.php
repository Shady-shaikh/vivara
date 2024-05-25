@extends('frontend.layouts.app')
@section('title', 'Item')

@php
    use App\Models\backend\Items;
    
    $items = Items::where('category', $item->category ?? '')->get();
    
    $SIZE = $items
        ->pluck('size')
        ->unique()
        ->toArray();
    
    $COLORS = $items
        ->pluck('variant')
        ->unique()
        ->toArray();
    
    // dd($COLORS);
    
@endphp

@section('content')
    <style>
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            /* Semi-transparent background */
            text-align: center;
            z-index: 9999;
            display: none;
        }

        .loader-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            opacity: 0;
            /* Initially hidden */
            animation: fadeInOut 1s ease-in-out forwards;
            /* Animation */
        }

        .loader-text {
            font-size: 18px;
            color: #333;
            /* You can apply additional styles for the text */
        }

        /* Keyframes for fadeInOut animation */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>


    <section class="section product-page">
        <div class="container">

            <div id="loader">
                <div class="loader-content">
                    <div class="loader-text">Loading...</div>
                </div>
            </div>



            @if (!empty($item))
                <div class="row justify-content-center g-5">
                    <div class="col-md-5">
                        <div class="product-carousel">
                            @if (!empty($item_images))
                                <div id="productCarousel" class="carousel slide">


                                    <div class="carousel-indicators">


                                        @foreach ($item_images as $key => $val)
                                            @php
                                                $url = asset('/public/frontend-assets/images/') . '/' . $val;
                                                
                                                $class = '';
                                                if ($val == $item->item_image) {
                                                    $class = 'active';
                                                }
                                                
                                            @endphp

                                            <button type="button" data-bs-target="#productCarousel"
                                                data-bs-slide-to="{{ $key }}"
                                                class="{{ $class }} item_image_bg" aria-current="true"
                                                aria-label="Slide 1" style="background-image: url({{ $url }});"
                                                data-val="{{ $val }}">
                                            </button>
                                        @endforeach


                                    </div>
                                    <div class="carousel-inner">

                                        @foreach ($item_images as $key => $val)
                                            @php
                                                $url = asset('/public/frontend-assets/images/') . '/' . $val;
                                                
                                                $class = '';
                                                if ($val == $item->item_image) {
                                                    $class = 'active';
                                                }
                                            @endphp

                                            <div class="carousel-item {{ $class }}">
                                                @if (!empty($val))
                                                    <img id="item_img" class="img_item" src="{{ $url }}"
                                                        class="d-block w-100" alt="..." data-src={{ $val }}>
                                                @else
                                                    <img src="{{ asset('/public/frontend-assets/images/') . '/' . 'demo_image.png' }} "
                                                        alt="" class="d-block w-100" />
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>



                                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- prices and stuff -->
                    <div class="col-md-6">
                        <div class="name">
                            <h5 class="sub-heading mb-2" id="item_cat">{{ $item->category }}</h5>
                            <h4 class="heading mb-4" id="item_name">{{ $item->name }} </h4>

                            <h6>
                                <b>&#8377; <span id="item_rate">{{ $item->rate }} </span> /-</b>
                                {{-- <i>&#8377; 300/-</i> --}}

                            </h6>
                            <span>
                                @if (!empty($item->get_offers))
                                    {{ ' (' . $item->get_offers->scheme_title . ')' }}
                                @endif
                            </span>
                            <!-- <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus aspernatur
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          repellat
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          deleniti! Blanditiis itaque.</p> -->
                            <hr class="my-4">
                        </div>
                        @if (!empty($SIZE[0]))
                            <div class="size d-flex align-items-center my-4">

                                <div class="sizes mb-2">
                                    <h5>Select Size</h5>
                                    <div class="all-size d-flex mt-2">

                                        @foreach ($SIZE as $key => $val)
                                            @php
                                                $checked = '';
                                                if ($val == $item->size) {
                                                    $checked = 'checked';
                                                }
                                            @endphp

                                            <div class="size">
                                                <input type="radio" name="sizes" id="sizeS_{{ $key }}"
                                                    {{ $checked }} class="onchangeAttr size_attr"
                                                    value="{{ $val }}">
                                                <label for="sizeS_{{ $key }}">
                                                    <span>{{ $val }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($COLORS[0]))
                            <div class="colors d-flex align-items-center mb-4">
                                <div class="color mb-2">
                                    <h5>Choose Color</h5>
                                    <div class="colors d-flex mt-2">

                                        @foreach ($COLORS as $key => $val)
                                            @php
                                                $checked = '';
                                                if ($val == $item->variant) {
                                                    $checked = 'checked';
                                                }
                                            @endphp

                                            <div class="color-red">
                                                <input type="radio" name="colors" id="clrRed_{{ $key }}"
                                                    {{ $checked }} class="onchangeAttr color_attr"
                                                    value="{{ $val }}">
                                                <label for="clrRed_{{ $key }}">
                                                    <i style="background-color:{{ $val }} "></i>
                                                    <span>{{ $val }}</span>
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                            </div>
                        @endif


                        <form method="post" action="{{ route('cart.update', ['id' => $item->item_id]) }}">
                            @csrf
                            <div class="btns d-flex mb-4">
                                <select class="form-select" name="quantity[]" aria-label="Default select example">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="4">Four</option>
                                    <option value="5">Five</option>
                                    <option value="6">Six</option>
                                </select>
                                <input type="hidden" name="item_id[]" id="item_id" value="{{ $item->item_id }}">

                                <button type="submit" id="submit-button">
                                    <span>Add To Cart</span>
                                    <i class="fal fa-shopping-cart"></i>
                                </button>
                                <!-- <a href="#">View Product</a> -->
                            </div>
                        </form>
                        <hr class="my-4">
                        {{-- <div class="cupoun mb-5">
                        <h5>Got a coupon?</h5>
                        <div class="cupouns d-flex mt-2">
                            <div class="cupoun-box">
                                <input type="text" name="cupouns" id="cupoun" placeholder="Enter coupon code">
                                <label for="cupoun">
                                    <span>Check</span>
                                </label>
                            </div>
                        </div>
                    </div> --}}

                        <div class="product-details">
                            <div class="description">
                                <h6 class="mb-2" style="color: var(--bs-body-color); font-weight: 600;">Description</h6>
                                <h6 class="d-flex mb-2">
                                    <!-- <span class="Title">Product Type : </span> -->
                                    Product Type :
                                    <span class="description" id="item_prod_type"> {{ $item->product_type }}</span>
                                </h6>

                                <h6 class="d-flex mb-2">
                                    <span class="Title">Rate : </span>
                                    <span class="description" id="item_per_unit_rate"> {{ $item->rate }} </span> per
                                    unit
                                </h6>

                                <h6 class="d-flex mb-2">
                                    <span class="Title">Usuage Unit : </span>
                                    <span class="description" id="item_unit"> {{ $item->unit }}</span>
                                </h6>

                            </div>

                            <div class="details">
                                <h6 class="mt-4 mb-2" style="color: var(--bs-body-color); font-weight: 600;">Product
                                    details
                                </h6>
                                <p id="item_desc">
                                    {{ $item->description }}
                                </p>
                            </div>

                            <div class="size my-4">
                                <h6 class="mt-4 mb-2" style="color: var(--bs-body-color); font-weight: 600;">Size</h6>
                                <h6 class="mb-2">Size : <span
                                        id="item_size">{{ !empty($item->size) ? $item->size : 'None' }} <span></h6>
                                <h6 class="mb-2">Color : <span
                                        id="item_color">{{ !empty($item->variant) ? $item->variant : 'None' }} <span></h6>

                            </div>

                            <div class="table">
                                <h6 class="mb-2">Specifications</h6>
                                <table class="table .table-borderless">
                                    <tbody>
                                        <tr>

                                            <td>Lorem.</td>
                                            <td>Lorem.</td>

                                        </tr>
                                        <tr>

                                            <td>Lorem.</td>
                                            <td>Lorem.</td>

                                        </tr>
                                        <tr>

                                            <td>Lorem.</td>
                                            <td>Lorem.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <hr>
                <div class="text-center">
                    <h5>No Such Item Exists</h5>
                    <a href="{{ route('products.index') }}">See All Products</a>
                </div>
            @endif
        </div>
        {{-- {{ dd($item->group_id) }} --}}
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        // for loader
        $(document).ready(function() {
            // Function to show the loader
            function showLoader() {
                $('#loader').show();
            }

            // Function to hide the loader
            function hideLoader() {
                $('#loader').hide();
            }

            // Attach AJAX event handlers to show/hide the loader
            $(document).ajaxStart(function() {
                showLoader();
            }).ajaxStop(function() {
                // Add a delay of 1 second (1000 milliseconds) before hiding the loader
                setTimeout(function() {
                    hideLoader();
                }, 200);
            });
        });



        //for dynamic data

        function updateUrlParameterWithoutRefresh(newParamValue) {
            // Get the current URL
            var currentUrl = window.location.href;

            // Use a regular expression to match the part after "view/"
            var regex = /\/view\/([^/]+)/;
            var match = currentUrl.match(regex);

            if (match && match[1]) {
                // Replace the matched parameter with the new value
                var updatedUrl = currentUrl.replace(match[1], newParamValue);

                // Use replaceState to change the URL without a page refresh
                window.history.replaceState(null, null, updatedUrl);
            }
        }

        function updateCarousel(imageUrl, currentIndex) {
            // Update the carousel item
            $('#productCarousel').find('.carousel-item').removeClass('active');
            $('#productCarousel').find('.carousel-item').eq(currentIndex).addClass('active');

            // Update the card image
            $('#item_img').attr('src', imageUrl);

            // Update the button backgrounds and set the current button as active
            $('.carousel-indicators button').removeClass('active');
            $('.carousel-indicators button').eq(currentIndex).addClass('active');
        }

        function updateSize(currentIndex) {
            // Update the carousel item
            $('.all-size').find('.size_attr').prop('checked', false);
            $('.all-size').find('.size_attr').eq(currentIndex).prop('checked', true);

        }

        function updateColor(currentIndex) {
            // Update the carousel item
            $('.colors').find('.color_attr').prop('checked', false);
            $('.colors').find('.color_attr').eq(currentIndex).prop('checked', true);

        }


        // common ajax function
        function call_Ajax(size, color, group_id, previousSize, previousColor, itemImages, image_id, sizes, colors) {
            $.ajax({
                url: '{{ route('products.get_same_group_item') }}',
                method: 'POST', // Use 'GET' or 'POST' based on your requirements
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    color: color,
                    size: size,
                    image_id: image_id,
                    group_id: group_id,
                },
                success: function(response) {
                    // Handle the AJAX response here
                    // console.log(response);
                    if (response) {

                        var currentImage = response.item_image;
                        var currentIndex = itemImages.indexOf(currentImage);

                        if (sizes != '') {
                            var currSize = response.size;
                            var currSizeIndex = sizes.indexOf(currSize);
                            updateSize(currSizeIndex);
                        }

                        if (colors != '') {
                            var currColor = response.variant;
                            var currColorIndex = colors.indexOf(currColor);
                            updateColor(currColorIndex);
                        }

                        updateCarousel(
                            "{{ asset('/public/frontend-assets/images/') . '/' }}" + response
                            .item_image,
                            currentIndex // Assuming you want to show the first image as active
                        );
                        // alert(currentIndex);




                        updateUrlParameterWithoutRefresh(response.item_id);
                        $('#item_id').val(response.item_id);

                        previousSize = size;
                        previousColor = color;

                        $('#item_cat').html(response.category);
                        $('#item_name').html(response.name);
                        $('#item_rate').html(response.rate);
                        $('#item_prod_type').html(response.product_type);
                        $('#item_per_unit_rate').html(response.rate);
                        $('#item_unit').html(response.unit);
                        $('#item_desc').html(response.description);
                        $('#item_size').html(response.size);
                        $('#item_color').html(response.variant);



                    } else {
                        $('input[name="sizes"][value="' + previousSize + '"]').prop('checked', true);
                        $('input[name="colors"][value="' + previousColor + '"]').prop('checked', true);
                        // alert('Item In This Variant Is Not Available');
                        Swal.fire({
                            icon: 'error',
                            title: 'Not Available At The Moment',
                            text: 'Item In This Variant Is Not Available!',
                        })
                    }

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }

        var itemImages = @json($item_images);
        var sizes = @json($SIZE);
        var colors = @json($COLORS);
        var group_id = '{{ $item->group_id ?? '' }}';

        var size_selected = '{{ $item->size ?? '' }}';
        var color_selected = '{{ $item->variant ?? '' }}';

        var previousSize = size_selected;
        var previousColor = color_selected;


        // for on change for color or size
        $('.onchangeAttr').on('change', function() {
            // alert(selected_size);
            var size = $('input[name="sizes"]:checked').val();
            var color = $('input[name="colors"]:checked').val();

            call_Ajax(size, color, group_id, previousSize, previousColor, itemImages, '', '', '');

        });

        // for direct click on item
        $('.item_image_bg').click(function() {
            var val = $(this).data('val');
            // alert(val);
            call_Ajax('', '', group_id, previousSize, previousColor, itemImages, val, sizes, colors);
        });


        // for previous click on carousel
        $('.carousel-control-prev').click(function() {

            var activeItem = $('.carousel-item.active');
            var previousItem = activeItem.prev('.carousel-item');
            var imageVal = previousItem.find('.img_item').data('src');
            call_Ajax('', '', group_id, previousSize, previousColor, itemImages, imageVal, sizes, colors);

        });


        // first need to attach caoursel slide event for next
        $('#productCarousel').on('slide.bs.carousel', function(event) {
            var nextSlide = $(event.relatedTarget);
            var imageVal = nextSlide.find('.img_item').data('src');

            $('#item_img').attr('src', imageVal);
        });

        // then apply on click and get data also move to first mnaually when it comes to end
        $('.carousel-control-next').click(function() {
            var activeItem = $('.carousel-item.active');
            var nextItem = activeItem.next('.carousel-item');

            if (nextItem.length === 0) {
                nextItem = $('.carousel-item').first();
            }
            var imageVal = nextItem.find('.img_item').data('src');
            call_Ajax('', '', group_id, previousSize, previousColor, itemImages, imageVal, sizes, colors);


        });
    </script>

@endsection
