<?php
use App\Models\frontend\Users;
use App\Models\frontend\Ideas;
use App\Models\frontend\IdeaRevisionImages;
?>
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
                <li class="breadcrumb-item active">Idea Revisions</li>

            </ol>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="content-header row pt-3 pb-3">
        <div class="content-header-left col-md-6 col-6">
            <h3 class="content-header-title">View Idea</h3>

        </div>
        <div class="content-header-left col-md-6 col-6">
            <div class="btn-group float-md-right  ms-2" style="float: right" role="group" aria-label="Button group with nested dropdown" margin-top:-10px;>
                <div class="btn-group" role="group">
                    <a class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Back" href="{{ route('ideas.index') }}">
                        <i style="margin-right:6px;font-size:1.1em;" class="fa fa-angle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="card">

    @php
    $image_path = $ideaRevision['image_path'];
    $full_image_path = 'storage/app/public/'.$image_path;
    $extArr = explode('.',$image_path);
    $ext = end($extArr);
    @endphp

    <div class="card-body idea-revision-section">
        <div id="idea_title">
            @php
            $og_ideas = Ideas::where('idea_id',$ideaRevision->idea_id)->first();
            if(isset($og_ideas)) {
            $user_id = $og_ideas->user_id;
            $user = Users::where('user_id',$user_id)->first();
            }
            if(isset($ideaRevision['created_at'])){
            $created_at_arr = explode(' ',$ideaRevision['created_at']);
            $created_at ='| Submitted on : '.$created_at_arr[0];
            } else {
            $created_at ='';
            }
            @endphp
            <h2 class="mb-3 idea-heading"><strong>{{ $ideaRevision->title }}</strong></h2>
            <p style="color: #979797;"><i>Author : {{ $user['name'] }} {{ $user['last_name'] }}
                    <span>{{$created_at}}</span> </i></p>
        </div>
        <div id="idea_description">
            <p class="mb-3">{{ $ideaRevision->description }}</p>
        </div>


        {{-- Files --}}
        @php
        $idea_uni_id = $ideaRevision->idea_uni_id;
        $idea_images = IdeaRevisionImages::where('idea_uni_id',$idea_uni_id)->whereNotNull('idea_uni_id')->get();
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


        {{-- For images --}}
        {{-- For PNG--}}
        {{-- @if($ext == 'png')
        <div class="full-img-boxin">
            <h3 class="attachment-heading mb-3">Attachment</h3>
            <a style="margin-top:10px;" class="test-popup-link" href="{{ asset($full_image_path) }}" target="_blank">
        <img style="width:150px" src="{{asset($full_image_path)}}" alt="{{ $image_path !== 'null' ? 'Image not available': 'Idea Image' }} ">
        </a>
    </div> --}}

    {{-- For jpg --}}
    {{-- @elseif($ext == 'jpg' || $ext == 'jpeg')
        <div class="full-img-boxin">
            <h3 class="attachment-heading mb-3">Attachment</h3>
            <a style="margin-top:10px;" class="test-popup-link" href="{{ asset($full_image_path) }}" target="_blank">
    <img style="width:150px" src="{{asset($full_image_path)}}" alt="{{ $image_path !== 'null' ? 'Image not available': 'Idea Image' }} ">
    </a>
</div> --}}


{{-- For document --}}
{{-- @elseif($ext == 'pdf') --}}
{{-- <div class="full-img-boxin"> --}}
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

</div>
</div>
</div>

@endsection
