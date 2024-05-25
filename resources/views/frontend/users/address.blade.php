@php
    use App\Models\frontend\Department;
    $user_id = Auth()->user()->user_id;
@endphp
@extends('frontend.layouts.app')
@section('title', 'User Dashboard | Edit Address Details')

@section('content')



    <section class="section profile">
        <div class="container-fluid">
            <div class="row px-lg-5 gap-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="navigation">
                            <div class="back mb-5">
                                <a class="d-flex" href="{{ route('user.dashboard') }}">
                                    <i class="fas fa-chevron-left mini-heading"></i>
                                    <h5 class="mini-heading">Go Back</h5>
                                </a>
                            </div>


                            <div class="parameters">

                                <ul class="">
                                    <li class="mb-2"><a class="dropdown-item"
                                            href="{{ route('user.profile', ['id' => $user_id]) }}"> Edit Profile</a>
                                    </li>
                                    <li class="mb-2"><a class="dropdown-item"
                                            href="{{ route('user.address', ['id' => $user_id]) }}"> Address</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="{{ route('myorders.orders') }}">
                                            Order History</a></li>
                                    <li class="mb-2"><a class="dropdown-item" href="{{ route('payment.index') }}">
                                            Payment History</a></li>
                                    <li class="mb-2"><a class="dropdown-item"
                                            href="{{ route('user.changePassword') }}">Change Password</a></li>
                                    <li class="mb-2"><a class="dropdown-item text-danger"
                                            href="{{ route('user.logout') }}">Logout</a></li>
                                </ul>


                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-8">
                    <div class="card">


                        <div class="profile-details">
                            <div class="name mb-5">
                                <h1 class="heading">Address Details</h1>
                                {{-- <h6 class="mini-subheading" style="margin-left: 10px;">Lorem ipsum dolor sit amet.</h6> --}}
                            </div>

                            <div class="profile-photo mb-5">
                                <h6 class="mini-heading mb-4" style="font-size: 18px;">Update Address Details</h6>

                            </div>

                            <div class="details-form">
                                @include('backend.includes.errors')
                                {{-- {{ Form::open(['url' => 'admin/user/update']) }} --}}
                                {!! Form::model($userdata, [
                                    'method' => 'POST',
                                    'url' => ['/user/updateAddress'],
                                    'class' => 'form',
                                ]) !!}
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $id }}">

                                <div class="ml-3 mt-2 mb-2 text-right">
                                    {{ Form::checkbox('filladdress', null, $bill_add->filladdress ?? 0, ['id' => 'filladdress']) }}
                                    <span><b>Copy Bill Address To Ship Address</b></span>
                                </div>
                                <hr>
                                <div class="col-sm-12">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class=" col-12">

                                                <h3>Billing Information</h3>
                                                <hr>

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        {{ Form::label('attention', 'Attention ') }}
                                                        {{ Form::text('attention', $bill_add->attention ?? '', ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::label('country', 'Country') }}
                                                        {{ Form::select('country', [], $bill_add->country ?? '', ['class' => 'form-control country_dropdown', 'placeholder' => 'Select Country', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{ Form::label('street1', 'Address ') }}
                                                        {{ Form::textarea('street1', $bill_add->street1 ?? '', ['class' => 'form-control', 'placeholder' => 'Street 1', 'style' => 'height:5rem;', 'required' => true]) }}
                                                        {{ Form::textarea('street2', $bill_add->street2 ?? '', ['class' => 'form-control mt-2', 'id' => 'street2', 'placeholder' => 'Street 2', 'style' => 'height:5rem;', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{ Form::label('city', 'City ') }}
                                                        {{ Form::text('city', $bill_add->city ?? '', ['class' => 'form-control', 'placeholder' => 'City', 'required' => true]) }}
                                                    </div>

                                                    <div class="col-12">
                                                        {{ Form::label('state', 'State') }}
                                                        {{ Form::select('state', [], $bill_add->state ?? '', ['class' => 'form-control state_dropdown', 'placeholder' => 'State', 'required' => true]) }}
                                                    </div>

                                                    <div class="col-md-6">
                                                        {{ Form::label('zip_code', 'Zip Code ') }}
                                                        {{ Form::text('zip_code', $bill_add->zip_code ?? '', ['class' => 'form-control', 'onkeypress' => 'return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));', 'placeholder' => 'Zip Code', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::label('phone', 'Phone ') }}
                                                        {{ Form::text('phone', $bill_add->phone ?? '', ['class' => 'form-control', 'onkeypress' => 'return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));', 'placeholder' => 'Phone', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::label('fax', 'Fax') }}
                                                        {{ Form::text('fax', $bill_add->fax ?? '', ['class' => 'form-control', 'onkeypress' => 'return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));', 'placeholder' => 'Fax']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class=" col-12">
                                                <h3>Shipping Information</h3>
                                                <hr>


                                                <div class="row">

                                                    <div class="col-md-6">
                                                        {{ Form::label('attention', 'Attention ') }}
                                                        {{ Form::text('attention_ship', $ship_add->attention ?? '', ['class' => 'form-control', 'id' => 'attention_c', 'placeholder' => 'Enter Name']) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::label('country', 'Country') }}
                                                        {{ Form::select('country_ship', [], $ship_add->country ?? '', ['class' => 'form-control country_dropdown', 'id' => 'country_c', 'placeholder' => 'Select Country', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{ Form::label('street1', 'Address ') }}
                                                        {{ Form::textarea('street1_ship', $ship_add->street1 ?? '', ['class' => 'form-control', 'id' => 'street1_c', 'placeholder' => 'Street 1', 'style' => 'height:5rem;', 'required' => true]) }}
                                                        {{ Form::textarea('street2_ship', $ship_add->street2 ?? '', ['class' => 'form-control mt-2', 'id' => 'street2_c', 'placeholder' => 'Street 2', 'style' => 'height:5rem;', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{ Form::label('city', 'City ') }}
                                                        {{ Form::text('city_ship', $ship_add->city ?? '', ['class' => 'form-control', 'id' => 'city_c', 'placeholder' => 'City', 'required' => true]) }}
                                                    </div>

                                                    <div class="col-12">
                                                        {{ Form::label('state', 'State') }}
                                                        {{ Form::select('state_ship', [], $ship_add->state ?? '', ['class' => 'form-control state_dropdown', 'id' => 'state_c', 'placeholder' => 'State', 'required' => true]) }}
                                                    </div>

                                                    <div class="col-md-6">
                                                        {{ Form::label('zip_code', 'Zip Code ') }}
                                                        {{ Form::text('zip_code_ship', $ship_add->zip_code ?? '', ['class' => 'form-control', 'id' => 'zip_code_c', 'onkeypress' => 'return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));', 'placeholder' => 'Zip Code', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::label('phone', 'Phone ') }}
                                                        {{ Form::text('phone_ship', $ship_add->phone ?? '', ['class' => 'form-control', 'id' => 'phone_c', 'onkeypress' => 'return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));', 'placeholder' => 'Phone', 'required' => true]) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::label('fax', 'Fax') }}
                                                        {{ Form::text('fax_ship', $ship_add->fax ?? '', ['class' => 'form-control', 'id' => 'fax_c', 'onkeypress' => 'return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));', 'placeholder' => 'Fax']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center py-4">
                                    <div class="update">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="reset" class="btn btn-primary">Reset</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
