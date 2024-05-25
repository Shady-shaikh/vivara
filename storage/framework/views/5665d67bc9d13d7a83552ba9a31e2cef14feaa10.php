<?php
use App\Models\frontend\Department;
use App\Models\backend\Company;
use App\Models\backend\Designation;
use App\Models\backend\Location;

?>
<!DOCTYPE html>






<html>

<head>
    <title>Sign up</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            padding: 0;
            margin: 0;
        }

        body {
            background: #f8fafc
        }

        .heading {
            margin: 25px 0 0;
            color: #004761;
        }

        .registration-page {
            width: 720px;
        }

        .login-page {
            width: 360px;
        }

        .registration-page,
        .login-page {
            padding: 2% 0 0;
            margin: auto;
        }

        .fields_container {
            display: grid;
            grid-template-columns: 2fr 2fr;
            grid-gap: 18px;
        }

        .form {
            position: relative;
            z-index: 1;
            /* background: #ffffff; */
            max-width: 100%;
            margin: 0 auto 100px;
            /* padding: 42px; */
            text-align: center;
            /* box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); */
        }

        .form input {

            display: block;
            width: 92%;
            padding: 0.4375rem 0.75rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.4285714;
            color: inherit;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d9dbde;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 4px;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form select {
            width: 100% !important;
            display: block;
            width: 92%;
            padding: 0.4375rem 0.75rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.4285714;
            color: inherit;
            background-color: #fff;
            border: 1px solid #d9dbde;
            border-radius: 4px;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form button {
            margin-top: 20px;
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #004761;
            border: 0;
            padding: 10px;
            color: #ffffff;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
        }

        .registration-page .form button {
            width: 60%;
        }

        .login-page .form button {
            width: 100%;
        }

        .form button:hover,
        .form button:active,
        .form button:focus {
            background: #004761;
        }

        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;
        }

        .form .message a {
            color: #004761;
            text-decoration: none;
        }

        .form .register-form {
            display: none;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 300px;
            margin: 0 auto;
        }

        .container:before,
        .container:after {
            content: "";
            display: block;
            clear: both;
        }

        .container .info {
            margin: 50px auto;
            text-align: center;
        }

        .container .info h1 {
            margin: 0 0 15px;
            padding: 0;
            font-size: 36px;
            font-weight: 300;
            color: #1a1a1a;
        }

        .container .info span {
            color: #4d4d4d;
            font-size: 12px;
        }

        .container .info span a {
            color: #000000;
            text-decoration: none;
        }

        .container .info span .fa {
            color: #ef3b3a;
        }

        /* select {
            height: 36px;
        } */
        .card {
            box-shadow: rgb(30 41 59 / 4%) 0 2px 4px 0;
            border: 1px solid rgba(98, 105, 118, .16);
            background: var(--tblr-card-bg, #fff);
        }

        .card-md>.card-body {
            padding: 2rem;
        }

        .text-center {
            text-align: center
        }

        .mt-2 {
            margin-top: 20px
        }
    </style>
</head>

<body class=" border-top-wide border-primary d-flex flex-column">

    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-4 mt-2">
                <a href="." class="navbar-brand navbar-brand-autodark"><img
                        src="<?php echo e(asset('/public/frontend-assets/images/logo.png')); ?>" alt=""></a>
            </div>


            <div class="registration-page">
                <div class="form">

                    <form class="card card-md" action="<?php echo e(route('user.store')); ?>" method="POST">
                        <h2 class="heading card-title text-center mb-2 mt-2">Create new account</h2>
                        <div class="card-body">
                            <?php echo csrf_field(); ?>
                            <div class="fields_container">
                                <div>
                                    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'required'])); ?>

                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red;font-size:0.9em;display:block;text-align:left">
                                            <?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <?php echo e(Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required'])); ?>


                                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red;font-size:0.9em;display:block;text-align:left">
                                            <?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <?php echo e(Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Company Name', 'required'])); ?>


                                    <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red;font-size:0.9em;display:block;text-align:left">
                                            <?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                


                                <div>
                                    <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'required'])); ?>


                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red;font-size:0.9em;display:block;text-align:left">
                                            <?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <?php echo e(Form::text('mobile_no', null, ['class' => 'form-control', 'placeholder' => 'Enter Mobile No.', 'required'])); ?>


                                    <?php $__errorArgs = ['mobile_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red;font-size:0.9em;display:block;text-align:left">
                                            <?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>


                                
                                    <?php echo e(Form::select('country', [], null, ['class' => 'form-control ','id'=>'country', 'placeholder' => 'Select Country', 'required','style'=>'display:none;'])); ?>

                                

                                <div>
                                    <select id="state" class="form-select" name="state" required>
                                        <option>_</option>
                                    </select>
                                    
                                </div>



                                <div>
                                    <input type="password" onkeypress="return event.charCode != 32" name="password"
                                        value="<?php echo e(old('password')); ?>" placeholder="Enter Password *"
                                        data-toggle="tooltip" data-placement="top"
                                        title="Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit"
                                        required />
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red;font-size:0.9em;display:block;text-align:left">
                                            <?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <input id='password' onkeypress="return event.charCode != 32" type="password"
                                        name="password_confirmation" placeholder="Confirm Password *" required />
                                    <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red;font-size:0.9em;display:block;text-align:left">
                                            <?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                            <button type="submit">Create new account</button>
                            <p class="message">Already have account? <a href="<?php echo e(url('/')); ?>">Sign In</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <script src="<?php echo e(asset('public/frontend-assets/js/country-states.js')); ?>"></script>

    <script>
        // user country code for selected option
        var user_country_code = "IN";

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
                    option += '<option value="' + state_names[i].code + '">' + state_names[i].name + '</option>';
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
</body>

</html>

<?php /**PATH C:\wamp64\www\vivara\resources\views/frontend/account/registration.blade.php ENDPATH**/ ?>