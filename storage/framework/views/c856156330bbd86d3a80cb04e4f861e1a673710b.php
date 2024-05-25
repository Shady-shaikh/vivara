<!DOCTYPE html>
<?php $__env->startSection('title','Sign in'); ?>
<html>

<head>
  <title>Sign in</title>

  <style>
    * {
      font-family: Arial, Helvetica, sans-serif;
    }

    body {
      background-color: #eff4f9;
      position: relative;
      margin: 0px
    }



    .container {
      width: 1000px;
      margin: 0 auto;
    }

    .admin-panel {
      min-height: 100vh;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .adminpanel-right {
      background-color: #fff;
      /* padding: 40px 60px; */
      margin: auto;
    }

    .adminpanel-right label {
      font-size: 16px;
    }

    .form-control {
      background-color: #f3f3f3;
      line-height: 32px;
      border: 0px;
      outline: none;
      border-radius: 5px;
      color: #000;
    }

    .form-control::placeholder {
      font-weight: 300;
      color: #eee;
    }

    .login-btn {
      background-color: #faa52a;
      padding: 5px 40px;
      font-weight: 700;
      font-size: 20px;
      line-height: 32px;
      border-radius: 5px;
      color: #fff;
    }

    .login-btn:hover {
      background-color: #004460;
      color: #fff;
    }

    .adminpanel-left {
      width: 38%;
      float: left;
    }

    .adminpanel-right {
      width: 54%;
      padding: 3% 4%
    }

    .adminpanel-left img {
      width: 100%;
      height: 409.5px;
      object-fit: cover;
    }

    .adminpanel-right h2 {
      color: #004460;
      font-weight: 700;
      font-size: 35px;
    }

    .logo-img {
      margin-bottom: 20px;
    }

    .form-control::placeholder {
      font-weight: 300;
      color: #eee;
    }

    .login-btn {
      background-color: #faa52a;
      padding: 5px 40px;
      font-weight: 700;
      font-size: 20px;
      line-height: 32px;
      border-radius: 5px;
      color: #fff;
    }

    .login-btn:hover {
      background-color: #004460;
      color: #fff;
    }

    .adminpanel-right h2 {
      color: #004460;
      font-weight: 700;
      font-size: 25px;
    }

    .fields_container {
      display: grid;
      grid-template-columns: 2fr 2fr;
      grid-gap: 15px;
    }

    .form {
      position: relative;
      z-index: 1;
      /* background: #ffffff; */
      max-width: 100%;
      /* margin: 0 auto 100px; */
      /* padding: 42px; */
      /* text-align: center; */
      /* box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); */
    }

    .form input {
      font-family: "Roboto", sans-serif;
      outline: 0;
      background: #eff4f9;
      width: 100%;
      border: 0;
      margin: 0 0 15px;
      padding: 10px;
      box-sizing: border-box;
      font-size: 14px;
    }

    .form button {
      margin-top: 10px;
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

    .login-page .form button {
      width: 36%;
    }

    .form button:hover,
    .form button:active,
    .form button:focus {
      background: #004761;
    }

    .form .message {
      margin: 15px 0 10px 0;
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

    .form-check {
      display: block;
      min-height: 1.25rem;
      padding-left: 1.5rem;
      margin-bottom: 0.5rem;
    }

    .form-check-input[type=checkbox] {
      border-radius: 4px;
    }

    .form-check .form-check-input {
      float: left;
      margin-left: -1.5rem;
    }

    .form-check-input {
      background-size: 1rem;
      margin-top: 0.125rem;
    }

    @media  screen and (min-device-width: 320px) and (max-device-width: 767px) {

      .adminpanel-left,
      body::before {
        display: none;
      }

      .container {
        max-width: 100%;
      }

      .adminpanel-right h2 {
        font-size: 28px;
      }

      .adminpanel-right {
        padding: 30px 30px;
      }
    }

    @media  screen and (min-device-width: 320px) and (max-device-width: 1070px) and (orientation: landscape) {
      .adminpanel-left {
        display: none;
      }

      .adminpanel-right h2 {
        font-size: 28px;
      }
    }

    @media  screen and (min-device-width: 768px) and (max-device-width: 1200px) {
      .adminpanel-left img {
        object-fit: cover;
      }

      .adminpanel-right {
        padding: 20px;
      }

      .adminpanel-right h2 {
        font-size: 30px;
      }
    }
  </style>
  <link rel=" stylesheet" type="text/css" href="<?php echo e(asset('public/frontend-assets/css/toastr.min.css')); ?>">
</head>


<body>
  <section class="admin-panel">

    <div class="container">
      <div class="row d-flex justify-content-center text-center g-0">
        <div class=" adminpanel-right text-start login-page">



  
          <form class="login-form card card-md form" action="<?php echo e(route('user.auth')); ?>" method="POST">
            <h2 class="heading card-title text-center">Login to your account</h1>
              <div class="card-body">
                <?php echo csrf_field(); ?>
                <input type="email" name="email" placeholder="Enter Email" />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: red;font-size:0.9em;display:block;">
                  <?php echo e($message); ?>

                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <input type="password" name="password" placeholder="password" />
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: red;font-size:0.9em;display:block;">
                  <?php echo e($message); ?>

                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        



                <button type="submit">Login</button>
                <p class="message">Not registered? <a href="<?php echo e(url('/user/register')); ?>">Create an account</a></p>
                <a class="message" href="<?php echo e(route('user.forgot_password')); ?>">Forgot Password</a>
              </div>
          </form>
                
        </div>
      </div>
    </div>
  </section>
</body>
<script src="<?php echo e(asset('public/backend-assets/assets/js/jquery-3.6.1.min.js')); ?>" crossorigin="anonymous"></script>
<script src="<?php echo e(asset('public/frontend-assets/js/toastr.min.js')); ?>"></script>

<?php echo $__env->make('frontend.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</html><?php /**PATH /home/parasigh/public_html/vivara/resources/views/frontend/account/userLogin.blade.php ENDPATH**/ ?>