@extends('backend.layouts.app')
@section('title')
Create New Scheme
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
              <li class="breadcrumb-item"><a href="{{ route('admin.schemes')}}">Offers</a></li>
              <li class="breadcrumb-item active" aria-current="page">add</li>
          </ol>
      </nav>
      <div class="d-flex justify-content-between w-100 flex-wrap">
          <div class="mb-3 mb-lg-0">
              <h1 class="h4">Add Offer</h1>
          </div>
          <div>
              <a href="{{ route('admin.schemes') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
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

              <form method="POST" action="{{ route('admin.schemes.store') }}" class="form">
                {{ csrf_field() }}
           <div class="row">
            <div class="form-group col-lg-12 {{ $errors->has('scheme_title') ? 'has-error' : ''}}">
                {!! Form::label('scheme_title', 'Scheme Title: ', ['class' => ' control-label']) !!}
                <div class="">
                    {!! Form::text('scheme_title', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('scheme_title', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
                <div class="form-group col-lg-6 col-md-6 {{ $errors->has('min_product_qty') ? 'has-error' : ''}}">
                {!! Form::label('min_product_qty', 'Mininum Product Qty: ', ['class' => ' control-label']) !!}
                <div class="">
                    {!! Form::number('min_product_qty', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('min_product_qty', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group col-lg-6 col-md-6 {{ $errors->has('free_product_qty') ? 'has-error' : ''}}">
                {!! Form::label('free_product_qty', 'Free Product Qty: ') !!}
                <div class="">
                    {!! Form::number('free_product_qty', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('free_product_qty', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group col-lg-2 col-md-2 col-3 col-sm-2 mt-2">
                {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
            </div>
    </div>
    {!! Form::close() !!}

@endsection
