 <?php $__env->startSection('title', 'Payment'); ?> <?php $__env->startSection('content'); ?> <style>
  /* PRELOADER CSS */
  .page-load {
      width: 100%;
      height: 100vh;
      position: absolute;
      background: black;
      z-index: 1000;
  }

  .page-load .txt {
      color: #666;
      text-align: center;
      top: 40%;
      position: relative;
      text-transform: uppercase;
      letter-spacing: 0.3rem;
      font-weight: bold;
      line-height: 1.5;
  }

  /* SPINNER ANIMATION */
  .spinner {
      position: relative;
      top: 35%;
      width: 80px;
      height: 80px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 100%;
      -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
      animation: sk-scaleout 1.0s infinite ease-in-out;
  }

  @-webkit-keyframes sk-scaleout {
      0% {
          -webkit-transform: scale(0)
      }

      100% {
          -webkit-transform: scale(1.0);
          opacity: 0;
      }
  }

  @keyframes  sk-scaleout {
      0% {
          -webkit-transform: scale(0);
          transform: scale(0);
      }

      100% {
          -webkit-transform: scale(1.0);
          transform: scale(1.0);
          opacity: 0;
      }
  }
</style> <?php

use yii\helpers\Html;
use yii\helpers\Url;

use App\Models\backend\Shipping;
// Merchant key here as provided by Payu
$MERCHANT_KEY = "rjQUPktU"; //"gtKFFx";//fGt7UPa8//AgchnRvO//gtKFFx
// $MERCHANT_KEY = "ngCoxRML"; //"ngCoxRML";
// updated key -> rjQUPktU -osama


// Merchant Salt as provided by Payu
// $SALT = "RKWaQPGtyg"; //"RKWaQPGtyg";
$SALT = "e5iIg1jwi8"; //"eCwWELxi";//OSCmGKDVTT//OXmajpslMQ//eCwWELxi
// updated SALT -> e5iIg1jwi8 -osama

// End point - change to https://secure.payu.in for LIVE mode
// $PAYU_BASE_URL = "https://secure.payu.in";
// $PAYU_BASE_URL = "https://sandboxsecure.payu.in";
$PAYU_BASE_URL = "https://test.payu.in";
$action = '';

$posted = array();

// echo $cart_amount;
// die;
if (!empty($_POST)) {
//print_r($_POST);
foreach ($_POST as $key => $value) {
  $posted[$key] = $value;
}
}
// echo "<pre>";print_r($posted);die;
  $shipping_charge = $posted['udf5'];
  if(!empty($posted['shipping_charges']) && empty($shipping_charge)){
    $shipping_data = Shipping::where('shipping_method_id', $posted['shipping_charges'])->first();
    $shipping_charge = $shipping_data->shipping_method_cost;
  }


$formError = 0;
// echo $posted['txnid'];die;
if (empty($posted['txnid'])) {
// Generate random transaction id
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
$txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

if (empty($posted['hash']) && sizeof($posted) > 0) {
if (
  empty($posted['key'])
  || empty($posted['txnid'])
  || empty($posted['amount'])
  || empty($posted['firstname'])
  || empty($posted['email'])
  || empty($posted['phone'])
  || empty($posted['productinfo'])
  || empty($posted['surl'])
  || empty($posted['furl'])
  || empty($posted['service_provider'])
) {
  // echo "error";die;
  $formError = 1;
} else {
  //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
  $hashVarsSeq = explode('|', $hashSequence);
  $hash_string = '';
//   echo "<pre>";print_r($hashSequence);
//   echo "<pre>";print_r($hashVarsSeq);
//   die;
  foreach ($hashVarsSeq as $hash_var) {
    // echo $hash_var;
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
  }

  $hash_string .= $SALT;

//   echo "<pre>";print_r($hashSequence)."<br>";
//   echo "<pre>";print_r($hash_string)."<br>";
//   echo "<pre>";print_r($hashVarsSeq);die;
  $hash = strtolower(hash('sha512', $hash_string));
//   echo $hash;die;
  // echo "<pre>";print_r($hash);die;
  $action = $PAYU_BASE_URL . '/_payment';
}
} elseif (!empty($posted['hash'])) {

$hash = $posted['hash'];
// echo $hash;die;
$action = $PAYU_BASE_URL . '/_payment';

}
// remove this line when using gateway
$action = route('products.payment_success');
// dd($hash);

?> <?php
// echo $action;die; 
?> <div class="page-load">
  <div class="spinner">
  </div>
</div>

<form action="<?php echo $action; ?>" method="post" name="payuForm" class="d-none">
  <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
  <input type="text" name="hash" value="<?php echo $hash ?>" />
  <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
  <table>
      <tr>
          <td><b>Mandatory Parameters</b></td>
      </tr>
      <tr>
          <td>Amount: </td>
          <td><input name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" /></td>
          <td>First Name: </td>
          <td><input name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" /></td>
      </tr>
      <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" /></td>
          <td>Phone: </td>
          <td><input name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" /></td>
      </tr>
      <tr>
          <td>Product Info: </td>
          <td colspan="3"><textarea name="productinfo"><?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?></textarea></td>
      </tr>
      <tr>
          <td>Success URI: </td>
          <td colspan="3"><input name="surl" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" /></td>
      </tr>
      <tr>
          <td>Failure URI: </td>
          <td colspan="3"><input name="furl" value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" /></td>
      </tr>
      <tr>
          <!-- payu_paisa -->
          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
      </tr>
      
      <tr>
          <td>UDF1: </td>
          <td><input name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" /></td>
          <td>UDF2: </td>
          <td><input name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" /></td>
      </tr>
      <tr>
          <td>UDF3: </td>
          <td><input name="udf3" value="<?php echo (empty($posted['udf3'])) ? 0 : $posted['udf3']; ?>" /></td>
          <td>UDF4: </td>
          <td><input name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" /></td>
      </tr>
      <tr>
          <td>UDF5: </td>
          <td><input name="udf5" value="<?php echo (empty($shipping_charge)) ? 0 : $shipping_charge; ?>" /></td>
          <td>PG: </td>
          <td><input name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" /></td>
      </tr>
      <tr>
      <tr> <?php if (!$hash) { ?> <td colspan="4"><input type="submit" value="Submit" /></td> <?php } ?> </tr>
  </table>
</form>
<script>
  var hash = '<?php echo $hash ?>';
   console.log(hash);
  window.onload = function() {
      if (hash == '') {
          return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
      // alert('Please wait while we are processing your request...');
  }
</script>
<script>
  $(window).on('load', function() {
      setTimeout(() => {
          $(".page-load").hide();
      }, 3000);
  });
</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.fullempty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\vivara\resources\views/frontend/products/payment/payment.blade.php ENDPATH**/ ?>