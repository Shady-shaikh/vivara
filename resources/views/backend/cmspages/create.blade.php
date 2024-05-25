@extends('backend.layouts.app')
@section('title', 'Create CMS Page')

@section('content')
@php
$column_types = ['quick_links'=>'Quick Links','conntect_us'=>'Connect With Us On','our_policies'=>'Our Policies'];
@endphp
<div class="content-header row">
  <div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cmspages')}}">CMS Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">add</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Add CMS Page</h1>
        </div>
        <div>
            <a href="{{ route('admin.cmspages') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                Back
            </a>
        </div>
    </div>
</div>
</div>
        <section id="multiple-column-form">
          <div class="row match-height">
            <div class="col-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
                    @include('backend.includes.errors')
                    <form method="POST" action="{{ route('admin.cmspages.store') }}" class="form">
                      {{ csrf_field() }}
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-12 col-12">
                            <div class="form-group">
                              {{ Form::label('cms_pages_title', 'CMS Page Title *') }}
                              {{ Form::text('cms_pages_title', null, ['class' => 'form-control', 'placeholder' => 'Enter CMS Page Title', 'required' => true]) }}
                            </div>
                          </div>
                          <div class="col-md-12 col-12">
                            <div class="form-group">
                                {{ Form::label('column_type', 'Column') }}
                                {{ Form::select('column_type', $column_types , null,['class'=>'select2 form-control ', 'placeholder' => 'Please Select Column','id'=>'column_type']) }}
                              </div>
                          </div>
                          <div class="col-md-12 col-12" id="cms_pages_content_div">
                            <div class="form-group">
                              {{ Form::label('cms_pages_content', 'CMS Page Content *') }}
                              {{ Form::textarea('cms_pages_content', null, ['class' => 'form-control', 'placeholder' => 'Enter CMS Page Content', 'id'=>'editor2']) }}
                            </div>
                          </div>
                          <div class="col-md-12 col-12" style="display:none;" id="cms_pages_link_div">
                            <div class="form-group">
                              {{ Form::label('cms_pages_link', 'External Links *') }}
                              {{ Form::text('cms_pages_link', null, ['class' => 'form-control', 'placeholder' => 'Enter External Links',]) }}
                            </div>
                          </div>
                          <div class="col-md-3 col-4">
                            {{ Form::label('cms_pages_top', 'Display at Top') }}
                            <fieldset class="">
                              <div class="radio radio-success">
                                {{ Form::radio('cms_pages_top','1',true,['id'=>'radioshowtop']) }}
                                {{ Form::label('radioshowtop', 'Yes') }}
                              </div>
                            <!-- </fieldset>
                            <fieldset> -->
                              <div class="radio radio-danger">
                                {{ Form::radio('cms_pages_top','0',false,['id'=>'radiohidetop']) }}
                                {{ Form::label('radiohidetop', 'No') }}
                              </div>
                            </fieldset>
                          </div>
                          <div class="col-md-3 col-4">
                            {{ Form::label('cms_pages_footer', 'Display at Footer') }}
                            <fieldset class="">
                              <div class="radio radio-success">
                                {{ Form::radio('cms_pages_footer','1',true,['id'=>'radioshowfooter']) }}
                                {{ Form::label('radioshowfooter', 'Yes') }}
                              </div>
                            <!-- </fieldset>
                            <fieldset> -->
                              <div class="radio radio-danger">
                                {{ Form::radio('cms_pages_footer','0',false,['id'=>'radiohidefooter']) }}
                                {{ Form::label('radiohidefooter', 'No') }}
                              </div>
                            </fieldset>
                          </div>
                          <div class="col-md-3 col-4">
                            {{ Form::label('show_hide', 'Show / Hide') }}
                            <fieldset class="">
                              <div class="radio radio-success">
                                {{ Form::radio('show_hide','1',true,['id'=>'radioshow']) }}
                                {{ Form::label('radioshow', 'Yes') }}
                              </div>
                            <!-- </fieldset>
                            <fieldset> -->
                              <div class="radio radio-danger">
                                {{ Form::radio('show_hide','0',false,['id'=>'radiohide']) }}
                                {{ Form::label('radiohide', 'No') }}
                              </div>
                            </fieldset>
                          </div>
                          <!--<div class="col-md-3 col-4">-->
                          <!--  {{ Form::label('contactus_form_flag', 'Contact Form') }}-->
                          <!--  <fieldset class="">-->
                          <!--    <div class="radio radio-success">-->
                          <!--      {{ Form::radio('contactus_form_flag','1',true,['id'=>'contactus_form_flagshow']) }}-->
                          <!--      {{ Form::label('contactus_form_flagshow', 'Yes') }}-->
                          <!--    </div>-->
                          <!--    <div class="radio radio-danger">-->
                          <!--      {{ Form::radio('contactus_form_flag','0',false,['id'=>'contactus_form_flaghide']) }}-->
                          <!--      {{ Form::label('contactus_form_flaghide', 'No') }}-->
                          <!--    </div>-->
                          <!--  </fieldset>-->
                          <!--</div>-->
                          <div class="col-12 d-flex justify-content-start mt-2">
                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
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

<script>
$(document).ready(function()
{
  var load_column_type = $('#column_type').val();
  column_div(load_column_type);
  $('#column_type').on('change',function()
  {
    var column_type = $(this).val();
    column_div(column_type);
  });
  function column_div(column_type)
  {
    if (column_type == 'conntect_us')
    {
      $('#cms_pages_link_div').show();
      $('#cms_pages_content_div').hide();
    }
    else if (column_type == 'quick_links' || column_type == 'our_policies')
    {
      $('#cms_pages_link_div').hide();
      $('#cms_pages_content_div').show();
    }
    else
    {
      $('#cms_pages_link_div').hide();
      $('#cms_pages_content_div').show();
    }
  }
});
</script>
@endsection
