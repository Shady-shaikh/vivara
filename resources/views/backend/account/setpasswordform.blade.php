<!-- login end-->
{{-- @endsection --}}


@extends('backend.layouts.fullempty')
@section('title', 'Forgot Password')
@section('content')


<style>
    body {
        display: flex;
        align-items: center;
        justify-items: center;
        justify-content: center;
    }

    .login-box {
        background: #fff;
    }

    .btn-block {
        text-transform: uppercase;
        outline: 0;
        background: #004761;
        border: 0;
        padding: 10px;
        color: #ffffff;
        font-size: 14px;
    }

    .form-control {
        outline: 0;
        background: #eff4f9;
        width: 100%;
        border: 0 !important;
        margin: 0 0 15px;
        padding: 10px;
        border-radius: 0px !important;
        box-sizing: border-box;
        font-size: 14px;
    }
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
                                    <h3>
                                        <h6>Authentication is necessary in order to change password</h6>
                                    </h3>
                                </div>
                                <div class="using-box py-4">

                                    <div class="row ">
                                        <div class="col-md-12 col-sm-12 col-12">
                                            <div class="login">
                                                @include('backend.includes.errors')
                                                <form class="login-form form-field"
                                                    action="{{ route('admin.changeforgotpassword') }}" method="post">
                                                    {{ csrf_field() }}

                                                    <div class="form-group col-md-12">
                                                        <div class="input-wrapper">
                                                            
                                                            <input type="hidden" name="id"
                                                                value="{{$user[0]['admin_user_id']}}">
                                                                
                                                            <label for="user">Enter password<span
                                                                    class="star">*</span></label>
                                                                   
                                                            <input class="password form-control" id="password"
                                                                name="password" type="password"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit" 
                                                                 required>
                                                                
                                                                 <div style="color:red;font-size: 11px;"><b>Note: </b>Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit</div>  
                                                                 <br>
                                                            <label for="user">Enter conform password<span
                                                                    class="star">*</span></label>
                                                            <input class="password form-control"
                                                                id="password_conformation" name="password_conformation"
                                                                type="password" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-12 mb-0 terms-conditions-size1">
                                                        <button type="submit" value="reset-password"
                                                            class="success-btn btn-block  text-center ">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- login end-->






@endsection