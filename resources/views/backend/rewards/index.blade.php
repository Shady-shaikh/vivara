<?php
use App\Models\backend\AdminUsers;
use App\Models\backend\Category;
use App\Models\frontend\Users;
?>
@php
$role = Auth::user()->role;
//dd($role);
@endphp
@extends('frontend.layouts.app')

@section('title', 'User Dashboard | Rewards and Recognition')




@section('content')

<div class="container-fluid">

    <div class="row breadcrumbs-top mt-3">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Rewards and Recognition</li>

            </ol>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="content-header row  pt-3 pb-3">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Certificates for Ideas</h3>
        </div>
    </div>
</div>


<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            @if(isset($ideas) && count($ideas) > 0)
                            <table class="table zero-configuration new-configuration-table" id="tbl-datatable">
                                <thead>
                                    <tr>
                                        {{-- {{dd($role)}} --}}
                                        <th>Sr No.</th>
                                        <th>Title</th>
                                        <th width="170">Submitted On</th>
                                        <th>Status</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                {{-- {{dd($ideas->all())}} --}}

                                <tbody>
                                    @php
                                    $srno = 1;
                                    @endphp
                                    @foreach($ideas as $idea)
                                    @php

                                    $idea_status = $idea->active_status;
                                    $status = '';
                                    $status_color = '';
                                    if($idea_status == 'in_assessment') {
                                    $status = "Under Assessment";
                                    $status_color = 'badge bg-secondary me-1';
                                    } elseif($idea_status == 'pending') {
                                    $status = "Pending";
                                    $status_color = 'badge bg-secondary me-1';
                                    } elseif($idea_status == 'under_approving_authority') {
                                    $status = "Under Approval";
                                    $status_color = 'badge bg-warning me-1';
                                    } elseif($idea_status == 'implementation') {
                                    $status = "Implementation";
                                    $status_color = 'badge bg-danger me-1';
                                    } elseif($idea_status == 'reject') {
                                    $reason = $idea->reject_reason == null ? '' : '(Reason : '.$idea->reject_reason.')';
                                    $status = "Rejected ".$reason;
                                    $status_color = 'badge bg-danger me-1';
                                    }elseif($idea_status == 'on_hold') {
                                    $status = "On-hold";
                                    $status_color = 'badge bg-secondary me-1';
                                    }elseif($idea_status == 'resubmit') {
                                    $reason = $idea->resubmit_reason == null ? '' : '(Reason :
                                    '.$idea->resubmit_reason.')';
                                    $status = "Revise Request ".$reason;
                                    $status_color = 'badge bg-warning me-1';
                                    }elseif($idea_status == 'implemented') {
                                    $status = "Implemented";
                                    $status_color = 'badge bg-warning me-1';
                                    }

                                    $category = $idea->category_id == '' || !isset($idea->category_id) ? 'Not
                                    Assigned':
                                    Category::where('category_id',$idea->category_id)->first()['category_name'];
                                    @endphp
                                    <tr>
                                        <td>{{ $srno }}</td>


                                        <td>{{ $idea->title }}</td>

                                        <td>{{ explode(' ',$idea->created_at)[0] }}</td>
                                        <td>
                                            <span class="{{$status_color}}"></span>
                                            {{ $status }}
                                        </td>
                                        <td>{{ $category }}</td>
                                        <td>

                                            <div style="display:flex; gap:8px;">

                                                {!! Form::open([
                                                'method'=>'GET',
                                                'url' => ['/rewards/view',$idea->idea_id],
                                                'style' => 'display:inline'
                                                ]) !!}
                                                {!! Form::button('<i class="fa fa-eye"></i>',
                                                ['type' => 'submit',
                                                'class' => 'btn btn-info btn-orange',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'View Idea Certificate'
                                                ]) !!}
                                                {!! Form::close() !!}

                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                    $srno++;
                                    @endphp
                                    @endforeach
                                    @else
                                    <h1>No Certificates</h1>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

@endsection
@section('scripts')

<script src="{{ asset('public/backend-assets/vendors/js/datatables.min.js') }}">
</script>
<script src="{{ asset('public/backend-assets/vendors/js/dataTables.bootstrap4.min.js') }}">
</script>
<script>
    $('#tbl-datatable').DataTable({
        responsive: true
    });

</script>
@endsection
