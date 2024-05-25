@extends('backend.layouts.app')
@section('title', 'Update Login setting')

@section('content')
@php

@endphp
<div class="app-content content">
  <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Update Login setting</h5>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Update
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
                  <a href="{{ route('admin.loginmanagement') }}" class="btn btn-outline-secondary float-right"><i class="bx bx-arrow-back"></i><span class="align-middle ml-25">Back</span></a>
                  <h4 class="card-title">Update Login setting</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    @include('backend.includes.errors')
                      {!! Form::model($login_management, [
                        'method' => 'POST',
                        'url' => ['admin/loginmanagement/update'],
                        'class' => 'form'
                    ]) !!}
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              {{ Form::hidden('login_management_id', $login_management->login_management_id) }}
                              {{ Form::label('login_management_facebook', 'Facebook Login') }}
                              {{ Form::select('login_management_facebook', ['1'=>'Activate','0'=>'Deactivate'], null, ['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              {{ Form::label('login_management_google', 'Google Login') }}
                              {{ Form::select('login_management_google', ['1'=>'Activate','0'=>'Deactivate'], null, ['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              {{ Form::label('login_management_login', 'User Login') }}
                              {{ Form::select('login_management_login', ['1'=>'Activate','0'=>'Deactivate'], null, ['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              {{ Form::label('login_management_signup', 'User Signup') }}
                              {{ Form::select('login_management_signup', ['1'=>'Activate','0'=>'Deactivate'], null, ['class'=>'select2 form-control']) }}
                            </div>
                          </div>
                          <div class="col-12 d-flex justify-content-start">
                            <!-- <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button> -->
                            {{ Form::submit('Update', array('class' => 'btn btn-primary mr-1 mb-1')) }}
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
