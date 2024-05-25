<?php

use App\Models\backend\AdminUsers;
use App\Models\frontend\Users;

?>
@extends('backend.layouts.app')
@section('title', 'View Idea')

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
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary" href="{{ route('admin.ideaManagement') }}"><svg
                        style="margin-right: 6px;font-size: 1.1em;" class="svg-inline--fa fa-angle-left"
                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                        <path fill="currentColor"
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
                        </path>
                    </svg>
                    Back
                </a>
            </div>
        </div>
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
            <div class="row">
                <div class="col-md-12 col-12">

                    <div id="idea_title">
                        <h2 class="mb-3 idea-heading"><strong>{{ $idea->title }}</strong></h2>
                        <p style="color: #979797;"><i>Author : {{ $user['name'] }} {{ $user['last_name'] }}
                                <span>| Submitted on: {{
                                    explode(' ',$idea['created_at'])[0] }}</span> </i></p>

                        <p class="mb-3 ">{{ $idea->description }}</p>

                    </div>

                    {{-- For images --}}
                    @if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    <div class="full-img-boxin">
                        <h3 class="attachment-heading mb-3">Attachment</h3>
                        <div class="full-img-box mb-4">

                            <a href="{{ asset($full_image_path) }}" target="_blank"><img
                                    src="{{asset('/storage/app/public/uploads/asset/png-icon.png')}}"
                                    alt="{{ $image_path !== 'null' ? 'Image not available': 'Idea Image' }} "></a>
                            <a href="#" class="view-img-text" href="{{ asset($full_image_path) }}" target="_blanck">View
                                Image</a>
                        </div>
                    </div>

                    {{-- For document --}}
                    @elseif($ext == 'pdf')
                    <div class="full-img-boxin">
                        <h3 class="attachment-heading mb-3">Attachment</h3>
                        <div class="full-img-box mb-4">

                            {{-- <embed src="{{ asset($full_image_path) }}" width="350px" height="450px" /> --}}
                            <img src="{{asset('/storage/app/public/uploads/asset/pdf-icon.png')}}">
                            <a class="view-img-text" href="{{ asset($full_image_path) }}" target="_blanck">View PDF
                                file</a>
                        </div>
                    </div>

                    {{-- For PDF --}}
                    @elseif($ext == 'doc' || $ext == 'docx')
                    <div class="full-img-boxin">
                        <h3 class="attachment-heading mb-3">Attachment</h3>
                        <div class="full-img-box mb-4">

                            <img src="{{asset('/storage/app/public/uploads/asset/doc.png')}}">
                            <a class="view-img-text" href="{{ asset($full_image_path) }}">Download Document</a>
                        </div>
                    </div>
                    @endif
                </div>
                @if($idea->implemented == 1 && $idea->active_status == 'implemented')
                @if($idea->certificate != 1)
                <div class="col-md-5 col-5">
                    <a href="{{route('admin.approve_certificate',['id'=>$idea->idea_id])}}"
                        class="btn btn-primary">Approve for Certificate</a>
                </div>
                @else
                <div class="col-md-5 col-5">
                    Idea has been approved for certificate
                </div>
                @endif
                @endif
            </div>
            <div class="card" style="margin-top: 20px">

                <div class="card-body">
                    <h3>Idea Discussion</h3>
                    @if(count($feedback) > 0)
                    {{-- {{dd($feedback)}} --}}
                    @foreach($feedback as $fb)
                    @php
                    $flag_c = '';
                    $style = 'flex-direction:row-reverse';
                    $style2 = 'align-items:flex-end';
                    if($fb['user_role'] == 'admin') {
                    $flag_c = 'true';
                    $user = AdminUsers::where('admin_user_id',$fb['user_id'])->first();
                    } else {
                    $flag_c = 'false';
                    $user = Users::where('user_id',$fb['user_id'])->first();
                    }
                    @endphp
                    {{-- {{dd(Auth::id())}} --}}
                    @if(Auth::id() == $fb['user_id'] && $fb['user_role'] == 'admin')
                    @php
                    $style = '';
                    $style2 = '';
                    @endphp
                    @endif
                    <div style="display:flex !important;justify-content: flex-start;align-items:center; {{$style}} ">
                        <i class="fa fa-user"
                            style="margin:15px;display:inline-flex;justify-content:center;align-items:center;font-size:2rem;background:rgb(206, 206, 206);height:45px;width:45px; border-radius:100px;"
                            aria-hidden="true">
                        </i>
                        <div style="display:flex;flex-direction:column;justify-content:space-between;{{$style2}}">
                            <p style="margin:0">
                                <strong>
                                    {{ $flag_c == 'true' ? $user['first_name']:$user['name'] }} {{ $user['last_name'] }}
                                </strong>
                                &nbsp;
                                <em>&#40; {{$fb['user_role']}} &#41;</em>
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
                            <div class="feedback_container"
                                style="width:100%;display:flex !important;justify-content: flex-start;align-items:center;">
                                <i class="fa fa-user"
                                    style="margin:15px;display:inline-flex;justify-content:center;align-items:center;font-size:2rem;background:rgb(206, 206, 206);height:45px;width:45px; border-radius:100px;"
                                    aria-hidden="true">
                                </i>
                                <div class="form-group" style="width:100%">
                                    <label for="feedback">Enter your Comments here :</label>
                                    <textarea name="feedback" class="form-control" id="feedback" rows="3"></textarea>
                                    <input type="hidden" name="idea_id" value="{{ $idea->idea_id }}">
                                </div>

                            </div>

                            <button type="submit" style="display:block;margin-left:auto"
                                class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            @endsection