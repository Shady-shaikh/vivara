@extends('backend.layouts.app')
@section('title', 'Roles')
@php
use Spatie\Permission\Models\Role;
@endphp
@section('content')

<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title">Create Internal User</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </div>
    </div>
  </div>
  <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
      <div class="btn-group" role="group">
        <a class="btn btn-outline-primary" href="{{ route('admin.internalusers') }}">
          <i class="feather icon-eye"></i> view
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
            {{ Form::open(array('url' => 'admin/internaluser/store')) }}
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label('fullname', 'First Name *') }}
                    {{ Form::text('fullname', null, ['class' => 'form-control', 'placeholder' => 'Enter  Name', 'required' => true]) }}
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label('email', 'Email *') }}
                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'required' => true]) }}

                    {{-- Hidden PassWord field    --}}
                    {{ Form::hidden('password', 'Pass@123', ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'required' => true]) }}
                  </div>
                </div>

                {{-- input for role  --}}
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label('role', 'Role *') }}
                    <select name="role_id" id="role_id" class='form-control'>
                      @foreach ($role as $index => $value )
                      <option value="{{ $value['id'] }}"> {{ $value['name'] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    {{ Form::label('date of birth', 'Date if birth*') }}
                    {{ Form::text('dob', null, ['class' => 'form-control', 'placeholder' => 'Enter date of birth', 'id'=>'dob' , 'required' => true]) }}
                  </div>
                </div>
                <div class="col md-12">
                  {{ Form::submit('Save', array('class' => 'btn btn-primary mr-1 mb-1')) }}
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
