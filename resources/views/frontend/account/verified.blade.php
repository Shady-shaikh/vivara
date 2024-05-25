@extends('backend.layouts.fullempty')
@section('title', 'Forgot Password')
@section('content')

<style>
    body{
        display: flex;
        align-items: center;
        justify-items: center;
        justify-content: center;
    }.login-box{ background: #fff;}
    h2{font-size: 20px}
    .btn-block{
    text-transform: uppercase;
    outline: 0;
    background: #004761;
    border: 0;
    padding: 10px;
    color: #ffffff !important; display: inline;
    font-size: 12px;}
    .img-fluid{width: 120px}

</style>




<!-- login -->
<section class="container-fluidcustom top-padding login-page common-space ">
    <img src="{{asset('/public/frontend-assets/images/logo.png')}}"  class="img-fluid mb-4 text-center" alt="">
    <div class="login-box">
        <div class="row py-5">
            <div class="col-md-12">
                <div class="container container-custom">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border-login">
                                <div class="login-inner-head">
                                    
    
                                    <h2 class="mb-4">Your Email has been verified successfully</h2>
    <a class="success-btn btn-block " href="{{ route('user.login') }}">Go to login page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection
