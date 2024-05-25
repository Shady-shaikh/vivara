<?php
    use App\Models\backend\Cmspages;
    use App\Models\backend\Items;
    
    $cmspages = Cmspages::all();
    
    $items = Items::get();
    $uniqueCategories = $items
        ->pluck('category')
        ->unique()
        ->values()
        ->toArray();
    
    // dd($uniqueCategories);
    
?>


<!-- Footer -->
<footer class="section footer bg-dark pb-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3">
                <h1 class="logo">Vivara <span>Warehouse</span></h1>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae
                    laboriosam nesciunt porro ex voluptates? Molestias suscipit
                    accusamus temporibus et dolorem?
                </p>
            </div>
            <div class="col-lg-2">
                <h5>Quick Links</h5>
                <ul>
                    
                    <?php $__currentLoopData = $cmspages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if($row->show_hide && $row->cms_pages_footer && empty($row->cms_pages_link)): ?>
                            <li><a href="<?php echo e(route('pages.index', ['id' => $row->cms_slug])); ?>">
                                    <i class="fal fa-chevron-right"></i>
                                    <span><?php echo e($row->cms_pages_title); ?></span></a></li>
                        <?php else: ?>
                        <li><a href="<?php echo e($row->cms_pages_link); ?>" target="_blank">
                          <i class="fal fa-chevron-right"></i>
                          <span><?php echo e($row->cms_pages_title); ?></span></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>
            </div>

            <div class="col-lg-4">
                <h5>Categories</h5>
                <div class="row g-5">
                    <div class="col-lg-6">
                        <ul>
                            
                            <?php $__currentLoopData = $uniqueCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('products.index', ['id' => $row])); ?>">
                                        <i class="fal fa-chevron-right"></i>
                                        <span><?php echo e($row); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-3">
                <h5>Quick Connect</h5>
                <div class="info">
                    <div class="icon">
                        <i class="fal fa-phone-alt"></i>
                    </div>
                    <div class="text">
                        <h6>Phone Number</h6>
                        <a href="#">+91-9876543210</a>
                    </div>
                </div>
                <div class="info">
                    <div class="icon">
                        <i class="fal fa-envelope"></i>
                    </div>
                    <div class="text">
                        <h6>Email</h6>
                        <a href="#">contact@vivara.com</a>
                    </div>
                </div>
                <div class="info">
                    <div class="icon">
                        <i class="fal fa-map"></i>
                    </div>
                    <div class="text">
                        <h6>Address</h6>
                        <a href="#">
                            Wadi Bunder Cotton Press Co. Near Haji Kasam Compound,
                            Dockyard Rd, near Railway Station, Mumbai, Maharashtra 400010.
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-5" />
        <div class="row g-5">
            <div class="col-lg-6">
                <p class="copy-text">&copy; Copyright Reserved | 2023</p>
            </div>
            <div class="col-lg-6">
                <p class="copy-text text-end">
                    Powered by <a href="#" target="_blank">Parasight Solutions</a>
                </p>
            </div>
        </div>
    </div>
</footer>


<!-- END: Footer-->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/lightbox-plus-jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/lightbox.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/bootstrap.bundle.min.js')); ?> "></script>
<script src="<?php echo e(asset('public/frontend-assets/js/app.js')); ?> "></script>



<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>



<script src="<?php echo e(asset('public/frontend-assets/js/jquery.magnific-popup.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/jquery.magnific-popup.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/toastr.min.js')); ?>"></script>


<script src="<?php echo e(asset('public/backend-assets/vendors/js/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/backend-assets/vendors/js/dataTables.bootstrap4.min.js')); ?>"></script>

<script>
    $('#tbl-datatable').DataTable({
        responsive: true
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    var idValue = '';
    $('.add_cart').click(function(event) {
        event.preventDefault();
        idValue = $(this).attr('id');
        // alert(idValue);

        var url = "<?php echo e(route('cart.store', ['id' => ':idValue'])); ?>";
        url = url.replace(':idValue', idValue);
        // console.log(url);

        // Make an AJAX request
        $.ajax({
            url: url,
            'method': 'GET',
            data: {
                check: 'from_ajax',
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                if (response) {
                    Swal.fire({
                        title: response.status,
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Request failed. Status: ' + status + ', Error: ' +
                    error);
            }
        });
    });
</script>


<script>
    $(".hero-carousel").owlCarousel({
        loop: true,
        margin: 0,
        autoWidth: true,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 2,
            },
        },
    });
    $(".category-carousel").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        navText: [
            "<i class='fal fa-long-arrow-left'></i>",
            "<i class='fal fa-long-arrow-right'></i>",
        ],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            },
        },
    });
</script>



<script>
    function calculateTotal(quantity) {
        var rate = parseFloat($('#rate').text());
        // Check if both quantity and rate are valid numbers
        if (!isNaN(quantity) && !isNaN(rate)) {
            var total = quantity * rate;
            $('#total').text(total.toFixed(2)); // Display total with 2 decimal places
        } else {
            $('#total').text(''); // Clear the total if invalid input
        }
    }


    $('#quantity-input').on('change', function() {
        var quantity = $(this).val();
        if (quantity) {
            calculateTotal(quantity);
        }
    });

    $(document).ready(function() {

        var quantity = $('#quantity-input').val();
        if (quantity) {
            calculateTotal(quantity);
        }



    });
