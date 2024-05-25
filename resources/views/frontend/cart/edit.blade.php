@extends('frontend.layouts.app')
@section('title', 'Edit Cart Item')

@section('content')

<a href="{{url('/cart')}}" class="btn m-3 btn-secondary">Back</a>




<div class="container-fluid">
    <div class="my-3 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Edit Cart Item</h6>
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
          <strong class="d-block text-gray-dark">Quantity</strong>
        </p>
    </div>

    <form action="{{route('cart.update',['id'=>$item->item_id])}}" method="post">
        @csrf
        <input type="number"  name="quantity" value="{{$item->quantity}}" style="width:75px;">
        <input type="hidden"  name="item_id" value="{{$item->item_id}}" >
        <button type="submit" class="btn btn-sm btn-success">Update</button>
    </form>
    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Rate</strong>
        {{$item->get_items[0]['rate']}}
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