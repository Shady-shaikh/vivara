@extends('backend.layouts.app')
@section('title')
Create new Gst
@stop

@section('content')

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
              <li class="breadcrumb-item"><a href="{{ route('admin.shipping')}}">Shipping</a></li>
              <li class="breadcrumb-item active" aria-current="page">add</li>
          </ol>
      </nav>
      <div class="d-flex justify-content-between w-100 flex-wrap">
          <div class="mb-3 mb-lg-0">
              <h1 class="h4">Add Shipping</h1>
          </div>
          <div>
              <a href="{{ route('admin.shipping') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
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

              <form method="POST" action="{{ route('admin.shipping.store') }}" class="form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-lg-6 col-md-6">
                    {{ Form::label('shipping_method_name', 'Shipping Method Name') }}
                    {{ Form::text('shipping_method_name', Request('shipping_method_name'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group col-lg-6 col-md-6">
                    {{ Form::label('shipping_method_code', 'Shipping Method Code') }}
                    {{ Form::text('shipping_method_code', Request('shipping_method_code'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group col-lg-6 col-md-6">
                    {{ Form::label('shipping_method_cost', 'Shipping Method Cost') }}
                    {{ Form::text('shipping_method_cost', Request('shipping_method_cost'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group col-lg-6 col-md-6">
                    {{ Form::label('shipping_method_status', 'Active Shipping: ') }}
                    {{ Form::select('shipping_method_status', ['1'=>'Yes','0'=>'No'],null,['class'=>'form-control']) }}
                </div>

         <div class="form-group col-lg-2 col-md-2 col-3 col-sm-2 mt-2">
        <div class="">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    </div>
    {!! Form::close() !!}

@endsection
