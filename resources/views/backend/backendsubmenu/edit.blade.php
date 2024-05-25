@extends('backend.layouts.app')
@section('title', 'Update Sub Menus')

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
                <li class="breadcrumb-item"><a href="{{ route('admin.backendsubmenu.menu',['menu_id'=>$menu_id])}}">Backend Sub-Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Backend Sub-Menu</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div>
                {{-- <a href="{{ route('admin.backendsubmenu') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                    View
                </a> --}}
            </div>
        </div>
    </div>
    </div>


        <section id="multiple-column-form">
          <div class="row match-height">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Update Backend Sub-Menu</h4>
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
                              {{Form::hidden('id',$menu_id)}}
                              {{ Form::hidden('submenu_id', $backendsubmenu->submenu_id) }}
                              {{ Form::label('submenu_name', 'Sub Menu Name *') }}
                              {{ Form::text('submenu_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Sub Menu Name', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::label('submenu_controller_name', 'Sub Menu Controller Name *') }}
                              {{ Form::text('submenu_controller_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Sub Menu Controller Name', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::label('submenu_action_name', 'Sub Menu Action Name') }}
                              {{ Form::text('submenu_action_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Sub Menu Action Name']) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::label('menu_id', 'Menu') }}
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
                                    {{ Form::checkbox('submenu_permissions[]', $permission->base_permission_id, in_array($permission->base_permission_id,$backend_permission), ['id'=>'submenu_permissions['.$permission->base_permission_id.']']) }}
                                    {{ Form::label('submenu_permissions['.$permission->base_permission_id.']', $permission->base_permission_name) }}
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
  
@endsection
