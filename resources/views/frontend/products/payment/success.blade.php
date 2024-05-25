@extends('frontend.layouts.app')
@section('title', 'Success')


@section('content')


    <div class="container-fluid px-lg-4 py-4">
        <div class="card border-0 shadow">
            <div class="card-body p-4">
                <div class="col s2">
                </div>
                <div class="col s10">
                    <?php
        // echo "<pre>";print_r($_POST);
        $status = $_POST["status"]??'success';
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];
        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $id = $_POST["udf1"];
        $course_id = $_POST["udf2"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];
        $salt = "e5iIg1jwi8"; //"RKWaQPGtyg";

        if (isset($_POST["additionalCharges"])) {
          $additionalCharges = $_POST["additionalCharges"];
          $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
          $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);
        $url_path = route('products.index');
        //  echo $posted_hash;die;
        //  if ($hash != $posted_hash) {
          $text = '
          <div class="row align-items-center g-4">
     
                  <div class="col-md-10">
                          <h2 class="sub-heading  mb-2 text-success">Thank You. Your order status is Complete</h2>
                          <h3>Your transaction id for this transaction is ' . $txnid . ' .</h3>
                          <h4>We have received a payment of Rs. ' . $amount . '</h4>
                          <p class="mt-4"><a href="'.$url_path.'" class="btn btn-success btn-sm waves-effect waves-light orange lighten-1">Go To Items</a></p>
                  </div>
                  <div class="col-lg-12">
                    
                  </div>
          </div>';


        if ($status == 'failure') {
          echo "Invalid Transaction. Please try again";
        } else {
          echo $text;
          // echo "<h1>Thank You. Your order status is Complete</h1>";
          // echo "<h5>Your Transaction ID for this transaction is " . $txnid . ".</h5>";
          // echo "<p>We have received a payment of Rs. " . $amount . "</p>";
        }
        ?>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
