@extends('backend.layouts.app')
@section('title')
Edit Offer On Item
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
              <li class="breadcrumb-item"><a href="{{ route('admin.offers')}}">Apply Offers</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
      </nav>
      <div class="d-flex justify-content-between w-100 flex-wrap">
          <div class="mb-3 mb-lg-0">
              <h1 class="h4">Edit Offer On Item</h1>
          </div>
          <div>
              <a href="{{ route('admin.offers') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
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

              <form method="POST" action="{{ route('admin.offers.update',['id'=>$model->item_id]) }}" class="form">
                {{ csrf_field() }}
           <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                  {{ Form::label('item_id', 'Item : ') }}
                  {{ Form::select('item_id',$items,$model->item_id , ['class'=>'form-control','placeholder'=>'Select Item']) }}
  
              </div>
             </div>

   
             <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('schemes_id', 'Offer : ') }}
                    {{ Form::select('schemes_id',$offers,$model->offer , ['class'=>'form-control','placeholder'=>'Select Offer']) }}
                </div>
            </div>

           </div>
   
            <div class="form-group col-lg-2 col-md-2 col-3 col-sm-2 mt-2">
                {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
            </div>
    </div>
    {!! Form::close() !!}

@endsection
