@extends('backend.layouts.app')
@section('title', 'Add Department')
@php
use Spatie\Permission\Models\Role;
@endphp
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Add Department</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users')}}">DEPARTMENT MANAGEMENT</a>
                    </li>

                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}"><svg style="margin-right: 6px;font-size: 1.1em;" class="svg-inline--fa fa-angle-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg>
                    Back
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
                        @php
                        $role = Role::get(['id','name'])->toArray();
                        @endphp
                        @include('backend.includes.errors')
                        {{
                            Form::open([
                            'url' => 'admin/storeDepartment'
                            ]) 
                        }}
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('department', 'Department *') }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Department Name', 'required' => true]) }}
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label('date of birth', 'Date of birth*') }}
                                {{ Form::text('dob', null, ['class' => 'form-control', 'placeholder' => 'Enter date of birth', 'id'=>'dob' , 'required' => true]) }}
                            </div> --}}
                        </div>
                        <div class="col md-12" style="padding-left:0px !important;">
                            {{ Form::submit('Add', array('class' => 'btn btn-primary mr-1 mb-1')) }}
                            <button type="reset" class="btn btn-dark mr-1 mb-1">Reset</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    $(document).ready(function() {
        $(function() {
            $("#dob").datepicker();
        });
    });

</script>

@endsection
