@extends('backend.layouts.app')

@section('title')
    Shipping details
@stop

@section('content')

<a href="{{ route('admin.invoice') }}" class="btn btn-secondary">Back</a>

<section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              @include('backend.includes.errors')

              {!! Form::model($shipping_details, [
                'method' => 'POST',
                //'url' => ['admin/invoice/shipping/{id}/{shipping_id}/update'],
                'url' => route('admin.invoice.shippingdetails.update',['id'=>$invoice->invoice_id,'shipping_id'=>$shipping_details->shipping_id]),
                'class' => 'form'
            ]) !!}
            {{-- {{ csrf_field() }} --}}

                    {{ Form::hidden('invoice_id', $invoice->invoice_id) }}
                    <div class="row">
                    <div class="form-group col-lg-6 col-md-6">
                      {{ Form::label('order_tracking_no', 'Order Tracking no.') }}
                      {{ Form::text('order_tracking_no', $shipping_details->order_tracking_no, ['class' => 'form-control','readonly' => 'readonly']) }}
                   </div>
                   <div class="form-group col-lg-6 col-md-6">
                    {{ Form::label('tracking_url', 'Tracking url') }}
                    {{ Form::text('tracking_url', $shipping_details->tracking_url, ['class' => 'form-control']) }}
                 </div>
                    <div class="form-group col-lg-6 col-md-6">
                        {{ Form::label('shipping_status', 'Shipping Status') }}
                        {{ Form::select('shipping_status', ['pending' => 'Pending','shipped'=>'Shipped','in_transit' => 'In transit','out_for_delivery' => 'Out For Delivery','cancelled' => 'Cancelled','delivered' => 'Delivered'], $shipping_details->shipping_status, ['class' => 'form-control', 'id' => 'shippingtype', 'placeholder' => 'Select Shipping Status', 'required' => true]) }}
                </div>
                <div class="form-group col-lg-6 col-md-6">
                    {{ Form::label('remark', 'Remark') }}
                    {{ Form::text('remark', $shipping_details->remark, ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-lg-6 col-md-6">
                    {{ Form::label('expected_delivery_date', 'Expected Delivery Date') }}
                    {{ Form::date('expected_delivery_date', $shipping_details->expected_delivery_date, ['class' => 'form-control','readonly' => 'readonly']) }}
                </div>
                {{-- <div class="form-group col-lg-6 col-md-6"> --}}
                    {{-- {{ Form::label('delivery_date', 'Delivery Date (Optional)') }} --}}
                    
                {{-- </div> --}}

         {{ Form::hidden('delivery_date', $shipping_details->delivery_date, ['class' => 'form-control']) }}    

         <div class="form-group col-lg-2 col-md-2 col-3 col-sm-2 mt-2">
        <div class="">
            {!! Form::submit('Change Status', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    </div>
    {!! Form::close() !!}


@endsection