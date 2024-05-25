<?php $__env->startSection('title', 'Item'); ?>

<?php
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
    
?>

<?php $__env->startSection('content'); ?>
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
        @keyframes  fadeInOut {
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



            <?php if(!empty($item)): ?>
                <div class="row justify-content-center g-5">
                    <div class="col-md-5">
                        <div class="product-carousel">
                            <?php if(!empty($item_images)): ?>
                                <div id="productCarousel" class="carousel slide">


                                    <div class="carousel-indicators">


                                        <?php $__currentLoopData = $item_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $url = asset('/public/frontend-assets/images/') . '/' . $val;
                                                
                                                $class = '';
                                                if ($val == $item->item_image) {
                                                    $class = 'active';
                                                }
                                                
                                            ?>

                                            <button type="button" data-bs-target="#productCarousel"
                                                data-bs-slide-to="<?php echo e($key); ?>"
                                                class="<?php echo e($class); ?> item_image_bg" aria-current="true"
                                                aria-label="Slide 1" style="background-image: url(<?php echo e($url); ?>);"
                                                data-val="<?php echo e($val); ?>">
                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </div>
                                    <div class="carousel-inner">

                                        <?php $__currentLoopData = $item_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $url = asset('/public/frontend-assets/images/') . '/' . $val;
                                                
                                                $class = '';
                                                if ($val == $item->item_image) {
                                                    $class = 'active';
                                                }
                                            ?>

                                            <div class="carousel-item <?php echo e($class); ?>">
                                                <?php if(!empty($val)): ?>
                                                    <img id="item_img" class="img_item" src="<?php echo e($url); ?>"
                                                        class="d-block w-100" alt="..." data-src=<?php echo e($val); ?>>
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('/public/frontend-assets/images/') . '/' . 'demo_image.png'); ?> "
                                                        alt="" class="d-block w-100" />
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                            <?php endif; ?>
                        </div>

                    </div>

                    <!-- prices and stuff -->
                    <div class="col-md-6">
                        <div class="name">
                            <h5 class="sub-heading mb-2" id="item_cat"><?php echo e($item->category); ?></h5>
                            <h4 class="heading mb-4" id="item_name"><?php echo e($item->name); ?> </h4>

                            <h6>
                                <b>&#8377; <span id="item_rate"><?php echo e($item->rate); ?> </span> /-</b>
                                

                            </h6>
                            <span>
                                <?php if(!empty($item->get_offers)): ?>
                                    <?php echo e(' (' . $item->get_offers->scheme_title . ')'); ?>

                                <?php endif; ?>
                            </span>
                            <!-- <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus aspernatur
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      repellat
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      deleniti! Blanditiis itaque.</p> -->
                            <hr class="my-4">
                        </div>
                        <?php if(!empty($SIZE[0])): ?>
                            <div class="size d-flex align-items-center my-4">

                                <div class="sizes mb-2">
                                    <h5>Select Size</h5>
                                    <div class="all-size d-flex mt-2">

                                        <?php $__currentLoopData = $SIZE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $checked = '';
                                                if ($val == $item->size) {
                                                    $checked = 'checked';
                                                }
                                            ?>

                                            <div class="size">
                                                <input type="radio" name="sizes" id="sizeS_<?php echo e($key); ?>"
                                                    <?php echo e($checked); ?> class="onchangeAttr size_attr"
                                                    value="<?php echo e($val); ?>">
                                                <label for="sizeS_<?php echo e($key); ?>">
                                                    <span><?php echo e($val); ?></span>
                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($COLORS[0])): ?>
                            <div class="colors d-flex align-items-center mb-4">
                                <div class="color mb-2">
                                    <h5>Choose Color</h5>
                                    <div class="colors d-flex mt-2">

                                        <?php $__currentLoopData = $COLORS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $checked = '';
                                                if ($val == $item->variant) {
                                                    $checked = 'checked';
                                                }
                                            ?>

                                            <div class="color-red">
                                                <input type="radio" name="colors" id="clrRed_<?php echo e($key); ?>"
                                                    <?php echo e($checked); ?> class="onchangeAttr color_attr"
                                                    value="<?php echo e($val); ?>">
                                                <label for="clrRed_<?php echo e($key); ?>">
                                                    <i style="background-color:<?php echo e($val); ?> "></i>
                                                    <span><?php echo e($val); ?></span>
                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                </div>

                            </div>
                        <?php endif; ?>


                        <form method="post" action="<?php echo e(route('cart.update', ['id' => $item->item_id])); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="btns d-flex mb-4">
                                <select class="form-select" name="quantity[]" aria-label="Default select example">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="4">Four</option>
                                    <option value="5">Five</option>
                                    <option value="6">Six</option>
                                </select>
                                <input type="hidden" name="item_id[]" id="item_id" value="<?php echo e($item->item_id); ?>">

                                <button type="submit" id="submit-button">
                                    <span>Add To Cart</span>
                                    <i class="fal fa-shopping-cart"></i>
                                </button>
                                <!-- <a href="#">View Product</a> -->
                            </div>
                        </form>
                        <hr class="my-4">
                        

                        <div class="product-details">
                            <div class="description">
                                <h6 class="mb-2" style="color: var(--bs-body-color); font-weight: 600;">Description</h6>
                                <h6 class="d-flex mb-2">
                                    <!-- <span class="Title">Product Type : </span> -->
                                    Product Type :
                                    <span class="description" id="item_prod_type"> <?php echo e($item->product_type); ?></span>
                                </h6>

                                <h6 class="d-flex mb-2">
                                    <span class="Title">Rate : </span>
                                    <span class="description" id="item_per_unit_rate"> <?php echo e($item->rate); ?> </span>
                                </h6>

                                <h6 class="d-flex mb-2">
                                    <span class="Title">Usuage Unit : </span>
                                    <span class="description" id="item_unit"> <?php echo e($item->unit); ?></span>
                                </h6>

                            </div>

                            <div class="details">
                                <h6 class="mt-4 mb-2" style="color: var(--bs-body-color); font-weight: 600;">Product
                                    details
                                </h6>
                                <p id="item_desc">
                                    <?php echo e($item->description); ?>

                                </p>
                            </div>

                            <div class="size my-4">
                                <h6 class="mt-4 mb-2" style="color: var(--bs-body-color); font-weight: 600;">Size</h6>
                                <h6 class="mb-2">Size : <span
                                        id="item_size"><?php echo e(!empty($item->size) ? $item->size : 'None'); ?> <span></h6>
                                <h6 class="mb-2">Color : <span
                                        id="item_color"><?php echo e(!empty($item->variant) ? $item->variant : 'None'); ?> <span></h6>

                            </div>

                            <div class="table">
                                <h6 class="mb-2">Specifications</h6>
                                <table class="table .table-borderless">
                                    <tbody>
                                        <tr>

                                            <td>Item Type</td>
                                            <td><?php echo e($item->item_type); ?></td>

                                        </tr>
                                        <tr>

                                            <td>SKU</td>
                                            <td id="sku"><?php echo e($item->sku ?? '-'); ?></td>

                                        </tr>
                                        <tr>

                                            <td>HSN/SAC</td>
                                            <td id="hsn"><?php echo e(!empty($item->hsn_or_sac)?$item->hsn_or_sac: '-'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <hr>
                <div class="text-center">
                    <h5>No Such Item Exists</h5>
                    <a href="<?php echo e(route('products.index')); ?>">See All Products</a>
                </div>
            <?php endif; ?>
        </div>
        
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

       

        function updateCarousel(imageUrl, currentIndex,item_id,currentImage) {
            // Update the carousel item
            if(item_id){
                $.ajax({
                url: '<?php echo e(route('products.get_item_images')); ?>',
                method: 'POST', // Use 'GET' or 'POST' based on your requirements
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    item_id: item_id,
                },
                success: function(response) {
                    // Handle the AJAX response here
                    var images = response.image_name;
                    images = images.split(',');
                    var html='';
                    var html_images='';
                    var url='';
                    // console.log(images);
                    for(var i=0;i<images.length;i++){
                        // console.log(aClass);
                        url =   "<?php echo e(asset('/public/frontend-assets/images/') . '/'); ?>" + images[i];
                        var aClass = (images[i] == currentImage) ? 'active' : ''; 

                         html += `<button type="button" data-bs-target="#productCarousel"
                                                data-bs-slide-to="${i}"
                                                class=" ${aClass} item_image_bg" aria-current="true"
                                                aria-label="Slide 1" style="background-image: url(${url});"
                                                data-val="${images[i]}">`;

                        html_images += `<div class="carousel-item ${aClass}"><img id="item_img" class="img_item" src="${url}"class="d-block w-100" alt="..." data-src=${images[i]}></div>`;

                        }
                        $('.carousel-indicators').html(html);
                        $('.carousel-inner').html(html_images);
                        // $('.carousel-indicators button').eq(currentIndex).addClass(aClass);
                  
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
               });
            }
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
                url: '<?php echo e(route('products.get_same_group_item')); ?>',
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
                            "<?php echo e(asset('/public/frontend-assets/images/') . '/'); ?>" + response
                            .item_image,
                            currentIndex,
                            response.item_id,
                            currentImage
                        );
                        // alert(currentIndex);




                        updateUrlParameterWithoutRefresh(response.item_id);
                        $('#item_id').val(response.item_id);

                        // previousSize = size;
                        // previousColor = color;

                        $('#item_cat').html(response.category);
                        $('#item_name').html(response.name);
                        $('#item_rate').html(response.rate);
                        $('#item_prod_type').html(response.product_type);
                        $('#item_per_unit_rate').html(response.rate);
                        $('#item_unit').html(response.unit);
                        $('#item_desc').html(response.description);
                        $('#item_size').html(response.size);
                        $('#item_color').html(response.variant);
                        $('#sku').html(response.sku);
                        $('#hsn').html(response.hsn_or_sac);



                    } else {
                        $('input[name="sizes"][value="' + previousSize + '"]').prop('checked', true);
                        $('input[name="colors"][value="' + previousColor + '"]').prop('checked', true);
                        // alert('Item In This Variant Is Not Available');
                        let timerInterval
                        Swal.fire({
                          title: 'Item In This Variant Is Not Available At The Moment!',
                          timer: 2500,
                          timerProgressBar: true,
                          didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                              b.textContent = Swal.getTimerLeft()
                            }, 100)
                          },
                          willClose: () => {
                            clearInterval(timerInterval)
                          }
                        });
                    }

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }

        var itemImages = <?php echo json_encode($item_images, 15, 512) ?>;
        var sizes = <?php echo json_encode($SIZE, 15, 512) ?>;
        var colors = <?php echo json_encode($COLORS, 15, 512) ?>;
        var group_id = '<?php echo e($item->group_id ?? ''); ?>';

        var size_selected = '<?php echo e($item->size ?? ''); ?>';
        var color_selected = '<?php echo e($item->variant ?? ''); ?>';

        var previousSize = size_selected;
        var previousColor = color_selected;


        // for on change for color or size
        $('.onchangeAttr').on('change', function() {
            // alert(selected_size);
            var size = $('input[name="sizes"]:checked').val();
            var color = $('input[name="colors"]:checked').val();

            // var currentSize = previousSize;
            // var currentColor = previousColor;

            // // Update previousSize and previousColor with the current values
            previousSize = size;
            previousColor = color;

            call_Ajax(size, color, group_id, previousSize, previousColor, itemImages, '', '', '');

        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/products/view.blade.php ENDPATH**/ ?>