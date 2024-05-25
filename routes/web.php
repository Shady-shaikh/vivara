<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\RolesController;
use App\Http\Controllers\backend\RolesexternalController;

use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\backend\AccountController;
use App\Http\Controllers\backend\CompanyController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\LocationController;
use App\Http\Controllers\backend\AdminusersController;
use App\Http\Controllers\backend\DepartmentController;
use App\Http\Controllers\backend\IdeaController as IC;
use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\backend\ActivityLogController;
use App\Http\Controllers\backend\BackendmenuController;
use App\Http\Controllers\backend\DesignationController;
use App\Http\Controllers\backend\EmailConfigController;
use App\Http\Controllers\backend\ExternalusersController;
use App\Http\Controllers\backend\RewardsController as RC;
use App\Http\Controllers\backend\AdminNotificationController;
use App\Http\Controllers\backend\BackendsubmenuController;
use App\Http\Controllers\frontend\UsersController;
use App\Http\Controllers\backend\CouponController;
use App\Http\Controllers\backend\ProductCarouselController;
use App\Http\Controllers\backend\CategoryCarouselController;
use App\Http\Controllers\backend\CmspagesController;
use App\Http\Controllers\backend\SchemesController;
use App\Http\Controllers\backend\ApplyoffersController;
use App\Http\Controllers\backend\ShippingController;
use App\Http\Controllers\frontend\ProductsController;
use App\Http\Controllers\frontend\PaymentController;
use App\Http\Controllers\backend\InvoiceController;
use App\Http\Controllers\backend\Reports;
use App\Http\Controllers\frontend\MyOrdersController;
use App\Http\Controllers\frontend\PagesController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\backend\GstController;
use App\Http\Controllers\backend\WarehouseController;
use App\Http\Controllers\backend\ProductsmanageController;
use App\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('/user/login', [UserController::class, 'login'])->name('user.login');
// Forgot password
Route::get('/user/forgot_password', [UserController::class, 'forgot_password'])->name('user.forgot_password');
Route::post('/sendotp', [UserController::class, 'sendotp'])->name('sendotp.store');
Route::get('/thankyou', [UserController::class, 'forthankyou'])->name('forthankyou');

Route::get('resettoken/{token}', [UserController::class, 'showResetPasswordForm'])->name('resettoken');
Route::post('/changeforgotpassword', [UserController::class, 'changeforgotpassword'])->name('changeforgotpassword.store');


