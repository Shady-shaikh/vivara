@extends('backend.layouts.app')
@section('title', 'CMS Pages')

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
                    <li class="breadcrumb-item active" aria-current="page">CMS Pages</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">CMS Pages</h1>
                </div>
                <div>
                    @if (in_array('Create CMS Pages', $permissions))
                        <a href="{{ route('admin.cmspages.create') }}"
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
                                <table class="table zero-configuration " id="tbl-datatable" style="text-align:center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Page Title</th>
                                            <th>Display at Top</th>
                                            <th>Display at Footer</th>
                                            <th>Visibility</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($cmspages) && count($cmspages) > 0)
                                            @php $srno = 1; @endphp
                                            @foreach ($cmspages as $cmspage)
                                                <tr>
                                                    <td>{{ $srno }}</td>
                                                    <td>{{ $cmspage->cms_pages_title }}</td>
                                                    <td>{{ $cmspage->cms_pages_top == 1 ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $cmspage->cms_pages_footer == 1 ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $cmspage->show_hide == 1 ? 'Yes' : 'No' }}</td>
                                                    <td>

                                                        @if (in_array('Update CMS Pages', $permissions))
                                                            <a href="{{ url('admin/cmspages/edit/' . $cmspage->cms_pages_id) }}"
                                                                class="btn btn-primary"><i
                                                                    class="fa-solid fa-pencil"></i></a>
                                                        @endif

                                                        @if (in_array('Delete CMS Pages', $permissions))
                                                            {!! Form::open([
                                                                'method' => 'GET',
                                                                'url' => ['admin/cmspages/delete', $cmspage->cms_pages_id],
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
    </div>
    </div>

@endsection
