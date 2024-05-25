@extends('backend.layouts.app')
@section('title')
    Inventory
@stop

@section('content')
    <a href="{{ route('admin.warehouse') }}" class="btn btn-secondary">Back</a>

    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Inventory</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Rate</th>
                        <th>HSN/SAC</th>
                        <th>Product Type</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Stock On Hand</th>
                        <th>Available Stock</th>
                        {{-- <th>SKU</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $item->item_id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{ $item->hsn_or_sac }}</td>
                        <td>{{ $item->product_type }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->stock_on_hand }}</td>
                        <td>{{ $item->available_stock }}</td>
                        {{-- <td>{{ $item->sku }}</td> --}}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Warehouses</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Warehouse Name</th>
                        <th>Stock On Hand</th>
                        <th>Initial Stock</th>
                        <th>Initial Stock Rate</th>
                        <th>Available Stock</th>
                        <th>Actual Available Stock</th>
                        <th>Available For Sale Stock</th>
                        <th>Actual Available For Sale Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item->warehouses as $row)
                        <tr>
                            <td>{{ $row['warehouse_id'] }}</td>
                            <td>{{ $row['warehouse_name'] }}</td>
                            <td>{{ $row['warehouse_stock_on_hand'] }}</td>
                            <td>{{ $row['initial_stock'] }}</td>
                            <td>{{ $row['initial_stock_rate'] }}</td>
                            <td>{{ $row['warehouse_available_stock'] }}</td>
                            <td>{{ $row['warehouse_actual_available_stock'] }}</td>
                            <td>{{ $row['warehouse_available_for_sale_stock'] }}</td>
                            <td>{{ $row['warehouse_actual_available_for_sale_stock'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
