@extends('backend.layouts.app')
@section('title', 'Create Sub Menus')

@section('content')
@php
use Spatie\Permission\Models\Permission;
  $permissions = Permission::get();
@endphp
<div class="app-content content">
  <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Create Sub Menu</h5>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Create
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section id="multiple-column-form">
          <div class="row match-height">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Create Sub Menu</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    @include('backend.includes.errors')
                    {!! Form::model($backendsubmenu, [
                        'method' => 'POST',
                        'url' => ['admin/backendsubmenu/update'],
                        'class' => 'form'
                    ]) !!}
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::hidden('submenu_id', $backendsubmenu->submenu_id) }}
                              {{ Form::text('submenu_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Name', 'required' => true]) }}
                              {{ Form::label('submenu_name', 'Sub Menu Name *') }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::text('submenu_controller_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Name', 'required' => true]) }}
                              {{ Form::label('submenu_controller_name', 'Sub Menu Controller Name *') }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::text('submenu_action_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Menu Name']) }}
                              {{ Form::label('submenu_action_name', 'Sub Menu Action Name *') }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::select('menu_id', $menu_list, request()->menu_id, ['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            {{ Form::label('visibility', 'Show / Hide') }}
                            <fieldset>
                              <div class="radio radio-success">
                                {{ Form::radio('visibility','1',true,['id'=>'radioshow']) }}
                                {{ Form::label('radioshow', 'Yes') }}
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="radio radio-danger">
                                {{ Form::radio('visibility','0',false,['id'=>'radiohide']) }}
                                {{ Form::label('radiohide', 'No') }}
                              </div>
                            </fieldset>
                          </div>
                          <div class="col-md-6 col-12 mt-2 menu_permissions">
                            {{ Form::label('submenu_permissions', 'Menu Permissions *') }}
                            <ul class="list-unstyled mb-0">
                              @php
                                $backend_permission = explode(',',$backendsubmenu->submenu_permissions);
                              @endphp
                              @foreach($permissions as $permission)
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="checkbox checkbox-primary">
                                    {{ Form::checkbox('submenu_permissions[]', $permission->id, in_array($permission->id,$backend_permission), ['id'=>'submenu_permissions['.$permission->id.']']) }}
                                    {{ Form::label('submenu_permissions['.$permission->id.']', $permission->name) }}
                                  </div>
                                </fieldset>
                              </li>
                              @endforeach
                            </ul>
                          </div>
                          <div class="col-12 d-flex justify-content-start">
                            {{ Form::submit('Update', array('class' => 'btn btn-primary mr-1 mb-1')) }}
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
      </div>
    </div>
@endsection