Route::view('/otp', 'frontend.users.otp');
Route::get('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::post('/user/auth', [UserController::class, 'auth'])->name('user.auth');


//pages
Route::get('/pages/{id?}', [PagesController::class, 'index'])->name('pages.index');
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('/products/{id?}', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/view/{id}', [ProductsController::class, 'view'])->name('products.view');

Route::post('/products/get_same_group_item', [ProductsController::class, 'get_same_group_item'])->name('products.get_same_group_item');
Route::post('/products/get_item_images', [ProductsController::class, 'get_item_images'])->name('products.get_item_images');


Route::group(['middleware' => 'auth'], function () {


  Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');
  Route::get('/user/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
  Route::get('/user/address/{id}', [UserController::class, 'address'])->name('user.address');
  Route::post('/user/updateProfile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
  Route::post('/user/updateAddress', [UserController::class, 'updateAddress'])->name('user.updateAddress');

  // Password
  Route::get('/user/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword');
  Route::get('/user/changeRole', [UserController::class, 'changeRole'])->name('user.changeRole');
  Route::get('/users/updaterole/{role}', [UsersController::class, 'updaterole'])->name('users.updaterole');

  Route::post('/user/updatePassword', [UserController::class, 'updatePassword'])->name('user.updatePassword');



  // Verification mail
  // Route::get('/verify_mail', [UserController::class, 'verifyMail'])->name('verify_mail');
  Route::get('/verify_mail/{token}', [UserController::class, 'verifyMailToken'])->name('verify_mail.token');
  Route::get('/verify_mail_success', [UserController::class, 'verifyMailSuccess'])->name('verify_mail.success');


  //products

  Route::post('/products/purchase/{id}', [ProductsController::class, 'purchase'])->name('products.purchase');
  Route::get('/products/purchase/{check}/{id}', [ProductsController::class, 'purchase'])->name('products.purchase');
  Route::get('/products/checkout/{check}/{data}', [ProductsController::class, 'checkout'])->name('products.checkout');
  Route::get('/products/oauth_callback', [ProductsController::class, 'oauth_callback'])->name('products.oauth_callback');
  Route::post('/products/payment/{id?}{item_id?}', [ProductsController::class, 'payment'])->name('products.payment');
  Route::post('/products/payment_success', [ProductsController::class, 'payment_success'])->name('products.payment_success');
  Route::post('/products/payment_failure', [ProductsController::class, 'payment_failure'])->name('products.payment_failure');
  Route::post('/products/update/', [ProductsController::class, 'update'])->name('products.update');
  Route::post('/products/getdiscountedamount', [ProductsController::class, 'getdiscountedamount'])->name('products.getdiscountedamount');
  Route::post('/products/getshipcharge', [ProductsController::class, 'getshipcharge'])->name('products.getshipcharge');


  //myorders
  Route::get('/invoices', [MyOrdersController::class, 'invoices'])->name('myorders.invoices');
  Route::get('/orders', [MyOrdersController::class, 'orders'])->name('myorders.orders');
  Route::get('/invoices/view/{id}', [MyOrdersController::class, 'invoiceview'])->name('invoices.view');
  Route::get('/invoices/ordersview/{id}', [MyOrdersController::class, 'ordersview'])->name('invoices.ordersview');



  //cart
  Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
  Route::get('/cart/view/{id}', [CartController::class, 'view'])->name('cart.view');
  Route::get('/cart/store/{id}', [CartController::class, 'store'])->name('cart.store');
  Route::get('/cart/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
  Route::get('/cart/edit/{id}', [CartController::class, 'edit'])->name('cart.edit');
  Route::post('/cart/update/{id?}', [CartController::class, 'update'])->name('cart.update');

  //payment
  Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
  Route::get('/payment/view/{id}', [PaymentController::class, 'view'])->name('payment.view');
  // });
});


Route::post('/handleZohoBooksWebhook', [WebhookController::class, 'handleZohoBooksWebhook'])->name('handleZohoBooksWebhook.store');
Route::get('/handleZohoBooksWebhook', [WebhookController::class, 'handleZohoBooksWebhook'])->name('handleZohoBooksWebhook');







Route::get('/clear-cache', function () {
  $exitCode = Artisan::call('cache:clear');
  // return what you want
});
//Clear configurations:
Route::get('/config-clear', function () {
  $status = Artisan::call('config:clear');
  return '<h1>Configurations cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function () {
  $status = Artisan::call('cache:clear');
  return '<h1>Cache cleared</h1>';
});

//Clear configuration cache:
Route::get('/config-cache', function () {
  $status = Artisan::call('config:cache');
  return '<h1>Configurations cache cleared</h1>';
});

//Clear route cache:
Route::get('/route-cache', function () {
  $status = Artisan::call('route:cache');
  return '<h1>Route cache cleared</h1>';
});

//Clear view cache:
Route::get('/view-clear', function () {
  $status = Artisan::call('view:clear');
  return '<h1>View cache cleared</h1>';
});

//dump autoload:
Route::get('/dump-autoload', function () {
  $status = Artisan::call('dump-autoload');
  return '<h1>Dumped Autoload</h1>';
});


// Route::get('/', 'HomeController@index');
// Route::get('/', function () {
// return  'Welcome';
// });


Route::prefix('admin')->group(function () {

  Route::group(['middleware' => 'admin.guest'], function () {
    Route::get('/login', [AccountController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AccountController::class, 'login'])->name('admin.login.submit');

    //backend forgot password
    Route::get('/forgot_password', [AccountController::class, 'forgot_password'])->name('admin.forgot_password');
    Route::post('/sendotp', [AccountController::class, 'sendotp'])->name('admin.sendotp');
    Route::get('/thankyou', [AccountController::class, 'forthankyou'])->name('admin.forthankyou');

    Route::get('/resettoken/{token}', [AccountController::class, 'showResetPasswordForm'])->name('admin.resettoken');
    Route::post('/changeforgotpassword', [AccountController::class, 'changeforgotpassword'])->name('admin.changeforgotpassword');
  });

  // Route::name('user.')->group(function () {

  // });






  Route::group(['middleware' => 'admin.auth'], function () {

    // Route::get('/', [AdminController::class,'index'])->name('admin');
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile/{id}', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/update_profile', [AdminController::class, 'updateProfile'])->name('admin.update_profile');
    Route::get('/changepassword', [AdminController::class, 'changePassword'])->name('admin.changepassword');
    Route::post('/updatepassword', [AdminController::class, 'updatePassword'])->name('admin.updatepassword');
    Route::get('/logout', [AccountController::class, 'logout'])->name('admin.logout');


    // Notifications
    Route::get('ideas/ajax_get_notifications', [AdminNotificationController::class, 'ajax_get_notifications'])->name('ideas.ajax_get_notifications_backend');
    Route::get('ideas/ajax_update_notification/{notification_id}/{idea_id}', [AdminNotificationController::class, 'ajax_update_notification'])->name('ideas.ajax_update_notification_backend');





    Route::get('/permissions', [PermissionController::class, 'index'])->name('admin.permissions');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('admin.permissions.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('admin.permissions.store');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
    Route::post('/permissions/update', [PermissionController::class, 'update'])->name('admin.permissions.update');
    Route::get('/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('admin.permissions.delete');
    Route::resource('admin/permission', 'PermissionController');
    Route::get('/backendmenu', [BackendmenuController::class, 'index'])->name('admin.backendmenu');
    Route::get('/backendmenu/create', [BackendmenuController::class, 'create'])->name('admin.backendmenu.create');
    Route::post('/backendmenu/store', [BackendmenuController::class, 'store'])->name('admin.backendmenu.store');
    Route::get('/backendmenu/edit/{id}', [BackendmenuController::class, 'edit'])->name('admin.backendmenu.edit');
    Route::post('/backendmenu/update', [BackendmenuController::class, 'update'])->name('admin.backendmenu.update');
    Route::get('/backendmenu/delete/{id}', [BackendmenuController::class, 'destroy'])->name('admin.backendmenu.delete');
    Route::get('/backendmenu/view/{id}', [BackendmenuController::class, 'show'])->name('admin.backendmenu.view');
    Route::resource('admin/backendmenu', 'BackendmenuController');
    Route::get('/backendsubmenu', [BackendsubmenuController::class, 'index'])->name('admin.backendsubmenu');
    Route::get('/backendsubmenu/menu/{menu_id}', [BackendsubmenuController::class, 'menu'])->name('admin.backendsubmenu.menu');
    Route::get('/backendsubmenu/create/{menu_id?}', [BackendsubmenuController::class, 'create'])->name('admin.backendsubmenu.create');
    Route::post('/backendsubmenu/store', [BackendsubmenuController::class, 'store'])->name('admin.backendsubmenu.store');
    Route::get('/backendsubmenu/edit/{menu_id?}/{id}', [BackendsubmenuController::class, 'edit'])->name('admin.backendsubmenu.edit');
    Route::post('/backendsubmenu/update', [BackendsubmenuController::class, 'update'])->name('admin.backendsubmenu.update');
    Route::get('/backendsubmenu/delete/{id}', [BackendsubmenuController::class, 'destroy'])->name('admin.backendsubmenu.delete');
    Route::get('/backendsubmenu/view/{id}', [BackendsubmenuController::class, 'show'])->name('admin.backendsubmenu.view');
    Route::resource('admin/backendsubmenu', 'BackendsubmenuController');

    Route::get('/adminusers', [AdminusersController::class, 'index'])->name('admin.adminusers');
    Route::get('/adminusers/create', [AdminusersController::class, 'create'])->name('admin.adminusers.create');
    Route::post('/adminusers/store', [AdminusersController::class, 'store'])->name('admin.adminusers.store');
    Route::get('/adminusers/edit/{id}', [AdminusersController::class, 'edit'])->name('admin.adminusers.edit');
    Route::post('/adminusers/update', [AdminusersController::class, 'update'])->name('admin.adminusers.update');
    Route::get('/adminusers/delete/{id}', [AdminusersController::class, 'destroy'])->name('admin.adminusers.delete');
    Route::get('/adminusers/view/{id}', [AdminusersController::class, 'show'])->name('admin.adminusers.view');
    Route::get('/adminusers/editstatus/{id}', [AdminusersController::class, 'editstatus'])->name('admin.adminusers.editstatus');
    Route::post('/adminusers/updatestatus', [AdminusersController::class, 'updatestatus'])->name('admin.adminusers.updatestatus');
    Route::resource('admin/adminusers', 'AdminusersController');

    //admin.roles
    Route::get('/roles', [RolesController::class, 'index'])->name('admin.roles');
    Route::get('/rolesexternal', [RolesexternalController::class, 'index'])->name('admin.rolesexternal');
    Route::get('/ideaManagement', [IC::class, 'ideaManagement'])->name('admin.ideaManagement');
    Route::post('/storeFeedback', [IC::class, 'storeFeedback'])->name('admin.storeFeedback');
    Route::get('/ideaView/{id}', [IC::class, 'view'])->name('admin.ideaView');
    Route::post('/updateIdeaStatus', [IC::class, 'updateIdeaStatus'])->name('admin.updateIdeaStatus');

    // Certificate
    Route::get('/rewards/view/{id}', [RC::class, 'view'])->name('admin.rewards.view');
    Route::get('/approve_certificate/{id}', [IC::class, 'approveCertificate'])->name('admin.approve_certificate');





    Route::get('/roles/create', [RolesController::class, 'create'])->name('admin.roles.create');
    Route::post('/roles/store', [RolesController::class, 'store'])->name('admin.roles.store');
    Route::get('/roles/edit/{id}', [RolesController::class, 'edit'])->name('admin.roles.edit');
    Route::post('/roles/update', [RolesController::class, 'update'])->name('admin.roles.update');
    Route::get('/roles/delete/{id}', [RolesController::class, 'destroy'])->name('admin.roles.delete');
    Route::get('/roles/view/{id}', [RolesController::class, 'show'])->name('admin.roles.view');
    Route::resource('admin/roles', 'RolesController');

    Route::get('/rolesexternal/create', [RolesexternalController::class, 'create'])->name('admin.rolesexternal.create');
    Route::post('/rolesexternal/store', [RolesexternalController::class, 'store'])->name('admin.rolesexternal.store');
    Route::get('/rolesexternal/edit/{id}', [RolesexternalController::class, 'edit'])->name('admin.rolesexternal.edit');
    Route::post('/rolesexternal/update', [RolesexternalController::class, 'update'])->name('admin.rolesexternal.update');
    Route::get('/rolesexternal/delete/{id}', [RolesexternalController::class, 'destroy'])->name('admin.rolesexternal.delete');
    Route::get('/rolesexternal/view/{id}', [RolesexternalController::class, 'show'])->name('admin.rolesexternal.view');
    Route::resource('admin/rolesexternal', 'RolesexternalController');

    // coupons
    Route::get('/coupon', [CouponController::class, 'index'])->name('admin.coupon');
    Route::get('/coupon/create', [CouponController::class, 'create'])->name('admin.coupon.create');
    Route::post('/coupon/store', [CouponController::class, 'store'])->name('admin.coupon.store');
    Route::get('/coupon/edit/{id}', [CouponController::class, 'edit'])->name('admin.coupon.edit');
    Route::post('/coupon/update', [CouponController::class, 'update'])->name('admin.coupon.update');
    Route::get('/coupon/delete/{id}', [CouponController::class, 'destroy'])->name('admin.coupon.delete');
    Route::get('/coupon/view/{id}', [CouponController::class, 'show'])->name('admin.coupon.view');
    Route::resource('admin/coupon', 'CouponController');

    // cms pages
    Route::get('/cmspages', [CmspagesController::class, 'index'])->name('admin.cmspages');
    Route::get('/cmspages/create', [CmspagesController::class, 'create'])->name('admin.cmspages.create');
    Route::post('/cmspages/store', [CmspagesController::class, 'store'])->name('admin.cmspages.store');
    Route::get('/cmspages/edit/{id}', [CmspagesController::class, 'edit'])->name('admin.cmspages.edit');
    Route::post('/cmspages/update', [CmspagesController::class, 'update'])->name('admin.cmspages.update');
    Route::get('/cmspages/delete/{id}', [CmspagesController::class, 'destroy'])->name('admin.cmspages.delete');
    Route::get('/cmspages/view/{id}', [CmspagesController::class, 'show'])->name('admin.cmspages.view');
    Route::resource('admin/cmspages', 'CmspagesController');

    // offers
    Route::get('/schemes', [SchemesController::class, 'index'])->name('admin.schemes');
    Route::get('/schemes/create', [SchemesController::class, 'create'])->name('admin.schemes.create');
    Route::post('/schemes/store', [SchemesController::class, 'store'])->name('admin.schemes.store');
    Route::get('/schemes/edit/{id}', [SchemesController::class, 'edit'])->name('admin.schemes.edit');
    Route::post('/schemes/update', [SchemesController::class, 'update'])->name('admin.schemes.update');
    Route::get('/schemes/delete/{id}', [SchemesController::class, 'destroy'])->name('admin.schemes.delete');
    Route::get('/schemes/view/{id}', [SchemesController::class, 'show'])->name('admin.schemes.view');
    Route::resource('admin/schemes', 'SchemesController');

    // apply offers
    Route::get('/offers', [ApplyoffersController::class, 'index'])->name('admin.offers');
    Route::get('/offers/create', [ApplyoffersController::class, 'create'])->name('admin.offers.create');
    Route::post('/offers/store', [ApplyoffersController::class, 'store'])->name('admin.offers.store');
    Route::get('/offers/edit/{id}', [ApplyoffersController::class, 'edit'])->name('admin.offers.edit');
    Route::post('/offers/update', [ApplyoffersController::class, 'update'])->name('admin.offers.update');
    Route::get('/offers/delete/{id}', [ApplyoffersController::class, 'destroy'])->name('admin.offers.delete');
    Route::get('/offers/view/{id}', [ApplyoffersController::class, 'show'])->name('admin.offers.view');
    Route::resource('admin/offers', 'ApplyoffersController');

    // shipping
    Route::get('/shipping', [ShippingController::class, 'index'])->name('admin.shipping');
    Route::get('/shipping/create', [ShippingController::class, 'create'])->name('admin.shipping.create');
    Route::post('/shipping/store', [ShippingController::class, 'store'])->name('admin.shipping.store');
    Route::get('/shipping/edit/{id}', [ShippingController::class, 'edit'])->name('admin.shipping.edit');
    Route::post('/shipping/update', [ShippingController::class, 'update'])->name('admin.shipping.update');
    Route::get('/shipping/delete/{id}', [ShippingController::class, 'destroy'])->name('admin.shipping.delete');
    Route::get('/shipping/view/{id}', [ShippingController::class, 'show'])->name('admin.shipping.view');
    Route::resource('admin/shipping', 'ShippingController');

    // invoices
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('admin.invoice.create');
    Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('admin.invoice.store');
    Route::get('/invoice/edit/{id}', [InvoiceController::class, 'edit'])->name('admin.invoice.edit');
    Route::post('/invoice/update', [InvoiceController::class, 'update'])->name('admin.invoice.update');
    Route::get('/invoice/delete/{id}', [InvoiceController::class, 'destroy'])->name('admin.invoice.delete');
    Route::get('/invoice/view/{id}', [InvoiceController::class, 'show'])->name('admin.invoice.view');
    Route::resource('admin/invoice', 'InvoiceController');
    //by nikhil (4/18/2024)
    Route::get('/invoice/shipping/{id}',[InvoiceController::class,'shippingDetails'])->name('admin.invoice.shippingdetails');
    Route::post('/invoice/shipping/{id}',[InvoiceController::class,'storeShippingDetails'])->name('admin.invoice.shippingdetails.store');
    Route::get('/invoice/shipping/{id}/{shipping_id}/edit',[InvoiceController::class,'updateStatus'])->name('admin.invoice.shippingdetails.edit');
    Route::post('/invoice/shipping/{id}/{shipping_id}/update',[InvoiceController::class,'updateShippingDetails'])->name('admin.invoice.shippingdetails.update');
    //end by nikhil


    //gst
    Route::get('/gst', [GstController::class, 'index'])->name('admin.gst');
    Route::get('/gst/create', [GstController::class, 'create'])->name('admin.gst.create');
    Route::post('/gst/store', [GstController::class, 'store'])->name('admin.gst.store');
    Route::get('/gst/edit/{id}', [GstController::class, 'edit'])->name('admin.gst.edit');
    Route::post('/gst/update', [GstController::class, 'update'])->name('admin.gst.update');
    Route::get('/gst/delete/{id}', [GstController::class, 'destroy'])->name('admin.gst.delete');
    Route::get('/gst/view/{id}', [GstController::class, 'show'])->name('admin.gst.view');
    Route::resource('admin/gst', 'GstController');

    //warehouse
    Route::get('/warehouse', [WarehouseController::class, 'index'])->name('admin.warehouse');
    Route::get('/warehouse/create', [WarehouseController::class, 'create'])->name('admin.warehouse.create');
    Route::post('/warehouse/store', [WarehouseController::class, 'store'])->name('admin.warehouse.store');
    Route::get('/warehouse/edit/{id}', [WarehouseController::class, 'edit'])->name('admin.warehouse.edit');
    Route::post('/warehouse/update', [WarehouseController::class, 'update'])->name('admin.warehouse.update');
    Route::get('/warehouse/delete/{id}', [WarehouseController::class, 'destroy'])->name('admin.warehouse.delete');
    Route::get('/warehouse/view/{id}', [WarehouseController::class, 'show'])->name('admin.warehouse.view');
    Route::resource('admin/warehouse', 'WarehouseController');

    //products
    Route::get('/productsmanage', [ProductsmanageController::class, 'index'])->name('admin.productsmanage');
    Route::get('/productsmanage/create', [ProductsmanageController::class, 'create'])->name('admin.productsmanage.create');
    Route::post('/productsmanage/store', [ProductsmanageController::class, 'store'])->name('admin.productsmanage.store');
    Route::get('/productsmanage/edit/{id}', [ProductsmanageController::class, 'edit'])->name('admin.productsmanage.edit');
    Route::post('/productsmanage/update', [ProductsmanageController::class, 'update'])->name('admin.productsmanage.update');
    Route::get('/productsmanage/delete/{id}', [ProductsmanageController::class, 'destroy'])->name('admin.productsmanage.delete');
    Route::get('/productsmanage/view/{id}', [ProductsmanageController::class, 'show'])->name('admin.productsmanage.view');
    Route::resource('admin/productsmanage', 'ProductsmanageController');


    // invoices
    Route::get('/reports', [Reports::class, 'index'])->name('admin.reports');
    Route::get('/reports/create', [Reports::class, 'create'])->name('admin.reports.create');
    Route::post('/reports/store', [Reports::class, 'store'])->name('admin.reports.store');
    Route::get('/reports/edit/{id}', [Reports::class, 'edit'])->name('admin.reports.edit');
    Route::post('/reports/update', [Reports::class, 'update'])->name('admin.reports.update');
    Route::get('/reports/delete/{id}', [Reports::class, 'destroy'])->name('admin.reports.delete');
    Route::get('/reports/view/{id}', [Reports::class, 'show'])->name('admin.reports.view');
    Route::resource('admin/reports', 'Reports');






    //admin.internalusers  //September
    //Route::get('/internalusers', [InternalUsersController::class,'index'])->name('admin.internalusers');
    Route::get('/users', [AdminController::class, 'showusers'])->name('admin.users');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/user/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/user/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.delete');
    Route::get('/user/edit/{id}', [AdminController::class, 'edit'])->name('admin.user.edit');
    Route::post('/user/update', [AdminController::class, 'update'])->name('admin.user.update');
    Route::post('/user/statusAndRole', [AdminController::class, 'updateStatusAndRole'])->name('admin.user.statusAndRole');

    // Department 
    Route::get('/departmentManagement', [DepartmentController::class, 'departmentManagement'])->name('admin.departmentManagement');
    Route::get('/addDepartment', [DepartmentController::class, 'addDepartment'])->name('admin.addDepartment');
    Route::post('/storeDepartment', [DepartmentController::class, 'storeDepartment'])->name('admin.storeDepartment');
    Route::get('/editDepartment/{id}', [DepartmentController::class, 'editDepartment'])->name('admin.editDepartment');
    Route::post('/updateDepartment', [DepartmentController::class, 'updateDepartment'])->name('admin.updateDepartment');
    Route::get('/deleteDepartment/{id}', [DepartmentController::class, 'deleteDepartment'])->name('admin.deleteDepartment');

    //External Users 30/10/2022
    Route::get('/externalusers', [ExternalusersController::class, 'index'])->name('admin.externalusers');
    Route::get('/externalusers/create', [ExternalusersController::class, 'create'])->name('admin.externalusers.create');
    Route::post('externalusers/store', [ExternalusersController::class, 'store'])->name('admin.externalusers.store');
    Route::get('/externalusers/edit/{id}', [ExternalusersController::class, 'edit'])->name('admin.externalusers.edit');
    Route::post('/externalusers/update', [ExternalusersController::class, 'update'])->name('admin.externalusers.update');
    Route::post('/externalusers/status', [ExternalusersController::class, 'updatestatus'])->name('admin.externalusers.updatestatus');
    Route::get('/externalusers/delete/{id}', [ExternalusersController::class, 'destroyUser'])->name('admin.externalusers.delete');

    // company master
    Route::get('/company', [CompanyController::class, 'index'])->name('admin.company');
    Route::get('/company/create', [CompanyController::class, 'create'])->name('admin.company.create');
    Route::post('/company/store', [CompanyController::class, 'store'])->name('admin.company.store');
    Route::get('/company/edit/{id}', [CompanyController::class, 'edit'])->name('admin.company.edit');
    Route::post('/company/update', [CompanyController::class, 'update'])->name('admin.company.update');
    Route::get('/company/delete/{id}', [CompanyController::class, 'destroy'])->name('admin.company.delete');


    // location master
    Route::get('/location', [LocationController::class, 'index'])->name('admin.location');
    Route::get('/location/create', [LocationController::class, 'create'])->name('admin.location.create');
    Route::post('/location/store', [LocationController::class, 'store'])->name('admin.location.store');
    Route::get('/location/edit/{id}', [LocationController::class, 'edit'])->name('admin.location.edit');
    Route::post('/location/update', [LocationController::class, 'update'])->name('admin.location.update');
    Route::get('/location/delete/{id}', [LocationController::class, 'destroy'])->name('admin.location.delete');

    // designation master
    Route::get('/designation', [DesignationController::class, 'index'])->name('admin.designation');
    Route::get('/designation/create', [DesignationController::class, 'create'])->name('admin.designation.create');
    Route::post('/designation/store', [DesignationController::class, 'store'])->name('admin.designation.store');
    Route::get('/designation/edit/{id}', [DesignationController::class, 'edit'])->name('admin.designation.edit');
    Route::post('/designation/update', [DesignationController::class, 'update'])->name('admin.designation.update');
    Route::get('/designation/delete/{id}', [DesignationController::class, 'destroy'])->name('admin.designation.delete');

    // Category master
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('/category/update', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

    //carousels usama-31-08-2023
    // coupons
    Route::get('/productcarousel', [ProductCarouselController::class, 'index'])->name('admin.productcarousel');
    Route::get('/productcarousel/create', [ProductCarouselController::class, 'create'])->name('admin.productcarousel.create');
    Route::post('/productcarousel/store', [ProductCarouselController::class, 'store'])->name('admin.productcarousel.store');
    Route::get('/productcarousel/edit/{id}', [ProductCarouselController::class, 'edit'])->name('admin.productcarousel.edit');
    Route::post('/productcarousel/update', [ProductCarouselController::class, 'update'])->name('admin.productcarousel.update');
    Route::get('/productcarousel/delete/{id}', [ProductCarouselController::class, 'destroy'])->name('admin.productcarousel.delete');
    Route::get('/productcarousel/view/{id}', [ProductCarouselController::class, 'show'])->name('admin.productcarousel.view');
    Route::resource('admin/productcarousel', 'ProductCarouselController');

    // coupons
    Route::get('/categorycarouse', [CategoryCarouselController::class, 'index'])->name('admin.categorycarouse');
    Route::get('/categorycarouse/create', [CategoryCarouselController::class, 'create'])->name('admin.categorycarouse.create');
    Route::post('/categorycarouse/store', [CategoryCarouselController::class, 'store'])->name('admin.categorycarouse.store');
    Route::get('/categorycarouse/edit/{id}', [CategoryCarouselController::class, 'edit'])->name('admin.categorycarouse.edit');
    Route::post('/categorycarouse/update', [CategoryCarouselController::class, 'update'])->name('admin.categorycarouse.update');
    Route::get('/categorycarouse/delete/{id}', [CategoryCarouselController::class, 'destroy'])->name('admin.categorycarouse.delete');
    Route::get('/categorycarouse/view/{id}', [CategoryCarouselController::class, 'show'])->name('admin.categorycarouse.view');
    Route::resource('admin/categorycarouse', 'CategoryCarouselController');


    // Email master
    Route::get('/email_config', [EmailConfigController::class, 'index'])->name('admin.email_config');
    Route::post('/email_config/update', [EmailConfigController::class, 'update'])->name('admin.email_config.update');

    // Email master
    Route::get('/activity_log', [ActivityLogController::class, 'index'])->name('admin.activity_log');

    // Chart JS
    Route::get('/chart', [ChartJSController::class, 'index']);
  });
}); //End if Admin Group
