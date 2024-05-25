@php
    use App\Models\backend\Cmspages;
    
    $cmspages = Cmspages::all();
    
@endphp
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<!--<footer class="footer footer-transparent d-print-none" {{-- style="position: fixed; bottom: 0; width: 100%" --}}>-->
<!--    <div class="container-fluid">-->
<!--        <div class="row text-center align-items-center flex-row-reverse">-->
<!--            <div class="col-lg-auto ms-lg-auto">-->
<!--                <ul class="list-inline list-inline-dots mb-0">-->
<!--                </ul>-->
<!--            </div>-->
<!--            <div class="col-12 col-lg-auto mt-3 mt-lg-0">-->

<!--                @foreach ($cmspages as $row)
-->
<!--                    @if ($row->cms_pages_footer && $row->show_hide)
-->
<!--                        {!! $row->cms_pages_content !!}-->
<!--
@endif-->
<!--
@endforeach-->
<!--                {{-- <ul class="list-inline list-inline-dots mb-0">-->
<!--                    <li class="list-inline-item">-->
<!--                        Copyright &copy; 2023-->
<!--                        <a href="https://www.jmbaxi.com" target="_blank">Vivara</a>. All rights reserved.-->
<!--                    </li>-->
<!--                </ul> --}}-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</footer>-->

<!-- END: Footer-->

<!-- BEGIN: Vendor JS-->
<script src="{{ asset('public/backend-assets/app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('public/backend-assets/app-assets/vendors/js/charts/apexcharts/apexcharts.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('public/backend-assets/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('public/backend-assets/app-assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

{{-- jquery --}}
<script src="{{ asset('public/backend-assets/assets/js/jquery-3.6.1.min.js') }}"></script>
{{-- <script src="{{ asset('public/backend-assets/assets/js/jquery-3.3.1.slim.min.js') }}"></script> --}}
<script src="{{ asset('public/backend-assets/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
{{-- jquery --}}
<!-- BEGIN: Page JS-->
<script src="{{ asset('public/backend-assets/app-assets/js/scripts/cards/card-statistics.js') }}"></script>
<!-- END: Page JS-->

{{-- --}}
<!-- Libs JS -->
{{-- <script src="{{ asset('public/frontend-assets/js/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('public/frontend-assets/js/tabler.min.js') }}"></script>
<script src="{{ asset('public/frontend-assets/js/demo.min.js') }}"></script>
<!-- Tabler Core -->

{{-- Date time jquery --}}
{{-- <script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
</script> --}}

<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>

{{-- Drag and drop upload files source --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"
    integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}


<script src="{{ asset('public/frontend-assets/js/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('public/frontend-assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('public/frontend-assets/js/toastr.min.js') }}"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
    integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}



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

<script src="{{ asset('public/frontend-assets/js/country-states.js') }}"></script>

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

        // Call createStatesNamesDropdown for the initial state dropdown
        createStatesNamesDropdown(id_country_option[0], id_state_option);
        createStatesNamesDropdown(id_country_option[1], id_state_option1);

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


{{-- for copy address --}}
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
