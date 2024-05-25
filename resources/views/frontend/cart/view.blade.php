@extends('frontend.layouts.app')
@section('title', 'Item')

@section('content')

<a href="{{url('/cart')}}" class="btn m-3 btn-secondary">Back</a>




<div class="container-fluid">
    <div class="my-3 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">View Item</h6>
    
    <div class="d-flex text-body-secondary pt-3">
      @if(!empty($item->get_items[0]['item_image']))
      <a href="{{ asset('/public/frontend-assets/images/').'/'.$item->get_items[0]['item_image'] }}" target="_blank">
      <img src="{{ asset('/public/frontend-assets/images/').'/'.$item->get_items[0]['item_image'] }}" alt="No-Image" style='width:100px;'>
      </a>
      @endif
    </div>
    
    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Item Name</strong>
        {{$item->get_items[0]['name']}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Product Type</strong>
        {{$item->get_items[0]['product_type']}}
      </p>
    </div>

    
    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Rate</strong>
        {{$item->get_items[0]['rate']}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Quantity</strong>
        {{$item->quantity}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Usage Unit</strong>
        {{$item->get_items[0]['unit']}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
        <p class="pb-3 mb-0 small lh-sm border-bottom">
          <strong class="d-block text-gray-dark">Description</strong>
          {{$item->get_items[0]['description']}}
        </p>
    </div>




  </div>
</div>

@endsection