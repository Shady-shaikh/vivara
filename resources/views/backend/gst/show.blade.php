@extends('backend.layouts.app')
@section('title')
    Taxes
@stop

@section('content')
    <a href="{{ route('admin.gst') }}" class="btn btn-secondary">Back</a>

    <div class="mb-3 mb-lg-0 mt-3 mb-2">
        <h1 class="h4">Taxes</h1>
    </div>
    <div class="card mt-3">


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tax ID</th>
                        <th>Tax Name</th>
                        <th>Tax Percentage</th>
                        <th>Tax Type</th>
                        <th>Tax Specifc Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $tax->tax_id }}</td>
                        <td>{{ $tax->tax_name }}</td>
                        <td>{{ $tax->tax_percentage }}</td>
                        <td>{{ $tax->tax_type }}</td>
                        <td>{{ !empty($tax->tax_specific_type)?$tax->tax_specific_type:'csgt, sgst' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
