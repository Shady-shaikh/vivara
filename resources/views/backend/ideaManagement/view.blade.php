<?php

use App\Models\backend\AdminUsers;
use App\Models\frontend\IdeaImages;
use App\Models\frontend\Users;
use App\Models\frontend\IdeaStatus;

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
                <a class="btn btn-outline-primary" href="{{ route('admin.ideaManagement') }}"><svg style="margin-right: 6px;font-size: 1.1em;" class="svg-inline--fa fa-angle-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
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
        if(isset($idea['created_at'])){
        $created_at_arr = explode(' ',$idea['created_at']);
        $created_at ='| Submitted on : '.$created_at_arr[0];
        } else {
        $created_at ='';
        }
        @endphp
        <div>

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
                    $idea_images = IdeaImages::where('idea_uni_id',$idea_uni_id)->get();
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
                                <a style="margin-top:10px;" class="card card-body shadow {{$ext == 'pdf' || $ext == 'doc' || $ext == 'docx'?'':'test-popup-link'}}" href="{{ $file_path  }}" target="_blank">
                                    <img style="width:100%;height:100px; object-fit:contain" src="{{ $img_path }}" alt="{{ $image_path == 'null' ? 'Image not available': 'Idea Image' }} ">
                                    <p class="h5 text-center mt-2">{{$label_text}}</p>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
                <div class="col-md-5 col-12">
                    <div class="bg-back">
                        <div class="status-heading">
                            <h4 class="mb-4"><strong>Status</strong></h4>
                        </div>
                        <div id="idea_status">

                            @if($idea->active_status == 'pending')
                            Status : Pending
                            @elseif($idea->active_status == 'in_assessment')
                            Status : Under Assessment
                            @elseif($idea->active_status == 'under_approving_authority')
                            Status : Under Approval
                            @elseif($idea->active_status == 'on_hold')
                            Status : On-hold
                            @elseif($idea->active_status == 'resubmit')
                            @php
                            $reason = $idea->resubmit_reason == null ? '' : '(Reason : '.$idea->resubmit_reason.')';
                            @endphp
                            Status : Revise Request {{ $reason }}
                            @elseif($idea->active_status == 'reject')
                            @php
                            $reason = $idea->reject_reason == null ? '' : '(Reason : '.$idea->reject_reason.')';
                            @endphp
                            Status : Rejected {{$reason}}
                            @elseif($idea->active_status == 'implementation')
                            Status : Implementation
                            @elseif($idea->active_status == 'implemented')
                            Status : Implemented
                            @endif
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
                </div>

                @if($idea->implemented == 1 && $idea->active_status == 'implemented')
                @if($idea->certificate != 1)

                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#approveForCertificateModal">Generate Certificate</button>
                </div>
                @else
                <div class="d-flex flex-column align-items-end mt-3">
                    <p>Certificate has already been Generated</p>
                    <a class="btn btn-primary" href="{{ route('admin.rewards.view',['id'=>$idea->idea_id]) }}">View
                        Certificate</a>
                </div>
                @endif
                @endif
            </div>
            {{-- <div class="card" style="margin-top: 20px">


            </div> --}}

        </div>
    </div>
</div>
<div class="card mt-4">
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
            <i class="fa fa-user" style="margin:15px;display:inline-flex;justify-content:center;align-items:center;font-size:2rem;background:rgb(206, 206, 206);height:45px;width:45px; border-radius:100px;" aria-hidden="true">
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
<!-- Modal -->
<div class="modal fade" id="approveForCertificateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a href="{{route('admin.approve_certificate',['id'=>$idea->idea_id])}}" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>
@endsection
