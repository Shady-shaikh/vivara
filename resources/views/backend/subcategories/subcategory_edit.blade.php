@extends('backend.layouts.app')
@section('title', 'Edit Subcategory')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Edit Subcategory</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.category') }}">Category Master</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.subcategory',['id'=>$subcategories->category_id]) }}">Subcategory</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <a class="btn btn-outline-primary" href="{{ route('admin.subcategory',['id'=>$subcategories->category_id]) }}">
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
                            {!! Form::model($subcategories, [
                                'method' => 'POST',
                                'url' => ['admin/subcategory/update'],
                                'class' => 'form'
                            ]) !!}
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('type', 'Subcategory Name *') }}
                                            {{ Form::text('sub_category_name', null, ['class' => 'form-control','required' => true, 'placeholder'=>'Subcategory name']) }}
                                            {{ Form::hidden('sub_category_id', null , ['class' => 'form-control','required' => true]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('visibility', 'Subcategory Visibility *') }}
                                            {{ Form::select('visibility', ['0'=>'Inactive' , '1' => 'Active'] , null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Select Visibility']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('type', 'Units *') }}
                                            {{ Form::text('units_assigned', null, ['class' => 'form-control','required' => true, 'Placeholder'=> 'Assigned Units']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        {{ Form::label('subcategory_details', 'has Subcategory Details') }}<br>
                                        {{ Form::radio('subcategory_details', '1' , true) }}
                                        {{ Form::label('subcategory_details', 'Yes') }}

                                        {{ Form::radio('subcategory_details', '0' , false) }}
                                        {{ Form::label('subcategory_details', 'No') }}

                                    </div>

                                    <div class="col md-12">
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
@endsection
