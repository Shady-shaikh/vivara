@extends('frontend.layouts.app')
@section('title', 'Invoices')

@section('content')

    <a href="{{ url('/') }}/user/dashboard" class="btn m-3 btn-secondary">Back</a>


    <h1 style="text-align: center;">Invoices</h1>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
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
                    <tr>

                        <td>{{ $i }}</td>
                        <td>{{ $row->invoice_number }}</td>
                        <td>{{ $row->date }}</td>
                        <td>{{ $row->due_date }}</td>
                        <td>{{ $row->total }}</td>
                        <td>{{ $row->balance }}</td>
                        <td>
                            <a href="{{ route('invoices.view', ['id' => $row->invoice_id]) }}" class="btn btn-primary btn-sm">
                                View</a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    ?>
                @endforeach
            @endif


        </tbody>
    </table>
@endsection
