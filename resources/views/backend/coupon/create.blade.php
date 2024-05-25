@extends('backend.layouts.app')
@section('title', 'Create Coupon')

@section('content')
@php

@endphp

<div class="content-header row">
  <div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.coupon')}}">Coupons</a></li>
            <li class="breadcrumb-item active" aria-current="page">add</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Add Coupon</h1>
        </div>
        <div>
            <a href="{{ route('admin.coupon') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                Back
            </a>
        </div>
    </div>
</div>
</div>


        <section id="multiple-column-form">
          <div class="row match-height">
            <div class="col-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
                    @include('backend.includes.errors')
                    <form method="POST" action="{{ route('admin.coupon.store') }}" class="form">
                      {{ csrf_field() }}
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('coupon_title', 'Coupon Name *') }}
                              {{ Form::text('coupon_title', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Name', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('coupon_code', 'Coupon Code *') }}
                              {{ Form::text('coupon_code', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Code', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('start_date', 'Start Date *') }}
                              {{ Form::date('start_date', null, ['class' => 'form-control pickadate', 'placeholder' => 'Enter Start Date', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('end_date', 'End Date *') }}
                              {{ Form::date('end_date', null, ['class' => 'form-control pickadate', 'placeholder' => 'Enter End Date', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('coupon_type', 'Type *') }}
                              {{ Form::select('coupon_type', ['flat'=>'Flat','percentage'=>'Percentage'], null, ['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('value', 'Coupon Value *') }}
                              {{ Form::text('value', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Value', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('coupon_purchase_limit', 'Coupon Purchase Limit *') }}
                              {{ Form::text('coupon_purchase_limit', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Purchase Limit', 'required' => true]) }}
                            </div>
                          </div>
                          {{-- <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('coupon_usage_limit', 'Coupon Usage Limit *') }}
                              {{ Form::text('coupon_usage_limit', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Usage Limit', 'required' => true]) }}
                            </div>
                          </div> --}}
                          {{-- <div class="col-lg-12 col-md-12">
                            {{ Form::label('copoun_desc', 'Coupon Description *') }}
                            <fieldset class="form-group">
                                {{ Form::textarea('copoun_desc', null, ['class' => 'form-control char-textarea', 'placeholder' => 'Enter Coupon Description', 'required' => true, 'rows'=>3]) }}
                            </fieldset>
                          </div> --}}
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('status', 'Status *') }}
                              {{ Form::select('status', ['0'=>'Active','1'=>'Disable'], null, ['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          {{-- <div class="col-md-6 col-12 mt-2">
                            <!-- {{ Form::label('permissions', 'Offer Once per user') }} -->
                            <ul class="list-unstyled mb-0">
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="checkbox checkbox-primary">
                                    {{ Form::checkbox('coupon_once_per_user', 1 ,null, ['id'=>'coupon_once_per_user']) }}
                                    {{ Form::label('coupon_once_per_user', 'Offer Once per User on 1st purchase') }}
                                  </div>
                                </fieldset>
                              </li>
                            </ul>
                          </div> --}}
                          <div class="col-12 d-flex justify-content-start mt-2">
                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
@endsection