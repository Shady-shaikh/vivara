@extends('backend.layouts.app')
@section('title', 'Add External Users')
@php
use App\Models\frontend\Department;
use App\Models\backend\Company;
use App\Models\backend\Designation;
use App\Models\backend\Location;
@endphp
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Add External User</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.externalusers')}}">EXTERNAL USER</a>
                    </li>

                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ route('admin.externalusers') }}">Back
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
                        @include('backend.includes.errors')
                        {{ Form::open(['url' => 'admin/externalusers/store']) }}
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('name', 'First Name *') }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'required' => true]) }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('last_name', 'Last Name *') }}
                                        {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required' => true]) }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('email', 'Email *') }}
                                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'required' => true]) }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('mobile_no', 'Mobile No *') }}
                                        {!! Form::text('mobile_no', null, ['class' => 'form-control', 'Placeholder' => 'Enter Mobile Number','required' => true]) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('department', 'Department *') }}
                                        {!! Form::select('department',
                                        Department::pluck('name','department_id')->all(),
                                        null,
                                        ['class' => 'form-control', 'placeholder' => 'Select department', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('company_id', 'Company *') }}
                                        {!! Form::select('company_id',
                                        Company::pluck('company_name','company_id')->all(),
                                        null,
                                        ['class' => 'form-control', 'placeholder' => 'Select Company', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('designation_id', 'Designation *') }}
                                        {!! Form::select('designation_id',
                                        Designation::pluck('designation_name','designation_id')->all(),
                                        null,
                                        ['class' => 'form-control', 'placeholder' => 'Select Designation', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('location', 'Location *') }}
                                        {!! Form::select('location',
                                        Location::pluck('location_name','location_id')->all(),
                                        null,
                                        ['class' => 'form-control', 'placeholder' => 'Select Location', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('password', 'Password *') }}
                                        <input type="password" name="password" class="form-control" placeholder="Enter Password" 
                                        data-toggle="tooltip" data-placement="top"
                                        title="Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit" 
                                        required>
                                        <span style="color:red;font-size: 11px;"><b>Note: </b>Password Must Contains Atleat 6 Character With One Special Character, Capital Letter And Digit</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', 'Confirm Password *') }}
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password" required>
                                    </div>
                                </div>
                                <div class="col md-12 center">
                                    <br>
                                    {{ Form::submit('Add', ['class' => 'btn btn-primary mr-1 mb-1']) }}
                                    <button type="reset" class="btn btn-secondary mr-1 mb-1">Reset</button>
                                </div>
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

</section>
@endsection
