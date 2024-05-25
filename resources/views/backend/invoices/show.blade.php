@extends('backend.layouts.app')
@section('title')
    Invoice
@stop

@section('content')

    @php
        use App\Models\backend\Items;
    @endphp

    <a href="{{ route('admin.invoice') }}" class="btn btn-secondary">Back</a>

    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Invoice</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Customer Name</th>
                        <th>Invoice Date</th>
                        {{-- <th>Due Date</th> --}}
                        <th>Total</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->customer_data->name . ' ' . $invoice->customer_data->last_name }}</td>
                        <td>{{ $invoice->date }}</td>
                        {{-- <td>{{ $invoice->date }}</td> --}}
                        <td>{{ $invoice->total }}</td>
                        <td>{{ $invoice->balance }}</td>
                    </tr>
                </tbody>
            </table>
            <h5 class="card-subtitle mt-3 text-center">Line Items</h5>
            <hr>
            <ul class="list-group">

                <?php
                $quantity_arr = explode(',', $invoice->quantity);
                $item_arr = explode(',', $invoice->item_id);
                $rate_arr = explode(',', $invoice->rate);
                $i = 0;
                ?>
                {{-- {{dd($quantity_arr)}} --}}
                @foreach ($item_arr as $row)
                    @if (!empty($row))
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Item Name:
                                @php
                                    $item = Items::where('item_id', $row)->first();
                                    echo $item->name;
                                @endphp
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
                <h6 class="card-text">Total:
                    {{ $invoice->total - ($invoice->tax_amount + $invoice->shipping_charges  ) +  $invoice->discount }}
                </h6>
                <h6 class="card-text">Total Tax :
                    {{ $invoice->tax_amount }}</h6>
                <h6 class="card-text">Shipping Charges : {{ $invoice->shipping_charges }}</h6>
                <h6 class="card-text">Discount : {{ $invoice->discount }}</h6>
                <h6 class="card-text">Total Amount: {{ $invoice->total }}</h6>
                <br>
            </div>
        </div>
    </div>
@endsection
