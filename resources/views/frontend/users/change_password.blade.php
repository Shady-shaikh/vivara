@extends('frontend.layouts.app')
@section('title','Change Password')
@section('content')


<!-- login -->
<section class="container-fluidcustom top-padding login-page">
  <div class="login-box">
    <div class="row py-5">
      <div class="col-md-12">
        <div class="container container-custom">
          <div class="row">
            <div class="col-md-12">
              <div class="border-login py-4">
                <div class="login-inner-head pl-4">
                  <h6>Change Password</h6>
                </div>
                <div class="using-box py-4">
                  @include('frontend.includes.errors')
                  <div class="row ">
                    <div class="col-md-12 col-sm-12 col-12">
                      <div class="login">
                        <form class="login-form form-field" action="{{ url('storeforgotpassword') }}" method="post"
                          enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input name="user_id" type="hidden" value="{{$userdata->id}}">
                          <input name="email" type="hidden" value="{{$userdata->email}}">

                          <div class="form-group col-md-12 pb-4">
                            <div class="input-wrapper">
                              <input class="password form-control form-control-h show_password" name="password"
                                type="password" required>
                              <label for="user">Enter Old Password <span class="star">*</span></label>
                              <div class="hide-show">
                                <span>Show</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-12">
                            <div class="input-wrapper">
                              <input class="password form-control form-control-h  show_password" name="new-password"
                                type="password" required>
                              <label for="user">Enter New Password <span class="star">*</span></label>
                              <div class="hide-show">
                                <span>Show</span>
                              </div>
                              <div class="terms-conditions-size">
                                <p><i class="fa fa-info" aria-hidden="true"></i> Password must be at least 8 characters
                                  alphanumerical.</p>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-12 pb-1">
                            <div class="input-wrapper">
                              <input class="password form-control form-control-h show_confirm_password"
                                name="new-password_confirmation" type="password" required>
                              <label for="user">Confirm New Password <span class="star">*</span></label>
                              <div class="hide-showRe">
                                <span>Show</span>
                              </div>
                            </div>
                          </div>

                          <div class="form-group mb-0 col-md-12 terms-conditions-size pt-0">
                            <button type="submit" class="cobntinue-btn btn-block  text-center " href="#">Save New
                              Password</button>
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





<br>
@endsection