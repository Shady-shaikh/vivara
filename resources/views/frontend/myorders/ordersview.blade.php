@extends('frontend.layouts.app')
@section('title', 'View Orders')

@section('content')

    @php
        use App\Models\backend\Items;
    @endphp

    <a href="{{ route('myorders.orders') }}" class="btn m-3 btn-secondary">Back</a>


    <h1 style="text-align: center;">Orders</h1>


    <div class="card">
        <div class="card-header">
            Invoice Details
        </div>
        <div class="card-body">
            {{-- {{dd($invoice)}} --}}
            <h5 class="card-title">Invoice Number: {{ $invoice->invoice_number }}</h5>
            <p class="card-text">Customer: {{ $invoice->customer_data->name . ' ' . $invoice->customer_data->last_name }}</p>
            {{-- <p class="card-text">Total Amount: {{ $invoice->total }}</p> --}}
            <p class="card-text">Invoice Date: {{ $invoice->date }}</p>
            {{-- <p class="card-text">Due Date: {{ $invoice->due_date }}</p> --}}

            <h3 class="card-subtitle mt-3">Line Items:</h3>
            <ul class="list-group">

                <?php
                $quantity_arr = explode(',', $invoice->quantity);
                $item_arr = explode(',', $invoice->item_id);
                $rate_arr = explode(',', $invoice->rate);
                $i = 0;
                ?>
                {{-- {{dd($item_arr)}} --}}
                @foreach ($item_arr as $row)
                    @if (!empty($row))
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Item Name:
                                @php
                                    $item = Items::where('item_id', $row)->first();
                                    echo $item->name;
                                @endphp
                            &nbsp;&nbsp;
                            @if(!empty($item->item_image))
                              <a href="{{ asset('/public/frontend-assets/images/').'/'.$item->item_image }}" target="_blank">
                              <img src="{{ asset('/public/frontend-assets/images/').'/'.$item->item_image }}" alt="No-Image" style='width:50px;'>
                              </a>
                            @endif
                            </span>
                            <span>Quantity: {{ $quantity_arr[$i] }}</span>
                            <span>Rate:
                                @if ($rate_arr[$i] == 0)
                                    {{ 'Free' }}
                                @else
                                    {{ $rate_arr[$i] }}
                                @endif
                            </span>
                        </li>
                    @endif
                    <?php
                    $i++;
                    ?>
                @endforeach

            </ul>
            <div class="text-center mt-3">
                <h4 class="card-text">Total:
                    {{ $invoice->total - ($invoice->tax_amount + $invoice->shipping_charges  ) +  $invoice->discount }}
                </h4>
                <h4 class="card-text">Total Tax :
                    {{ $invoice->tax_amount }}</h4>
                <h4 class="card-text">Shipping Charges : {{ $invoice->shipping_charges }}</h4>
                <h4 class="card-text">Discount : {{ $invoice->discount }}</h4>
                <h4 class="card-text">Total Amount: {{ $invoice->total }}</h4>
            </div>

        </div>
    </div>
@endsection
