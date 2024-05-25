@extends('frontend.layouts.app')
@section('title', 'My Orders')

@section('content')

    <a href="{{ url('/') }}/user/dashboard" class="btn m-3 btn-secondary">Back</a>


    <h1 style="text-align: center;">My Orders</h1>
    <hr>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Total</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($items->toArray())}} --}}
            <?php
            $i = 1;
            ?>
            @if (!empty($invoices))
                @foreach ($invoices as $row)
                    {{-- {{dd($row->lineItem)}} --}}
                    @if($row->current_sub_status !="draft" && !empty($row->current_sub_status))
                    <tr>

                        <td>{{ $i }}</td>
                        <td>{{ $row->invoice_number }}</td>
                        <td>{{ $row->date }}</td>
                        <td>{{ $row->total }}</td>
                        <td>{{ $row->balance }}</td>
                        <td>
                            <a href="{{ route('invoices.ordersview', ['id' => $row->invoice_id]) }}" class="btn btn-light btn-sm">
                                View</a>
                        </td>
                    </tr>
                    @endif
                    <?php
                    $i++;
                    ?>
                @endforeach
            @endif


        </tbody>
    </table>
@endsection
