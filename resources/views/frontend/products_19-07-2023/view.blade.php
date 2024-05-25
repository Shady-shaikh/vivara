@extends('frontend.layouts.app')
@section('title', 'Item')

@section('content')

<a href="{{url('/products')}}" class="btn m-3 btn-secondary">Back</a>

<h1 style="text-align: center;">Item</h1>


<div class="container-fluid">
    <div class="my-3 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">View Item</h6>
    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Item Name</strong>
        {{$item->name}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Product Type</strong>
        {{$item->product_type}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Rate</strong>
        {{$item->rate}}
      </p>
    </div>
    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Usage Unit</strong>
        {{$item->unit}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
        <p class="pb-3 mb-0 small lh-sm border-bottom">
          <strong class="d-block text-gray-dark">Description</strong>
          {{$item->description}}
        </p>
    </div>




  </div>
</div>

@endsection