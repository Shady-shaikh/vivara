@extends('backend.layouts.app')
@section('title')
    Products
@stop

@section('content')
    <a href="{{ route('admin.productsmanage') }}" class="btn btn-secondary">Back</a>

    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Products</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Item Type</th>
                        <th>Rate</th>
                        <th>HSN/SAC</th>
                        <th>Product Type</th>
                        <th>Unit</th>
                        <th>Description</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $item->item_id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->item_type }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{ $item->hsn_or_sac }}</td>
                        <td>{{ $item->product_type }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


@endsection
