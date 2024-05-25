@extends('backend.layouts.app')
@section('title', 'Create Category')
@php
use Spatie\Permission\Models\Role;
@endphp
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Create Category</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.category') }}">Category Master</a>
                    </li>

                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ route('admin.category') }}">
                    <i class="feather icon-eye"></i> Back
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
                        {{ Form::open(['url' => 'admin/category/store']) }}
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('category_name', 'Categoty Name *') }}
                                        {{ Form::text('category_name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Enter Category Name']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {{ Form::submit('Save', ['class' => 'btn btn-primary mr-1 mb-1']) }}
                                    <button type="reset" class="btn btn-dark mr-1 mb-1">Reset</button>
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
        $(function() {
            $("#dob").datepicker();
        });
    });

</script>

@endsection
