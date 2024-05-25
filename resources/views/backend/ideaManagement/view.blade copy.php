<?php

use App\Models\backend\AdminUsers;
use App\Models\frontend\Users;

?>
@extends('backend.layouts.app')
@section('title', 'Internal Users')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">View Idea</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">View Idea</li>
                </ol>
            </div>
        </div>
    </div>
    <div style="margin-left:auto;" sclass="btn-group" role="group">
        <a class="btn btn-outline-primary" style="margin-right:15px;" href="{{ route('admin.ideaManagement') }}">
            <i style="margin-right:6px;font-size:1.1em;" class="fa fa-angle-left"></i> Back
        </a>
        {{-- <a class="btn btn-outline-primary" href="{{ route('user.ideaRevision',['id' =>$idea->idea_id]) }}">
        Idea Revision
        </a> --}}
    </div>
</div>
<div class="card">

    @php
    $image_path = $idea['image_path'];
    $full_image_path = 'storage/app/public/'.$image_path;
    $extArr = explode('.',$image_path);
    $ext = end($extArr);
    @endphp

    <div class="card-body">
        @php
        $user = Users::where('user_id',$idea->user_id)->first();
        $approving_authority_approval_flag = $idea->approving_authority_approval;
        $implemented_flag = $idea->implemented;
        @endphp
        <div style="display:flex;justify-content:space-between">
            <div>
                <h2 class="" style="line-height:0.5em"><strong>{{ $idea->title }}</strong></h2>
                <p style="color: #979797;"><i>Author : {{ $user['name'] }} {{ $user['last_name'] }} | Submitted on: {{ explode(' ',$idea['created_at'])[0] }}</i></p>
            </div>
            {{-- <div>

                <form method="POST" action="{{url('/admin/updateIdeaStatus')}}">
                    @csrf
                    <div style="display:flex;align-items:stretch;justify-content:center;">
                        <label for="idea_status" style="line-height:30px;margin:0 10px 0 0;"><strong>Status</strong></label>
                        <select class="form-control form-control-sm" id="idea_status" style="height:30px;" name="idea_status">
                            <option {{$idea->active_status == 'In-Assessment'? 'selected' :''}} value="In-Assessment">In-Assessment</option>
                            <option {{$idea->active_status == 'Approving Authority'? 'selected' :''}} value="Approving Authority">Approving Authority</option>
                            <option {{$idea->active_status == 'Implementation'? 'selected' :''}} value="Implementation">Implementation</option>
                        </select> --}}
                        {{-- {{$idea->idea_id}} --}}
                        {{-- <input type="hidden" value="{{$idea->idea_id}}" name="idea_id">
                        <button type="submit" class="btn btn-primary btn-sm" style="display:inline-block;height:30px;padding:0 10px !important;">Submit</button> --}}
                        {{-- <button type="submit" class="btn btn-primary" >Submit</button> --}}
                    {{-- </div>
                </form>
            </div> --}}
        </div>
        <p class="mb-2">{{ $idea->description }}</p>


        {{-- For images --}}
        @if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
        <div style="display:inline-flex;flex-direction:column;">
            <a style="margin-top:10px;" href="{{ asset($full_image_path) }}" target="_blank"><img style="width:250px;" src="{{ asset($full_image_path) }}" alt="{{ $image_path !== 'null' ? 'Image not available': 'Idea Image' }} "></a>
        </div>

        {{-- For document --}}
        @elseif($ext == 'pdf')
        <div style="display:inline-flex;flex-direction:column;justify-content:center;width:16%;align-items:center;">
            {{-- <embed src="{{ asset($full_image_path) }}" width="350px" height="450px" /> --}}
            <img height="100px" src="{{asset('/storage/app/public/uploads/asset/pdf.png')}}">
            <a style="margin-top:10px;" href="{{ asset($full_image_path) }}" target="_blanck">View PDF file</a>
        </div>

        {{-- For PDF --}}
        @elseif($ext == 'doc' || $ext == 'docx')
        <div style="display:inline-flex;flex-direction:column;justify-content:center;width:16%;align-items:center;">
            <img height="100px" src="{{asset('/storage/app/public/uploads/asset/doc.png')}}">
            <a style="margin-top:6px;" href="{{ asset($full_image_path) }}">Download Document</a>
        </div>
        @endif

    </div>
</div>
<div class="card" style="margin-top: 20px">

    <div class="card-body">
        <h3>Idea Discussion</h3>
        @if($feedback !== '')
        @foreach($feedback as $fb)
        @php
        $flag_c = '';
        $style = '';
        $style2 = '';
        @endphp
        @if ($fb['user_role'] == 'admin')
            
        @endif
        @isset($fb['user_id'])
        @php
        $flag_c = 'true';
        $user = AdminUsers::where('admin_user_id',$fb['admin_user_id'])->first();
        @endphp
        @endisset
        @isset($fb['user_id'])
        @php
        $style = 'flex-direction:row-reverse';
        $style2 = 'align-items:flex-end';
        $user = Users::where('user_id',$fb['user_id'])->first();
        @endphp
        @endisset

        <div style="display:flex !important;justify-content: flex-start;align-items:center; {{$style}} ">
            <i class="fa fa-user" style="margin:15px;display:inline-flex;justify-content:center;align-items:center;font-size:2rem;background:rgb(206, 206, 206);height:45px;width:45px; border-radius:100px;" aria-hidden="true">
            </i>
            <div style="display:flex;flex-direction:column;justify-content:space-between;{{$style2}}">
                <p style="margin:0">
                    {{-- {{dd($user['first_name'])}} --}}
                    <strong>
                        {{ $flag_c == true ? $user['first_name']:$user['name']  }} {{ $user['last_name'] }}
                    </strong>
                </p>
                <p style="margin:0">{{ $fb['feedback'] }}</p>
            </div>

        </div>
        @endforeach
        @else
        <div>
            <h4>No Discussion yet</h4>
        </div>
        @endif

        <div class="form_container" style="width:100%;margin-top:30px;">
            <form method="POST" action="{{ route('admin.storeFeedback') }}">
                @csrf
                <div class="feedback_container" style="width:100%;display:flex !important;justify-content: flex-start;align-items:center;">
                    <i class="fa fa-user" style="margin:15px;display:inline-flex;justify-content:center;align-items:center;font-size:2rem;background:rgb(206, 206, 206);height:45px;width:45px; border-radius:100px;" aria-hidden="true">
                    </i>
                    <div class="form-group" style="width:100%">
                        <label for="feedback">Enter your Comments here :</label>
                        <textarea name="feedback" class="form-control" id="feedback" rows="3"></textarea>
                        <input type="hidden" name="idea_id" value="{{ $idea->idea_id }}">
                    </div>

                </div>

                <button type="submit" style="display:block;margin-left:auto" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
