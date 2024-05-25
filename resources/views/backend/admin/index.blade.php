@extends('backend.layouts.app')
@section('title', 'Internal Users')

@section('content')
    @php
        use App\Services\RolePermissionService;
        $permissions = RolePermissionService::getUserRolePermissions();
    @endphp


    <div class="content-header row">
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
                    <li class="breadcrumb-item active" aria-current="page">Internal User</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Internal User</h1>
                </div>
                <div>

                    @if (in_array('Create Internal Users', $permissions))
                        <a href="{{ route('admin.create') }}"
                            class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                            Add
                        </a>
                    @endif
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
                                <table class="table zero-configuration " id="tbl-datatable">
                                    <thead>

                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th style="width:20% !important;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($adminusers) && count($adminusers) > 0)
                                            {{-- {{dd($adminusers)}} --}}
                                            @php $srno = 1; @endphp
                                            @foreach ($adminusers as $users)
                                                <tr>
                                                    <td>{{ $srno }}</td>
                                                    <td>{{ $users->first_name }}</td>
                                                    <td>{{ $users->email }}</td>
                                                    <td>{{ $users->userrole->name }}</td>
                                                    <td>
                                                        {{-- @can('Update') --}}
                                                        @if (in_array('Update Internal Users', $permissions))
                                                            <a href="{{ url('admin/user/edit/' . $users->admin_user_id) }}"
                                                                class="btn btn-secondary"><i
                                                                    class="fa-solid fa-pencil"></i></a>
                                                        @endif


                                                        @if (in_array('Delete Internal Users', $permissions))
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'url' => ['admin/user/delete', $users->admin_user_id],
                                                                'style' => 'display:inline',
                                                            ]) !!}

                                                            {!! Form::button('<i class="fa-solid fa-trash"></i>', [
                                                                'type' => 'submit',
                                                                'class' => 'btn btn-danger',
                                                                'onclick' => "return confirm('Are you sure you want to Delete this Entry ?')",
                                                            ]) !!}
                                                            {!! Form::close() !!}
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
