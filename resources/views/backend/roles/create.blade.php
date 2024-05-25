@extends('backend.layouts.app')
@section('title', 'Create Roles')

@section('content')
@php

use App\Models\backend\BackendMenubar;
use App\Models\backend\BackendSubMenubar;
use Spatie\Permission\Models\Permission;


$user_id = Auth()->guard('admin')->user()->id;

$backend_menubar = BackendMenubar::Where(['visibility'=>1])->orderBy('sort_order')->get();
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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                </li>
    
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.roles')}}">Internal Roles</a>
                </li>
                <li class="breadcrumb-item active">add</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Add Internal Role</h1>
            </div>
            <div>
                <a href="{{ route('admin.roles') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                    Back
                </a>
            </div>
        </div>
    </div>
</div>


<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        @include('backend.includes.errors')
                        <form method="POST" action="{{ route('admin.roles.store') }}" class="form">
                            {{ csrf_field() }}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 col-12" style="margin-bottom:20px !important;">
                                        <div class="form-label-group">
                                            {{ Form::label('name', 'Role Name *') }}
                                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Role Name', 'required' => true]) }}

                                        </div>
                                    </div>
                                    {{-- @php
                                    //dd($has_permissions);
                                    foreach($backend_menubar as $menu)
                                    {
                                    @endphp
                                    <div class="col-md-12 col-12 internal-user">
                                        @php
                                        if($menu->has_submenu == 1)
                                        {
                                        //$backend_menu_permission = explode(',',$role->menu_ids);
                                        //$backend_submenu_permission = explode(',',$role->submenu_ids);
                                        $backend_submenubar = BackendSubMenubar::Where(['menu_id'=>$menu->menu_id])->get();
                                        if($backend_submenubar)
                                        {
                                        @endphp
                                        <!-- <h4 class="card-title">{{$menu->menu_name}}</h4> -->
                                        <h4 class="card-title">
                                            <div class="checkbox checkbox-primary">
                                                {{ Form::checkbox('menu_id[]', $menu->menu_id, null, ['id'=>'menu['.$menu->menu_id.']']) }}
                                                {{ Form::label('menu['.$menu->menu_id.']', $menu->menu_name) }}
                                            </div>
                                        </h4>
                                        @php
                                        foreach($backend_submenubar as $submenu)
                                        {
                                        @endphp
                                        <div class="col-md-12 col-12">
                                            <!-- <h5 class="">{{ $submenu->submenu_name }}</h5> -->
                                            <h3 class="card-title">
                                                <div class="checkbox checkbox-primary">
                                                    {{ Form::checkbox('submenu_id[]', $submenu->submenu_id, null, ['id'=>'submenu['.$menu->menu_id.']['.$submenu->submenu_id.']']) }}
                                                    {{ Form::label('submenu['.$menu->menu_id.']['.$submenu->submenu_id.']', $submenu->submenu_name) }}
                                                </div>
                                            </h3>
                                            <div class="col-md-12 col-12 mt-2 menu_permissions">
                                                <ul class="list-unstyled mb-0">
                                                    @php
                                                    $backend_permission = explode(',',$submenu->submenu_permissions);
                                                    //not working checked on 12-04-23 by osama
                                                    // $permissions = Permission::where('menu_id',$menu->menu_id)->where('submenu_id',$submenu->submenu_id)->get();
                                                    $permissions = Permission::where('menu_id',$menu->menu_id)->get();
                                                    $permissions = collect($permissions)->mapWithKeys(function ($item, $key) {
                                                    return [$item['base_permission_id'] => ['id'=>$item['id'],'name'=>$item['name']]];
                                                    });
                                                    // dd($submenu->submenu_id);
                                                    @endphp
                                                    @foreach($backend_permission as $permission)
                                                    @if($permission)
                                                    <li class="d-inline-block mr-2 mb-1">
                                                        <fieldset>
                                                            <div class="checkbox checkbox-primary">
                                                                {{ Form::checkbox('permissions['.$permissions[$permission]['id'].']', $permissions[$permission]['id'], null, ['id'=>'permissions['.$permissions[$permission]['id'].']']) }}
                                                                {{ Form::label('permissions['.$permissions[$permission]['id'].']', $permissions[$permission]['name']) }}
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                    @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @php

                                            }
                                          }
                                        }
                                        else
                                        {
                                        //$backend_menu_permission = explode(',',$role->menu_ids);
                                        @endphp

                                        <h4 class="card-title">
                                            <div class="checkbox checkbox-primary">
                                                {{ Form::checkbox('menu_id[]', $menu->menu_id, null, ['id'=>'menu['.$menu->menu_id.']']) }}
                                                {{ Form::label('menu['.$menu->menu_id.']', $menu->menu_name) }}
                                            </div>
                                        </h4>
                                        <div class="col-md-12 col-12 mt-2 menu_permissions">
                                            <ul class="list-unstyled mb-0">
                                                @php
                                                $backend_permission = explode(',',$menu->permissions);
                                                $permissions = Permission::where('menu_id',$menu->menu_id)->get();
                                                $permissions = collect($permissions)->mapWithKeys(function ($item, $key) {
                                                return [$item['base_permission_id'] => ['id'=>$item['id'],'name'=>$item['name']]];
                                                });
                                                //dd($permissions);
                                                @endphp
                                                @foreach($backend_permission as $permission)

                                                @if(isset($permissions[$permission]))
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="checkbox checkbox-primary">
                                                            {{ Form::checkbox('permissions['.$permissions[$permission]['id'].']', $permissions[$permission]['id'], null, ['id'=>'permissions['.$permissions[$permission]['id'].']']) }}
                                                            {{ Form::label('permissions['.$permissions[$permission]['id'].']', $permissions[$permission]['name']) }}
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        @php
                                        }
                                        @endphp
                                    </div>
                                    @php
                                    }
                                    @endphp --}}
                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-secondary mr-1 mb-1 text-white">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
@endsection
