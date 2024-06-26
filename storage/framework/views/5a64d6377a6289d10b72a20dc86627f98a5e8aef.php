<?php
    use App\Models\frontend\Department;
    $user_id = Auth()->user()->user_id;
?>

<?php $__env->startSection('title', 'User Dashboard | Edit Profile'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .bg-c{
  background-color: #ccc !important;
}
</style>





    <section class="section profile">
        <div class="container-fluid">
            <div class="row px-lg-5 gap-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="navigation">
                            <div class="back mb-5">
                                <a class="d-flex" href="<?php echo e(route('user.dashboard')); ?>">
                                    <i class="fas fa-chevron-left mini-heading"></i>
                                    <h5 class="mini-heading">Go Back</h5>
                                </a>
                            </div>


                            <div class="parameters">

                                <ul class="">
                                    <li class="mb-2"><a class="dropdown-item" href="<?php echo e(route('user.profile', ['id' => $user_id])); ?>"> Edit Profile</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="<?php echo e(route('user.address', ['id' => $user_id])); ?>"> Address</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="<?php echo e(route('myorders.orders')); ?>"> Order History</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="<?php echo e(route('payment.index')); ?>"> Payment History</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="<?php echo e(route('user.changePassword')); ?>">Change Password</a></li>
                                    <li class="mb-2"><a class="dropdown-item text-danger" href="<?php echo e(route('user.logout')); ?>">Logout</a></li>
                                  </ul>


                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-7">
                    <div class="card">


                        <div class="profile-details">
                            <div class="name mb-5">
                                <h1 class="heading">Your Profile</h1>
                                
                            </div>

                            <div class="profile-photo mb-5">
                                <h6 class="mini-heading mb-4" style="font-size: 18px;">Profile Details</h6>
                                <!-- <div class="photo d-flex mb-4">
                                                <img src="./static/images/profile.png" alt="profile-photo" style="width: 30%;">

                                                <div class="edit-btns">
                                                    <ul>
                                                        <li>
                                                            <a href="">
                                                                <span>Upload photo</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="fal fa-trash-alt"></i>
                                                                <span>Remove Photo</span>
                                                            </a>
                                                        </li>
                                                    </ul>


                                                </div>

                                            </div> -->
                                
                            </div>

                            <div class="details-form">
                                <?php echo $__env->make('backend.includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                                <?php echo Form::model($userdata, [
                                    'method' => 'POST',
                                    'url' => ['/user/updateProfile'],
                                    'class' => 'form row g-3',
                                ]); ?>

                                <?php echo csrf_field(); ?>
                                <div class="col-md-6">
                                    <?php echo e(Form::label('first_name', 'First Name *')); ?>

                                    <?php echo e(Form::hidden('user_id', $userdata->user_id, ['class' => 'form-control'])); ?>

                                    <?php echo e(Form::text('name', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter First Name',
                                        'required' => true,
                                    ])); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo e(Form::label('last_name', 'Last Name *')); ?>

                                    <?php echo e(Form::text('last_name', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Last Name',
                                        'required' => true,
                                    ])); ?>

                                </div>
                                <div class="col-md-12">
                                    <?php echo e(Form::label('email', 'Email *')); ?>

                                    <?php echo e(Form::text('email', null, [
                                        'class' => 'form-control ',
                                        'placeholder' => 'Enter Email',
                                        // 'readonly' => true,
                                        'required' => true,
                                    ])); ?>

                                </div>
                                
                                <!-- <div class="col-12">
                                                    <label for="companyName" class="form-label">Company Name</label>
                                                    <input type="text" class="form-control" id="companyName">
                                                </div> -->
                                <!-- <div class="col-12">
                                                    <label for="inputAddress" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="inputAddress"
                                                        placeholder="1234 Main St">
                                                </div> -->
                                <!-- <div class="col-12">
                                                <label for="inputAddress2" class="form-label">Address 2</label>
                                                <input type="text" class="form-control" id="inputAddress2"
                                                    placeholder="Apartment, studio, or floor">
                                            </div> -->
                                <div class="col-12">
                                    <?php echo e(Form::label('mobile_no', 'Mobile_on *')); ?>

                                    <?php echo e(Form::text('mobile_no', null, [
                                        'class' => 'form-control  ',
                                        'placeholder' => 'Enter Last Name',
                                        // 'readonly' => true,
                                        'required' => true,
                                    ])); ?>

                                </div>
                                
                                <?php echo e(Form::select('country', [], null, ['class' => 'form-control d-none', 'id' => 'country', 'required'])); ?>



                                <div class="col-md-6">
                                    <?php echo e(Form::label('state', 'Select State *')); ?>

                                    
                                    <?php echo e(Form::select('state', [], null, ['class' => 'form-control', 'id' => 'state', 'required'])); ?>

                                </div>
                                <!-- <div class="col-md-2">
                                                <label for="inputZip" class="form-label">Zip</label>
                                                <input type="text" class="form-control" id="inputZip">
                                            </div> -->
                                <!-- <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                                    <label class="form-check-label" for="gridCheck">
                                                        Check me out
                                                    </label>
                                                </div>
                                            </div> -->
                                <div class="col-12">
                                    <div class="update">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="reset" class="btn btn-primary">Reset</button>
                                    </div>
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>



    <script src="<?php echo e(asset('public/frontend-assets/js/country-states.js')); ?>"></script>

    <script>
        // user country code for selected option
        var user_country_code = "IN";

        var state = '<?php echo isset($userdata->state) ? $userdata->state : ''; ?>';

        // alert(state);

        (() => {
            // script https://www.html-code-generator.com/html/drop-down/state-name

            // Get the country name and state name from the imported script.
            const country_array = country_and_states.country;
            const states_array = country_and_states.states;
            // console.log(states_array);

            const id_state_option = document.getElementById("state");
            const id_country_option = document.getElementById("country");

            const createCountryNamesDropdown = () => {
                let option = '';
                option += '<option value="">select country</option>';

                for (let country_code in country_array) {
                    // set selected option user country
                    let selected = (country_code == user_country_code) ? ' selected' : '';
                    option += '<option value="' + country_code + '"' + selected + '>' + country_array[
                        country_code] + '</option>';
                }
                id_country_option.innerHTML = option;
            };

            const createStatesNamesDropdown = () => {
                let selected_country_code = id_country_option.value;
                // get state names
                let state_names = states_array[selected_country_code];

                // if invalid country code
                if (!state_names) {
                    id_state_option.innerHTML = '<option value="">select state</option>';
                    return;
                }
                let option = '';
                option += '<select id="state">';
                option += '<option value="">select state</option>';
                for (let i = 0; i < state_names.length; i++) {
                    if (state == state_names[i].code) {
                        option += '<option value="' + state_names[i].code + '" selected>' + state_names[i].name +
                            '</option>';
                    } else {
                        option += '<option value="' + state_names[i].code + '">' + state_names[i].name +
                            '</option>';
                    }
                }
                option += '</select>';
                id_state_option.innerHTML = option;
            };

            // country select change event
            id_country_option.addEventListener('change', createStatesNamesDropdown);

            createCountryNamesDropdown();
            createStatesNamesDropdown();
        })();
    </script>
    <br>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/parasigh/public_html/vivara/resources/views/frontend/users/editProfile.blade.php ENDPATH**/ ?>