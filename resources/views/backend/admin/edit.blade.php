@extends('backend.layouts.app')
@section('title', 'Edit Internal User')
@php
use Spatie\Permission\Models\Role;
use App\Models\backend\Company;
use App\Models\frontend\Department;
use App\Models\backend\Designation;
use App\Models\backend\Location;
@endphp
@section('content')

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
                <a href="{{ route('admin.users')}}">Internal user</a>
            </li>
            <li class="breadcrumb-item active">edit</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Internal User</h1>
        </div>
        <div>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                Back
            </a>
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
                        {{-- {{ Form::open(['url' => 'admin/user/update']) }} --}}
                        {!! Form::model($userdata, [
                        'method' => 'POST',
                        'url' => ['admin/user/update'],
                        'class' => 'form'
                        ]) !!}
                        {{-- {{dd($userdata)}} --}}
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="forms-group">
                                        {{ Form::label('fullname', 'First Name *') }}
                                        {{ Form::hidden('admin_user_id', $userdata->admin_user_id, ['class' =>
                                        'form-control']) }}
                                        {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' =>
                                        'Enter First Name', 'required' => true]) }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('fullname', 'Last Name *') }}
                                        {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' =>
                                        'Enter Last Name', 'required' => true]) }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ Form::label('email', 'Email *') }}
                                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter
                                        Email', 'required' => true]) }}

                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{-- {{dd($role_id)}} --}}
                                        {{ Form::label('role', 'Role *') }}
                                        {!! Form::select('role', $role, null, ['class' => 'form-control']) !!}
                                        
                                    </div>
                                </div>  



                        <div class="col-md-12 center">
                            <br>
                            {{ Form::submit('Update', ['class' => 'btn btn-primary mr-1 mb-1']) }}
                            <button type="reset" class="btn btn-light mr-1 mb-1">Reset</button>
                        </div>
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

</section>
@endsection
