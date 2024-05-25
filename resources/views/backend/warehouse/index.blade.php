@extends('backend.layouts.app')
@section('title')
    Inventory
@stop



@section('content')
    @php
        use App\Services\RolePermissionService;
        $permissions = RolePermissionService::getUserRolePermissions();
    @endphp

    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventory</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Inventory</h1>
            </div>
            <div>
                {{-- <a href="{{ url('admin/shipping/create') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                Add
            </a> --}}
            </div>
        </div>
    </div>


    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration " id="tbl-datatable" style="text-align:center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Item Name</th>
                                            <th>Rate</th>
                                            <th>HSN/SAC</th>
                                            <th>Product Type</th>
                                            <th>Unit</th>
                                            <th>Stock On Hand</th>
                                            <th>Available Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        ?>
                                        @if (!empty($items))
                                            @foreach ($items as $item)
                                                    {{-- {{dd($item->stock_location_details)}} --}}

                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $item->get_item->name }}</td>
                                                        <td>{{ $item->get_item->rate }}</td>
                                                        <td>{{ $item->get_item->hsn_or_sac }}</td>
                                                        <td>{{ $item->get_item->product_type }}</td>
                                                        <td>{{ $item->get_item->unit }}</td>
                                                        <td>{{ $item->warehouse_stock_on_hand }}</td>
                                                        <td>{{ $item->warehouse_available_stock }}</td>
                                                        <td>
                                                            @if (in_array('View Inventory', $permissions))
                                                                <a href="{{ url('admin/warehouse/view/' . $item->item_id) }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <?php
                                                    $i++;
                                                    ?>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        @endsection

                        @section('scripts')
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#tbladmin_product').DataTable({
                                        columnDefs: [{
                                            targets: [0],
                                            visible: true,
                                            searchable: false
                                        }, ],
                                        order: [
                                            [0, "asc"]
                                        ],
                                    });
                                });
                            </script>
                        @endsection
