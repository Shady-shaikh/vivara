@extends('backend.layouts.app')
@section('title', 'External Users')
<?php
use App\Models\frontend\Department;
?>
@section('content')



<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Edit External User</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.externalusers') }}">EXTERNAL USER</a>
                    </li>

                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ route('admin.externalusers') }}">
                    <i class="fa-solid fa-angle-left text-light"></i>&nbsp;&nbsp;
                    Back
                </a>
            </div>
        </div>
    </div>
</div>


<section id="basic-datatable">
    <div class="row">
        <div class="col-12 ">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        @include('backend.includes.errors')
                        {{-- {{ Form::open(['url' => 'admin/user/update']) }}
                        --}}
                        {!! Form::model($userdata, [
                        'method' => 'POST',
                        'url' => ['admin/externalusers/update'],
                        'class' => 'form'
                        ]) !!}
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-2">
                                    <div class="form-group">
                                        {{-- {{dd($userdata->toArray())}} --}}
                                        {{ Form::label('fullname', 'First Name *') }}
                                        {{ Form::hidden('user_id', $userdata->user_id, ['class' => 'form-control']) }}
                                        {{ Form::text('name', $userdata->name, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'required' => true]) }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 mb-2">
                                    <div class="form-group">
                                        {{ Form::label('last_name', 'Last Name *') }}
                                        {{ Form::text('last_name', $userdata->last_name, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mb-2">
                                    <div class="form-group">
                                        {{ Form::label('mobile_no', 'Mobile No *') }}
                                        {{ Form::text('mobile_no', $userdata->mobile_no, ['class' => 'form-control', 'placeholder' => 'Enter Mobile No.', 'required' => true]) }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 mb-2">
                                    <div class="form-group">
                                        {{ Form::label('email', 'Email *') }}
                                        {{ Form::text('email', $userdata->email, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'required' => true]) }}

                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('department', 'Department *') }}
                                        {!! Form::select('department',
                                        $department,
                                        $userdata->department,
                                        ['class' => 'form-control', 'placeholder' => 'Select department', 'required' => true]) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('company_id', 'Company *') }}
                                        {!! Form::select('company_id', $company,
                                        $userdata->company_id,
                                        ['class' => 'form-control', 'placeholder' => 'Select Company', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('designation_id', 'Designation *') }}
                                        {!! Form::select('designation_id',
                                        $designation,
                                        $userdata->designation_id,
                                        ['class' => 'form-control', 'placeholder' => 'Select Designation', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('location', 'Location *') }}
                                        {!! Form::select('location',
                                        $location,
                                        $userdata->location,
                                        ['class' => 'form-control', 'placeholder' => 'Select Location', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-12 center">
                                    {{ Form::submit('Update', ['class' => 'btn btn-primary mr-1 mb-1']) }}
                                    <button type="reset" class="btn btn-light mr-1 mb-1">Reset</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        


    
        <div class="col-12">
            <div class="card" style="margin-top:20px !important;">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        {{ Form::open(['url' => 'admin/externalusers/status']) }}
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Status *') }}
                                        {{ Form::hidden('user_id', $userdata->user_id, ['class' => 'form-control']) }}
                                        {!! Form::select('active_status',['0'=>'Inactive', '1'=> 'Active'] ,
                                        $userdata->active_status, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $multi_role = explode(",", $userdata->sub_role);
                                        ?>
                                        {{-- {{dd($userdata->sub_role)}} --}}
                                        
                                        {{ Form::label('role', 'User Role *') }}
                                        {!! Form::select('role[]',$role ,
                                        $multi_role, ['class' => 'form-control ','id'=>'tags','multiple' => 'multiple']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12" id="centralized_decentralized_type">
                                    <div class="form-group">
                                        {{ Form::label('centralized_decentralized_type', 'Centralized/Decentralized Type *') }}

                                        {!! Form::select('centralized_decentralized_type',['1'=>'Centralized', '2'=> 'Decentralized'] ,
                                        $userdata->centralized_decentralized_type, ['class' => 'form-control','id'=>'centralized_decentralized_type_select','placeholder'=>'Select the type']) !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{ Form::submit('Update', ['class' => 'btn btn-primary mr-1 mb-1']) }}
                                    <button type="reset" class="btn btn-light mr-1 mb-1">Reset</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

    </div>

</section>

@endsection
