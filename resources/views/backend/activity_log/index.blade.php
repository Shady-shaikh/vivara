@extends('backend.layouts.app')
@section('title', 'Activity Log')

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Activity Log</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Activity Log</li>
                </ol>
            </div>
        </div>
    </div>
    {{-- <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ route('admin.category.create') }}">
    <i class="feather icon-plus"></i> Add
    </a>
</div>
</div>
</div> --}}
</div>

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table zero-configuration" id="tbl-datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Username</th>
                                        <th>Description</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($activity_log) && count($activity_log)>0)
                                    @php $srno = 1; @endphp
                                    @foreach($activity_log as $data)
                                    <tr>
                                        <td>{{ $srno }}</td>
                                        <td>
                                            @if (isset($data->user_name))
                                            {{ $data->user_name }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($data->description))
                                            {{ $data->description }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($data->created_at))
                                            {{ $data->created_at }}
                                            @else
                                            --
                                            @endif
                                        </td>
                                    </tr>
                                    @php $srno++; @endphp
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')

<script src="{{ asset('public/backend-assets/vendors/js/datatables.min.js') }}">
</script>
<script src="{{ asset('public/backend-assets/vendors/js/dataTables.bootstrap4.min.js') }}">
</script>
<script>
    $('#tbl-datatable').DataTable({
        responsive: true
    });

</script>
@endsection
