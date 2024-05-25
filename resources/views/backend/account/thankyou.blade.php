@extends('backend.layouts.fullempty')
@section('title', 'Forgot Password')
@section('content')

<style>
    body {
        display: flex;
        align-items: center;
        justify-items: center;
        justify-content: center;
    }.login-box{ background: #fff;}
    h1{font-size: 20px}
    .img-fluid{width: 120px}


</style>




<!-- login -->
<section class="container-fluidcustom top-padding login-page common-space">
    <div class="login-box">
        <div class="row py-5">
            <div class="col-md-12">
                <div class="container container-custom">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border-login">
                                <div class="login-inner-head">
                                    
    
                                    <h1>link is send to your email</h1>
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
