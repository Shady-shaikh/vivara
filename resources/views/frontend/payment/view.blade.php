@extends('frontend.layouts.app')
@section('title', 'Payments')

@section('content')

<a href="{{url('/payment')}}" class="btn m-3 btn-secondary">Back</a>




<div class="container-fluid">
    <div class="my-3 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">View Payment</h6>
    <div class="pt-3 border-bottom">
      <p class="pb-3 mb-0 small ">
        <strong class="d-block text-gray-dark">Items Name</strong>
        @foreach($item->get_items() as $row)
            {{$row->name}}
            <br>
      @endforeach
      </p>

    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Transaction ID</strong>
        {{$item->transaction_id}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Amount</strong>
        {{$item->amount}}
      </p>
    </div>
    <div class="d-flex text-body-secondary pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">Date</strong>
        {{$item->payment_date}}
      </p>
    </div>

    <div class="d-flex text-body-secondary pt-3">
        <p class="pb-3 mb-0 small lh-sm border-bottom">
          <strong class="d-block text-gray-dark">status</strong>
          {{$item->status}}
        </p>
    </div>




  </div>
</div>

@endsection