</script>

<script src="<?php echo e(asset('public/frontend-assets/js/country-states.js')); ?>"></script>

<script>
    var country = '<?php echo isset($bill_add->country) ? $bill_add->country : $userdata->country ?? ''; ?>';
    var country_c = '<?php echo isset($ship_add->country) ? $ship_add->country : $userdata->country ?? ''; ?>';
    var state = '<?php echo isset($bill_add->state) ? $bill_add->state : $userdata->state ?? ''; ?>';
    var state_c = '<?php echo isset($ship_add->state) ? $ship_add->state : $userdata->state ?? ''; ?>';

    const country_array = country_and_states.country;
    const states_array = country_and_states.states;

    // console.log(states_array);

    function createCountryNamesDropdown(id_country_option, id = null) {
        let option = '<option value="">Select country</option>';
        let drop = '';
        if (id === 'country') {
            drop = country;
        } else if (id === 'country_c') {
            drop = country_c;
        }
        if (drop === 'IN') {
            drop = 'India';
        }
        for (let country_code in country_array) {
            // set selected option user country
            let selected = (country_array[country_code] === drop) ? ' selected' : '';
            option += '<option value="' + country_array[country_code] + '"' + selected + '>' + country_array[
                country_code] + '</option>';
        }
        id_country_option.innerHTML = option;
    }

    function createStatesNamesDropdown(id_country_option, id_state_option, country = null) {
        let selected_country_name = country ?? id_country_option.value;
        let selected_country_code = '';
        for (let country_code in country_array) {
            if (country_array[country_code] === selected_country_name) {
                selected_country_code = country_code;
                break;
            }
        }
        let state_names = states_array[selected_country_code];
        if (!state_names) {
            id_state_option.innerHTML = '<option value="">Select state</option>';
            return;
        }
        let option = '<option value="">Select state</option>';
        let drop = '';
        if (id_state_option.id === 'state') {
            drop = state;
        } else if (id_state_option.id === 'state_c') {
            drop = state_c;
        }
        for (let i = 0; i < state_names.length; i++) {
            if (drop === state_names[i].code) {
                option += '<option value="' + state_names[i].code + '" selected>' + state_names[i].name + '</option>';
            } else {
                option += '<option value="' + state_names[i].code + '">' + state_names[i].name + '</option>';
            }
        }
        id_state_option.innerHTML = option;
    }

    (() => {
        const id_country_option = document.querySelectorAll(".country_dropdown");
        const id_state_option = document.getElementById("state");
        const id_state_option1 = document.getElementById("state_c");

        // Call createCountryNamesDropdown for each country dropdown
        id_country_option.forEach(countryDropdown => {
            createCountryNamesDropdown(countryDropdown, countryDropdown.id);
        });

        // console.log(id_country_option);
        if (id_country_option.length > 0) {
            // Call createStatesNamesDropdown for the initial state dropdown
            createStatesNamesDropdown(id_country_option[0], id_state_option);
            createStatesNamesDropdown(id_country_option[1], id_state_option1);
        }

        // Event listener for country dropdown change
        $('#country').on('change', function() {
            const selectedCountry = $(this).val();
            createStatesNamesDropdown(id_country_option[0], id_state_option, selectedCountry);
        });

        $('#country_c').on('change', function() {
            const selectedCountry = $(this).val();
            createStatesNamesDropdown(id_country_option[1], id_state_option1, selectedCountry);
        });
    })();
</script>



<script>
    $(document).ready(function() {

        $("#filladdress").on("click", function() {

            if (this.checked) {
                $("#attention_c").val($("#attention").val());
                $("#country_c").val($("#country").val());
                $('#country_c').trigger('change');
                $("#street1_c").val($("#street1").val());
                $("#street2_c").val($("#street2").val());
                $("#city_c").val($("#city").val());
                $("#state_c").val($("#state").val());
                $("#zip_code_c").val($("#zip_code").val());
                $("#phone_c").val($("#phone").val());
                $("#fax_c").val($("#fax").val());
            }

        });
    });
</script>

<script>
    $(document).ready(function() {
        var final_amount = $('#final_amount_s').html();
        $('#shipping_charges').change(function() {
            var id = $(this).val();
            // var user_id = "<?php echo e(Auth()->user()->user_id); ?>";

            // Perform AJAX request to retrieve data based on the selected value
            // Replace the URL with your actual endpoint
            var url = "<?php echo e(route('products.getshipcharge')); ?>"; // Example: '/retrieve-shipping-data'

            $('#final_amount_s').html(0);
            // Make an AJAX request
            $.ajax({
                url: url,
                'method': 'POST',
                data: {
                    id: id,
                    final_amount: final_amount
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    // Process the response data as needed
                    // console.log(response);
                    $('.ship_charge').html(response.ship_cost);
                    $('.shipping_charge').val(response.ship_cost);
                    $('#final_amount_s').html(response.final_amount);
                    $('.final_amount').val(response.final_amount);
                },
                error: function(xhr, status, error) {
                    console.error('Request failed. Status: ' + status + ', Error: ' +
                        error);
                }
            });
        });
    });
</script>
<?php /**PATH /var/www/html/vivara/resources/views/frontend/includes/footer.blade.php ENDPATH**/ ?>