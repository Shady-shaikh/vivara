<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-border">


</footer>
<!-- END: Footer-->


<script src="<?php echo e(asset('public/backend-assets/assets/js/bootstrap.bundle.min')); ?>"></script>


<!-- Core -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/@popperjs/core/dist/umd/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>

<!-- Vendor JS -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/onscreen/dist/on-screen.umd.min.js')); ?>"></script>

<!-- Slider -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/nouislider/distribute/nouislider.min.js')); ?>"></script>

<!-- Smooth scroll -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')); ?>">
</script>

<!-- Charts -->

<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/chartist/dist/chartist.min.js')); ?>"></script>
<script
    src="<?php echo e(asset('public/backend-assets/app-assets/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js')); ?>">
</script>

<!-- Datepicker -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js')); ?>">
</script>

<!-- Sweet Alerts 2 -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/sweetalert2/dist/sweetalert2.all.min.js')); ?>"></script>

<!-- Moment JS -->


<!-- Vanilla JS Datepicker -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js')); ?>">
</script>

<!-- Notyf -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/notyf/notyf.min.js')); ?>"></script>

<!-- Simplebar -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/vendor/simplebar/dist/simplebar.min.js')); ?>"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js') }}"></script>

<!-- Volt JS -->
<script src="<?php echo e(asset('public/backend-assets/app-assets/assets/js/volt.js')); ?>"></script>


<script src="<?php echo e(asset('public/frontend-assets/js/toastr.min.js')); ?>"></script>


<script src="<?php echo e(asset('public/backend-assets/ckeditor/ckeditor.js')); ?>" type="text/javascript"></script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/moment.min.js')); ?>"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>




<script>
    $(document).ready(function() {

        // alert('check');


        if ($("#editor").length != 0) {
            CKEDITOR.replace('editor', {
                height: 260,

            });
        }
        if ($("#editor1").length != 0) {
            CKEDITOR.replace('editor1', {
                height: 260,

            });
        }
        if ($("#editor2").length != 0) {

            CKEDITOR.replace('editor2', {
                height: 260,
            });
        }


    });
</script>

<script type="text/javascript">
    $(function() {

        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            autoApply: true,
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                'MM/DD/YYYY'));
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
</script>


<script src="<?php echo e(asset('public/backend-assets/vendors/js/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/backend-assets/vendors/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script>
    $('#tbl-datatable').DataTable({
        responsive: true
    });
</script>
<?php /**PATH /home/parasigh/public_html/vivara/resources/views/backend/includes/footer.blade.php ENDPATH**/ ?>