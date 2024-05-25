<?php

use App\Models\frontend\Users;
use App\Models\backend\AdminUsers;
use App\Models\frontend\IdeaStatus;
use App\Models\frontend\IdeaImages;
use App\Models\Rolesexternal;
?>
@php
$role = Auth::user()->role;

$status_buttons = [];

$roles_external = Rolesexternal::where(['id' => Auth::user()->sub_role_final])->first();



if(!empty($roles_external)){
    $status_buttons = explode(',',$roles_external->status_values);
}

//dd($role);
@endphp
@extends('frontend.layouts.app')
@section('title', 'User Dashboard | View Idea')

@section('content')


<div class="container-fluid">

    <div class="row breadcrumbs-top mt-3">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">View Idea</li>

            </ol>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="content-header row  pt-3 pb-3">
        <div class="content-header-left col-md-6 col-6">
            <h3 class="content-header-title">View Idea</h3>
        </div>
        <div class="content-header-left col-md-6 col-6">
            <div class="btn-group float-md-right  ms-2" style="float: right" role="group"
                aria-label="Button group with nested dropdown" margin-top:-10px;>
                <div class="btn-group" role="group">
                    <a class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Back"
                        href="{{ route('ideas.index') }}">
                        <i style="margin-right:6px;font-size:1.1em;" class="fa fa-angle-left"></i> Back
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

        <div class="card-body" style="min-height:320px">
            @php
            $user = Users::where('user_id',$idea->user_id)->first();
            if(isset($idea['created_at'])){
            $created_at_arr = explode(' ',$idea['created_at']);
            $created_at ='| Submitted on : '.$created_at_arr[0];
            } else {
            $created_at ='';
            }
            @endphp
            <div class="row">
                <div class="col-md-7 col-12" style="position: relative;min-height:320px;">

                    <div id="idea_title">
                        <h2 class="mb-3 idea-heading"><strong>{{ $idea->title }}</strong></h2>
                        <p style="color: #979797;"><i>Author : {{ $user['name'] }} {{ $user['last_name'] }}
                                <span>{{$created_at}}</span> </i></p>
                    </div>
                    <div id="idea_description">
                        <p class="mb-3">{{ $idea->description }}</p>
                    </div>

                    {{-- Files --}}
                    @php
                    $idea_uni_id = $idea->idea_uni_id;
                    $idea_images = IdeaImages::where('idea_uni_id',$idea_uni_id)->whereNotNull('idea_uni_id')->get();
                    @endphp
                    @if(count($idea_images) > 0)
                    <div class="full-img-boxin">
                        <h3 class="attachment-heading mb-3">Attachment</h3>
                        <div class="row">
                            @foreach ($idea_images as $idea_image)
                            @php
                            $fileNameParts = explode('.', $idea_image->file_name);
                            $ext = end($fileNameParts);
                            // dd($ext);
                            $img_path = '';
                            $label_text = '';
                            $file_path = asset('storage/app/public/' . $idea_image->image_path);
                            if ($ext == 'doc') {
                            $label_text = 'Download DOC';
                            $img_path = asset('storage/app/public/uploads/asset/doc.png');
                            } elseif ($ext == 'pdf') {
                            $label_text = 'View PDF';
                            $img_path = asset('storage/app/public/uploads/asset/pdf.png');
                            } else {
                            $label_text = 'View Image';
                            $img_path = asset('storage/app/public/' . $idea_image->image_path);
                            }
                            @endphp
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <a style="margin-top:10px;"
                                    class="card card-body shadow {{$ext == 'pdf' || $ext == 'doc' || $ext == 'docx'?'':'test-popup-link'}}"
                                    href="{{ $file_path  }}" target="_blank">
                                    <img style="width:100%;height:100px; object-fit:contain" src="{{ $img_path }}"
                                        alt="{{ $image_path == 'null' ? 'Image not available': 'Idea Image' }} ">
                                    <p class="h5 text-center mt-2">{{$label_text}}</p>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif


                    {{-- @if($ext == 'png')
                    <div class="full-img-boxin">
                        <h3 class="attachment-heading mb-3">Attachment</h3>
                        <a style="margin-top:10px;" class="test-popup-link" href="{{ asset($full_image_path) }}"
                            target="_blank">
                            <img style="width:150px" src="{{asset($full_image_path)}}"
                                alt="{{ $image_path !== 'null' ? 'Image not available': 'Idea Image' }} ">
                        </a>
                    </div> --}}

                    {{-- For jpg --}}
                    {{-- @elseif($ext == 'jpg' || $ext == 'jpeg')
                    <div class="full-img-boxin">
                        <h3 class="attachment-heading mb-3">Attachment</h3>
                        <a style="margin-top:10px;" class="test-popup-link" href="{{ asset($full_image_path) }}"
                            target="_blank">
                            <img style="width:150px" src="{{asset($full_image_path)}}"
                                alt="{{ $image_path !== 'null' ? 'Image not available': 'Idea Image' }} ">
                        </a>
                    </div> --}}


                    {{-- For document --}}
                    {{-- @elseif($ext == 'pdf')
                    <div class="full-img-boxin"> --}}
                        {{-- <embed src="{{ asset($full_image_path) }}" width="350px" height="450px" /> --}}
                        {{-- <h3 class="attachment-heading mb-3">Attachment</h3>
                        <div class="full-img-box mb-4">
                            <img src="{{asset('/storage/app/public/uploads/asset/pdf-icon.png')}}">
                            <a style="margin-top:10px;" href="{{ asset($full_image_path) }}" target="_blanck">View PDF
                                file</a>
                        </div>
                    </div> --}}

                    {{-- For PDF --}}
                    {{-- @elseif($ext == 'doc' || $ext == 'docx')
                    <div class="full-img-boxin">
                        <h3 class="attachment-heading mb-3">Attachment</h3>
                        <div class="full-img-box mb-4">
                            <img src="{{asset('/storage/app/public/uploads/asset/doc-icon.png')}}">
                            <a style="margin-top:6px;" href="{{ asset($full_image_path) }}">Download Document</a>
                        </div>
                    </div>
                    @endif --}}
                </div>

                {{--Status of the idea --}}

                <div class="col-md-5 col-12">
                    <div class="bg-back">
                        <div class="status-heading">
                            <h4 class="mb-4"><strong>Status</strong></h4>
                        </div>
                        <div id="idea_status">
                           
                            


                            @if($idea->active_status == 'implementation')
                            Status : Implementation
                            @elseif($idea->active_status == 'implemented')
                            Status : Implemented

                            @endif
                            {{-- {{Form::open(['method'=>'POST',
                            'route'=>['ideas.updateIdeaStatus'],
                            'class'=>'form']) }}
                            @csrf
                            <div class="idea-status-box mb-2">

                                <select class="form-control me-2" id="idea_status" name="idea_status">
                                    @foreach($idea_active_status as $key => $status_option)
                                    <option {{$idea['active_status']==$key?'selected':''}}
                                        {{$key=='under_approving_authority' ? 'disabled' :'' }} value="{{$key}}">
                                        {{$status_option}}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="hidden" value="{{$role}}" name="role"> --}}
                                {{-- {{$idea->idea_id}} --}}
                                {{-- <input type="hidden" value="{{$idea->idea_id}}" name="idea_id">

                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to change the Idea Status?\nYou will not be able to change the Idea Status again!')"
                                    class="btn btn-primary">Submit</button>
                            </div>
                            {{Form::close()}} --}}
                            
                        </div>

                        <ul class="timeline">
                            @php
                            $idea_status = IdeaStatus::where('idea_id',$idea->idea_id)->get();
                            // dump($idea_status);
                            @endphp
                            @foreach ($idea_status as $is)
                            @if($is->idea_status == 'rejected')
                            @php
                            if(isset($is['user_id'])) {
                            $user_name = Users::where('user_id',$is['user_id'])->first();
                            $date = explode(' ',$is['created_at']);
                            @endphp
                            <li>
                                <p>Idea has been rejected by the <br>
                                    <strong>{{$user_name['name']}}
                                        {{$user_name['last_name']}}
                                        <br></strong> on <strong> {{$date[0]}}</strong> at
                                    <strong>{{$date[1]}}</strong>
                                </p>
                            </li>
                            @php
                            }
                            @endphp
                            @elseif($is->idea_status == 'assessment_team_approved')

                            @php
                            if(isset($is['user_id'])) {
                            $user_name = Users::where('user_id',$is['user_id'])->first();
                            $date = explode(' ',$is['created_at']);
                            @endphp
                            <li>
                                <p>Idea has been submitted for the approval by<br>
                                    <strong>{{$user_name['name']}}
                                        {{$user_name['last_name']}}
                                        <br></strong> on <strong> {{$date[0]}}</strong> at
                                    <strong>{{$date[1]}}</strong>
                                </p>
                            </li>
                            @php
                            }
                            @endphp
                            @elseif($is->idea_status== 'approving_authority_approved')
                            @php
                            if(isset($is['user_id'])) {
                            $user_name = Users::where('user_id',$is['user_id'])->first();
                            $date = explode(' ',$is['created_at']);
                            @endphp
                            <li>
                                <p>Idea has been approved by the<br>
                                    <strong>{{$user_name['name']}}
                                        {{$user_name['last_name']}}
                                        <br></strong> on <strong> {{$date[0]}}</strong> at
                                    <strong>{{$date[1]}}</strong>
                                </p>
                            </li>
                            @php
                            }
                            @endphp
                            @elseif($is->idea_status== 'implemented')
                            @php
                            if(isset($is['user_id'])) {
                            $user_name = Users::where('user_id',$is['user_id'])->first();
                            $date = explode(' ',$is['created_at']);
                            @endphp
                            <li>
                                <p>Idea has been Implemented by the<br>
                                    <strong>{{$user_name['name']}}
                                        {{$user_name['last_name']}}
                                        <br></strong> on <strong> {{$date[0]}}</strong> at
                                    <strong>{{$date[1]}}</strong>
                                </p>
                            </li>
                            @php
                            }
                            @endphp
                            @endif
                            @endforeach
                        </ul>
                    </div>


                    {{-- Implemented the Idea button --}}
                    @if($idea->active_status == 'implementation')
                    @if($idea->implemented == 0)
                    <div class="d-flex justify-content-end mt-3">
                        @if(in_array('implemented',$status_buttons))
                        <button type="button" title="click here to change the status of the idea to Implemented"
                            class="btn btn-success" data-toggle="modal" data-target="#implementationModal">Idea
                            Successfully Implemented</button>
                            @endif
                    </div>
                    @endif
                    @endif
                    {{-- Generate Certificate code --}}
                    @if($idea->implemented == 1 && $idea->active_status == 'implemented')
                    @if($idea->certificate != 1)

                    <div class="d-flex justify-content-end mt-3">
                        @if(in_array('certificate',$status_buttons))
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#approveForCertificateModal">Generate Certificate</button>
                            @endif
                    </div>
                    @else
                    <div class="d-flex flex-column align-items-end mt-3">
                        <p>Certificate has already been Generated</p>
                        <a class="btn btn-primary" href="{{ route('rewards.view',['id'=>$idea->idea_id]) }}">View
                            Certificate</a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Idea Discussion --}}
    <div class="card" style="margin-top: 20px">

        <div class="card-body idea-discussion-in">
            <h3 class="mb-4">Idea Discussion</h3>
            <div class="chat-section">
                @if(count($feedback) > 0)
                @foreach($feedback as $fb)
                @php
                $flag_c = '';
                $class_idea_discussion = 'idea-discussion-box-right';
                $style = 'flex-direction:row-reverse';
                $style2 = 'align-items:flex-end';
                $style3 = '';
                if($fb['user_role'] == 'admin') {
                $flag_c = 'true';
                $user = AdminUsers::where('admin_user_id',$fb['user_id'])->first();
                } else {
                $flag_c = 'false';
                $user = Users::where('user_id',$fb['user_id'])->first();
                }
                @endphp
                @if(Auth::id() == $fb['user_id'] && $fb['user_role'] !== 'admin')
                @php
                $flag_c = 'false';
                $class_idea_discussion = 'idea-discussion-box';
                $style = '';
                $style2 = '';
                @endphp
                @endif
                <div class="users-img mb-3"
                    style="display:flex !important;justify-content: flex-start;align-items:center; {{$style}}">
                    {{-- <i class="fa fa-user" aria-hidden="true">
                    </i> --}}
                    <div class="{{$class_idea_discussion}}"
                        style="display:flex;flex-direction:column;justify-content:space-between;{{$style2}}">
                        <h4>
                            <strong>
                                {{ $flag_c == 'true' ? $user['first_name']:$user['name'] }} {{ $user['last_name'] }}
                            </strong>
                            &nbsp;
                            <em>&#40; {{$fb['user_role']}} &#41;</em>
                        </h4>
                        <p class="feedback-text">{{ $fb['feedback'] }}</p>
                        <p lass="datein">{{ $fb['created_at'] }}</p>
                    </div>

                </div>
                @endforeach
                @else
                {{-- {{dd('hello')}} --}}
                <div>
                    <h4>No Discussion yet</h4>
                </div>
                @endif
            </div>
            <div class="form_container chat-form">
                <form method="POST" action="{{ route('ideas.storeFeedback') }}">
                    @csrf
                    <div class="users-img feedback_container">
                        {{-- <i class="fa fa-user" aria-hidden="true">
                        </i> --}}
                        <div class="form-group" style="width:100%;">
                            {{-- <label for="feedback">Enter your Comments here :</label> --}}
                            <textarea name="feedback" class="form-control" placeholder="Enter your Comments here :"
                                id="feedback" rows="1"></textarea>
                            <input type="hidden" name="idea_id" value="{{ $idea->idea_id }}">
                        </div>
                    </div>
                    <button type="submit" style="display:block;margin-left:auto"
                        class="chat-btn btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="implementationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Implemented</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to change the Idea status to Implemented ?<br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{route('ideas.idea_implemented',['id'=>$idea->idea_id,'role'=>$roles_external->role_type])}}"
                        class="btn btn-primary">Yes</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="approveForCertificateModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Certificate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to Generate Certificate for this Idea
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{route('ideas.approve_certificate',['id'=>$idea->idea_id])}}"
                        class="btn btn-primary">Yes</a>
                </div>
            </div>
        </div>
    </div>
    @endsection