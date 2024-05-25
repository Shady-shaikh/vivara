@extends('backend.layouts.app')
@section('title', 'Create Download App Image')

@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h5 class="content-header-title float-left pr-1 mb-0">Create Download App Image</h5>
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb p-0 mb-0">
                <li class="breadcrumb-item">
                  <a href="{{ route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
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
              <a href="{{ route('admin.downloadapp') }}" class="btn btn-outline-secondary float-right"><i class="bx bx-arrow-back"></i><span class="align-middle ml-25">Back</span></a>
              <h4 class="card-title">Create Download App Image</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                @include('backend.includes.errors')
                <form method="POST" action="{{ route('admin.downloadapp.store') }}" class="form" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-12 col-12">
                        <div class="form-group">
                          {{ Form::label('image_url', 'Image *') }}
                          <div class="custom-file">
                            {{ Form::file('image_url', ['class' => 'custom-file-input','id'=>'image_url']) }}
                            <label class="custom-file-label" for="image_url">Choose file</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-12">
                        <div class="form-group">
                          {{ Form::label('url', 'Image Url *') }}
                          {{ Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Enter Image path Url', 'required' => true]) }}
                        </div>
                      </div>

                      <div class="col-12 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection
