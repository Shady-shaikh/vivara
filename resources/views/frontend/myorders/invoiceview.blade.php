@extends('frontend.layouts.app')
@section('title', 'View Invoice')

@section('content')

    <a href="{{ route('myorders.invoices') }}" class="btn m-3 btn-secondary">Back</a>


    <h1 style="text-align: center;">Invoice</h1>


    <div class="card">
        <div class="card-header">
            Invoice Details
        </div>
        <div class="card-body">
            {{-- {{dd($invoice->toArray())}} --}}
            <h5 class="card-title">Invoice Number: {{ $invoice->invoice_number }}</h5>
            <p class="card-text">Customer: {{ $invoice->customer_data->name . " ".$invoice->customer_data->last_name }}</p>
            <p class="card-text">Total Amount: {{ $invoice->total }}</p>
            <p class="card-text">Invoice Date: {{ $invoice->date }}</p>
            <p class="card-text">Due Date: {{ $invoice->due_date }}</p>

            <h6 class="card-subtitle mt-3">Line Items:</h6>
            <ul class="list-group">


                <li class="list-group-item d-flex justify-content-between">
                    <span>Item Name: {{ $invoice->item_data->name }}</span>
                    <span>Quantity: {{ $invoice->quantity }}</span>
                    <span>Rate: {{ $invoice->rate }}</span>
                </li>

            </ul>
        </div>
    </div>
@endsection
