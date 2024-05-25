@extends('backend.layouts.app')
@section('title', 'Roles External')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title" style="font-weight: 900;">Roles External</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb" style="    background-color: #404e67;width: 34%;    ;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard')}}" style="
    color: #ffffff;
    text-underline-position: n;
    text-decoration: none;
    font-weight: 500;
    letter-spacing: 1px;
">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" style="color: #0ddbb9;
    font-weight: 700;
    letter-spacing: 1px;">Roles External

                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ route('admin.rolesexternal.create') }}">
                    <i class="feather icon-plus"></i> Add
                </a>
            </div>
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
                                        <th style="font-weight:600 !important;width:10% !important;">SR. NO</th>
                                        <th style="font-weight:600 !important;width:70% !important;">Name</th>
                                        <th style="font-weight:600 !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($roles) && count($roles)>0)
                                    @php $srno = 1; @endphp
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $srno }}</td>
                                        <td>{{ $role->role_name }}</td>
                                        <td>
                                            <!-- @can('Update') -->
                                            <!-- @endcan -->
                                            <a href="{{ url('admin/rolesexternal/edit/'.$role->id) }}" class="btn btn-darkblue"><i class="feather icon-edit-2"></i></a>
                                            <!-- @can('Delete') -->
                                            <!-- @endcan -->
                                            {!! Form::open([
                                            'method'=>'GET',
                                            'url' => ['admin/rolesexternal/delete', $role->id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="feather icon-trash "></i>', ['type' => 'submit', 'class' => 'btn btn-red','onclick'=>"return confirm('Are you sure you want to Delete this Entry ?')"]) !!}
                                            {!! Form::close() !!}
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
</div>
</div>

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
