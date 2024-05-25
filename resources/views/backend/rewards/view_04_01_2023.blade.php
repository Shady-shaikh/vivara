<?php
use App\Models\frontend\Users;
use App\Models\backend\AdminUsers;
use App\Models\frontend\IdeaStatus;
use App\Models\frontend\Ideas;
?>
@php
$role = Auth::user()->role;
//dd($role);
@endphp
@extends('backend.layouts.app')
@section('title', 'View Idea Certificate')

@section('content')


<div class="container-fluid">

    <div class="row breadcrumbs-top mt-3">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Certificate</li>

            </ol>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="content-header row  pt-3 pb-3">
        <div class="content-header-left col-md-6 col-12">
            <h3 class="content-header-title">View Idea Certificate</h3>

        </div>
        <div class="content-header-left col-md-6 col-12">
            <div class="btn-group float-md-right  ms-2" style="float: right" role="group"
                aria-label="Button group with nested dropdown" margin-top:-10px;>
                <div class="btn-group" role="group">
                    <a class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Back"
                        href="{{ route('admin.ideaManagement') }}">
                        <i style="margin-right:6px;font-size:1.1em;" class="fa fa-angle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        {{-- {{dd($idea)}} --}}
        @php
        $user = Users::where('user_id',$idea->user_id)->first();
        $idea_status = IdeaStatus::where('idea_id',$idea->idea_id)->where('idea_status','implemented')->first();
        $full_name = '';
        $idea_implemented_date = '';
        if(isset($idea_status)) {
        $idea_implemented_date_arr = explode(' ',$idea_status->created_at);
        $idea_implemented_date = $idea_implemented_date_arr[0];
        }
        if(isset($user)) {
        $full_name = $user->name.' '.$user->last_name;
        }
        @endphp
        <div class="card-body">
            <div class="row ">
                <div class="col-lg-6 mx-auto">
                    <div class="certificate_container" id="DivIdToPrint" style="position: relative;">
                        <img src="{{asset('public/frontend-assets/images/Idea_certificate.png')}}"
                            alt="Certificate Image" style="position:relative;z-index:1;width:100%">
                        <div
                            style="position: absolute;top:0;height:100%;width:50%;left:16.1%;z-index:2;display:flex;flex-direction:column;justify-content:center;align-items:center;">
                            <p style="font-size:1.3em;font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;color:rgb(17, 17, 17);text-align:center;margin-bottom:18px;"
                                class="user_name">{{$full_name}}</p>
                            <p class="date"
                                style="position: absolute;bottom:23%;font-size:1em;font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;color:rgb(17, 17, 17);">
                                {{ $idea_implemented_date }}
                            </p>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type='button' class="btn btn-success mt-2" d='btn' value='Print' onclick='printFunc();'>


                        {{-- <button onclick="saveDiv('pdf','Title')">save div as pdf</button> --}}

                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- Idea Descussion --}}



    <!-- Modal -->

</div>

@endsection