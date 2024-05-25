@extends('backend.layouts.app')
@section('title')
    Invoice
@stop

@section('content')
    <a href="{{ route('admin.reports') }}" class="btn btn-secondary">Back</a>

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
                        <th>Due Date</th>
                        <th>Total</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->customer_data->name . " ".$invoice->customer_data->last_name }}</td>
                        <td>{{ $invoice->date }}</td>
                        <td>{{ $invoice->date }}</td>
                        <td>{{ $invoice->total }}</td>
                        <td>{{ $invoice->balance }}</td>
                    </tr>
                </tbody>
            </table>

            <h3 class="card-subtitle text-center mt-3">Items Details</h3>
            <ul class="list-group">

                <?php
                $quantity_arr = explode(',', $invoice->quantity);
                $i = 0;
                ?>
                {{-- {{dd($quantity_arr)}} --}}
                @foreach ($invoice->item_data() as $row)
                <hr>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Item Name: {{ $row->name }}</span>
                        <span>Unit: {{ $row->unit }}</span>
                        <span>Quantity: {{ $quantity_arr[$i] }}</span>
                        <span>Rate: {{ $row->rate }}</span>
                    </li>
                    <?php
                    $i++;
                    ?>
                @endforeach

            </ul>
        </div>
    </div>
@endsection
