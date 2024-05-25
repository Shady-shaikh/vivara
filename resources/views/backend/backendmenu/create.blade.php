@extends('backend.layouts.app')
@section('title', 'Create Menu')

@section('content')
    @php
        use App\Models\backend\BasePermissions;
        $permissions = BasePermissions::get();
    @endphp


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
                  <li class="breadcrumb-item active" aria-current="page">Add</li>
              </ol>
          </nav>
          <div class="d-flex justify-content-between w-100 flex-wrap">
              <div>
                  <a href="{{ route('admin.backendmenu') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                      View
                  </a>
              </div>
          </div>
      </div>
      </div>




  
            
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create Menu</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @include('backend.includes.errors')
                                    {{ Form::open(['url' => 'admin/backendmenu/store']) }}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('menu_name', 'Menu Name *') }}
                                                    {{ Form::text('menu_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Name', 'required' => true]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('menu_controller_name', 'Menu Controller Name *') }}
                                                    {{ Form::text('menu_controller_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Controller Name', 'required' => true]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('menu_action_name', 'Menu Action Name') }}
                                                    {{ Form::text('menu_action_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Action Name']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('menu_icon', 'Menu Icon') }}
                                                    {{ Form::text('menu_icon', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Icon']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                {{ Form::label('has_submenu', 'Has Subcategories ?') }}
                                                <fieldset>
                                                    <div class="radio radio-success">
                                                        {{ Form::radio('has_submenu', '1', true, ['id' => 'radioyes']) }}
                                                        {{ Form::label('radioyes', 'Yes') }}
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="radio radio-danger">
                                                        {{ Form::radio('has_submenu', '0', false, ['id' => 'radiono']) }}
                                                        {{ Form::label('radiono', 'No') }}
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                {{ Form::label('visibility', 'Show / Hide') }}
                                                <fieldset>
                                                    <div class="radio radio-success">
                                                        {{ Form::radio('visibility', '1', true, ['id' => 'radioshow']) }}
                                                        {{ Form::label('radioshow', 'Yes') }}
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="radio radio-danger">
                                                        {{ Form::radio('visibility', '0', false, ['id' => 'radiohide']) }}
                                                        {{ Form::label('radiohide', 'No') }}
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6 col-12 mt-2 menu_permissions">
                                                {{ Form::label('permissions', 'Menu Permissions *') }}
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($permissions as $permission)
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="checkbox checkbox-primary">
                                                                    {{ Form::checkbox('permissions[]', $permission->base_permission_id, null, ['id' => 'permissions[' . $permission->base_permission_id . ']']) }}
                                                                    {{ Form::label('permissions[' . $permission->base_permission_id . ']', $permission->base_permission_name) }}
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-12 d-flex justify-content-start">
                                                {{ Form::submit('Save', ['class' => 'btn btn-primary mr-1 mb-1']) }}
                                                <button type="reset"
                                                    class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
 
    <script>
        $(document).ready(function() {
            $('input[type=radio][name=has_submenu]').change(function() {
                // alert(this.value);
                permissions(this.value);
            });
            var sub_per_load = $('input[type=radio][name=has_submenu]:checked').val();
            if (sub_per_load != '') {
                // alert(sub_per_load);
                permissions(sub_per_load);
            }
        });

        function permissions(subcat) {
            if (subcat == '1') {
                $('.menu_permissions').hide();
            } else if (subcat == '0') {
                $('.menu_permissions').show();
            }
        }
    </script>
@endsection
