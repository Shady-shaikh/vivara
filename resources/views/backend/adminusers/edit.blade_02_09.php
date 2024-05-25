@extends('backend.layouts.app')
@section('title', 'Update Admin Users')

@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0">Update Admin User</h5>
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
              <h4 class="card-title">Update Admin User</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                @include('backend.includes.errors')
                {!! Form::model($adminuser, [
                'method' => 'POST',
                'url' => ['admin/adminusers/update'],
                'class' => 'form'
                ]) !!}
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-label-group">
                        {{ Form::hidden('admin_user_id', $adminuser->admin_user_id) }}
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
                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email']) }}
                        {{ Form::label('email', 'Email *') }}
                      </div>
                    </div>
                    <!-- {{ Form::label('role', 'Role *') }} -->
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        {{ Form::select('role', $roles, null,['class'=>'select2 form-control']) }}
                      </div>
                    </div>

                    <div class="col-12 d-flex justify-content-start">
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
      @if(isset($adminuser))
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Update User Status</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              @include('backend.includes.errors')
              {!! Form::model($adminuser, [
              'method' => 'POST',
              'url' => ['admin/adminusers/updatestatus'],
              'class' => 'form'
              ]) !!}
              <div class="form-body">
                <div class="row">

                  <div class="col-md-4 col-12">
                    <fieldset class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          {{ Form::hidden('admin_user_id',$adminuser->admin_user_id ) }}
                          {{ Form::label('account_status', 'User Status ',['class'=>'']) }}
                        </div>
                        {{ Form::select('account_status', ['1'=>'Activate','0'=>'Deactivate'], $adminuser->account_status,['class'=>'select2 form-control ', 'placeholder' => 'Please Select Status',]) }}
                      </div>
                    </fieldset>
                  </div>

                  <div class="col-12 d-flex justify-content-start">
                    {{ Form::submit('Update', array('class' => 'btn btn-primary mr-1 mb-1')) }}
                  </div>
                </div>
              </div>
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
      @endif
    </section>
  </div>
</div>



@endsection