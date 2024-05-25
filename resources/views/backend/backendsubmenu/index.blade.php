@extends('backend.layouts.app')
@section('title', 'Backend Sub Menus')

@section('content')


    <div class="content-header row">
        <div class="py-4">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
              <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                  <li class="breadcrumb-item">
                      <a href="#">
                          <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                      </a>
                  </li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.backendmenu')}}">Backend Menu</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Backend Sub-Menu</li>
              </ol>
          </nav>
          <div class="d-flex justify-content-between w-100 flex-wrap">
              <div>
                  <a href="{{ route('admin.backendsubmenu.create') }}/{{ request()->menu_id }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                      Add
                  </a>
              </div>
          </div>
      </div>
      </div>

    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Backend Sub-Menu</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">

                            <div class="table-responsive">
                                <table class="table zero-configuration" id="tbl-datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Controller Name</th>
                                            <th>Method Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($backendsubmenus) && count($backendsubmenus) > 0)
                                            @php $srno = 1; @endphp
                                            @foreach ($backendsubmenus as $menu)
                                                <tr>
                                                    <td>{{ $srno }}</td>
                                                    <td>{{ $menu->submenu_name }}</td>
                                                    <td>{{ $menu->submenu_controller_name }}</td>
                                                    <td>{{ $menu->submenu_action_name }}</td>
                                                    <td>

                                                        <a href="{{ url('admin/backendsubmenu/edit/' .request()->menu_id .'/'. $menu->submenu_id) }}"
                                                            class="btn btn-primary">Edit</a>
                                                        {!! Form::open([
                                                            'method' => 'GET',
                                                            'url' => ['admin/backendsubmenu/delete', $menu->submenu_id],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::button('Delete', [
                                                            'type' => 'submit',
                                                            'class' => 'btn btn-danger',
                                                            'onclick' => "return confirm('Are you sure you want to Delete this Entry ?')",
                                                        ]) !!}
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

@endsection
@section('scripts')
    <script src="{{ asset('public/backend-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('public/backend-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/backend-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
