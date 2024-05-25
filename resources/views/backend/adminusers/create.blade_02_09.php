@extends('backend.layouts.app')
@section('title', 'Create User')

@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Create User</h5>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Create
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section id="multiple-column-form">
          <div class="row match-height">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Create User</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    @include('backend.includes.errors')
                    {{ Form::open(array('url' => 'admin/adminusers/store')) }}
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'required' => true]) }}
                              {{ Form::label('first_name', 'First Name *') }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required' => true]) }}
                              {{ Form::label('last_name', 'Last Name *') }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email']) }}
                              {{ Form::label('email', 'Email *') }}
                            </div>
                          </div>
                          <!-- {{ Form::label('role', 'Role *') }} -->
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              {{ Form::select('role', $roles, 'S',['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::password('password',  ['class' => 'form-control', 'placeholder' => 'Enter Password']) }}
                              {{ Form::label('password', 'Password *') }}
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-label-group">
                              {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Enter Confirm Password']) }}
                              {{ Form::label('password_confirmation', 'Confirm Password *') }}
                            </div>
                          </div>

                          <div class="col-12 d-flex justify-content-start">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary mr-1 mb-1')) }}
                            <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
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
      </div>
    </div>
@endsection
