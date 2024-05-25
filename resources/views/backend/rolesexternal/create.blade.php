@extends('backend.layouts.app')
@section('title', 'Create External User Role')

@section('content')
@php

use App\Models\backend\BackendMenubar;
use App\Models\backend\BackendSubMenubar;
use Spatie\Permission\Models\Permission;


$user_id = Auth()->guard('admin')->user()->id;

// $backend_menubar = BackendMenubar::Where(['visibility'=>1])->orderBy('sort_order')->get();
@endphp
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">External User</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">External User</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ route('admin.rolesexternal') }}">
                    <i class="fa-solid fa-arrow-left"></i> Back
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
                        <form method="POST" action="{{ route('admin.rolesexternal.store') }}" class="form">
                            {{ csrf_field() }}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 col-12" style="margin-bottom:20px !important;">
                                        <div class="form-label-group">
                                            {{ Form::label('role_name', 'Role Name *') }}
                                            {{ Form::text('role_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Role Name', 'required' => true]) }}

                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12" style="margin-bottom:20px !important;">
                                        <div class="form-group">
                                            {{ Form::label('role_type', 'Role Type *') }}
                                            {!! Form::select('role_type',[''=>'Select Role','User'=>'User', 'Assessment Team'=> 'Assessment Team', 'Approving Authority' => 'Approving Authority','Implementation' => 'Implementation'] ,
                                            null, ['class' => 'form-control','id'=>'role_type','required' => true]) !!}
                                        </div>
                                    </div>

                                    {{-- code for dynamic status --}}
                                    {{-- @php
                                    $idea_status = ['under_approving_authority','reject','on_hold','resubmit'];
                                    @endphp --}}

                                    {{-- code will come form dynamically --}}
                                    <div class="col-md-12 col-12 internal-user external_user_st_data d-none">
                                    </div>


                                      {{-- code will come form dynamically --}}
                                      <div class="col-md-12 col-12 internal-user external_user_men_data d-none">
                                    </div>
                                    

                                    {{-- @php
                                    $menu_status = ['dashboard','my_ideas'];
                                    @endphp

                                    <div class="col-md-12 col-12 internal-user">
                                        <h4 class="card-title">
                                            <div class="checkbox checkbox-primary">
                                                {{ Form::checkbox('menu_values[]', 'menu_values', null, ['id'=>'menu_values']) }}
                                                {{ Form::label('menu_values','Menu') }}
                                            </div>
                                        </h4>

                                        <div class="col-md-12 col-12">
                                            <div class="col-md-12 col-12 mt-2 menu_permissions">
                                                <ul class="list-unstyled mb-0">
                                                  <?php foreach($menu_status as $key => $item){?>
                                                    <li class="d-inline-block mr-2 mb-1">
                                                        <fieldset>
                                                            <div class="checkbox checkbox-primary">
                                                                {{ Form::checkbox('menu_values[]', $item, null, ['id'=>'menu_values['.$item.']']) }}
                                                                {{ Form::label('menu_values['.$item.']',$item)}}
                                                            </div>
                                                        </fieldset>
                                                      
                                                    </li>
                                                    <?php
                                                }?>
                                                </ul>
                                            </div>
                                        </div>
                        
                                    </div> --}}
                         
                                     
                                    {{-- code will come form dynamically --}}
                                    <div class="col-md-12 col-12 internal-user external_user_btn_data d-none">
                                    </div>

                                    {{-- @php
                                    $button_status = ['Add','Edit','View','Delete','Revisions'];
                                    @endphp

                                    <div class="col-md-12 col-12 internal-user">
                                        <h4 class="card-title">
                                            <div class="checkbox checkbox-primary">
                                                {{ Form::checkbox('button_values[]', 'button_values', null, ['id'=>'Buttons']) }}
                                                {{ Form::label('Buttons') }}
                                            </div>
                                        </h4>

                                        <div class="col-md-12 col-12">
                                            <div class="col-md-12 col-12 mt-2 menu_permissions">
                                                <ul class="list-unstyled mb-0">
                                                  <?php foreach($button_status as $key => $item){?>
                                                    <li class="d-inline-block mr-2 mb-1">
                                                        <fieldset>
                                                            <div class="checkbox checkbox-primary">
                                                                {{ Form::checkbox('button_values[]', $item, null, ['id'=>'button_values['.$item.']']) }}
                                                                {{ Form::label('button_values['.$item.']',$item)}}
                                                            </div>
                                                        </fieldset>
                                                      
                                                    </li>
                                                    <?php
                                                }?>
                                                </ul>
                                            </div>
                                        </div>
                        
                                    </div> --}}
                                   
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

    <script>
     document.getElementById('role_type').addEventListener('change', function () {
         var type_id = this.value;
         get_dynamic_status(type_id);
         get_dynamic_menus(type_id);
         get_dynamic_buttons(type_id);
       });
    </script>


    
</section>
</div>
</div>
@endsection
