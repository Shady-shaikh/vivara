@extends('frontend.layouts.app')
@section('title', 'Failure')


@section('content')


    <div class="container-fluid px-lg-4 py-4">
        <div class="card border-0 shadow">
            <div class="card-body p-4">
                <?php
                
                $firstname = $_POST['firstname'];
                $amount = (float) $_POST['amount'];
                $txnid = $_POST['txnid'];
                $id = $_POST['udf1'];
                $course_id = $_POST['udf2'];
                $pro_flag = true;
                
                $status = $_POST['status'];
                $posted_hash = $_POST['hash'];
                $key = $_POST['key'];
                $productinfo = $_POST['productinfo'];
                $email = $_POST['email'];
                $salt = 'e5iIg1jwi8'; //"RKWaQPGtyg";//eCwWELxi
                
                if (isset($_POST['additionalCharges'])) {
                    $additionalCharges = $_POST['additionalCharges'];
                    $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
                } else {
                    $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
                }
                // echo $retHashSeq;die;
                $hash = hash('sha512', $retHashSeq);
                
                $text =
                    '
                                                        <div class="row align-items-center g-4">
                                                                <div class="col-md-10 ">
                                                                        <h2 class="sub-heading text-danger mb-2 ">Your order status is a ' .
                    $status .
                    '!</h2>
                                                                        <h3>Your transaction id for this transaction is ' .
                    $txnid .
                    ' .</h3>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                        <h4 class="mb-4">You may try making the payment by clicking the link below.</h4>
                                                                </div>
                                                        </div>';
                
                // if (isset($hash) && isset($posted_hash) && $hash != $posted_hash) {
                if ($status != 'failure') {
                    echo 'Invalid Transaction. Please try again';
                } else {
                    echo $text;
                }
                
                ?>
                <!--Please enter your website homepagge URL -->

                <p><a href= {{ route('products.index') }}
                        class="btn btn-warning btn-sm waves-effect waves-light orange lighten-1">Try Again</a></p>

            </div>
        </div>
    </div>

@endsection
