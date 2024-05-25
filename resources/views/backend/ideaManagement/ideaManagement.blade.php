<?php

use App\Models\backend\AdminUsers;
use App\Models\frontend\Users;
use App\Models\backend\Category;
use App\Models\frontend\IdeaImages;
?>
@extends('backend.layouts.app')
@section('title', 'Idea Management')

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Manage Ideas</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Ideas</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                {{-- <a class="btn btn-outline-primary" href="{{ route('user.addIdea') }}">
                    <i class="feather icon-plus"></i> Add
                </a> --}}
            </div>
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
                            <div class="input-group my-2 daterange-inn" style="display:flex;justify-content:flex-end;">
                                <div style="display:flex;justify-content:center;align-items:center;" class=" mx-2">
                                    <i class="fa fa-calendar" style="margin-right:8px;" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm" id="daterange"
                                        placeholder="Search by date range..">
                                </div>
                            </div>
                            <table style="position:relative" class="table zero-configuration " id="tbl-datatable">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>ID</th>
                                        <th>Submitted By</th>
                                        <th>Title</th>
                                        <th class="file_uploaded" style="width:12%">File Uploaded</th>
                                        <th>Submitted On</th>
                                        <th>Status</th>
                                        <th>Category</th>
                                        <th class="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $srno = 1;
                                    @endphp
                                    @foreach($ideas as $idea)
                                    @php
                                    $image_path = $idea['image_path'];
                                    $full_image_path = 'storage/app/public/'.$image_path;
                                    $extArr = explode('.',$image_path);
                                    $ext = end($extArr);
                                    $user = Users::where('user_id',$idea->user_id)->first();
                                    // dd($user->toArray());
                                    // dd($ext);
                                    // dd($ext);
                                    $status = '';
                                    $status_color = "";
                                    $idea_status = $idea->active_status;
                                    if($idea_status == 'in_assessment') {
                                    $status = "In Assessment";
                                    $status_color = "badge-outline-primary";
                                    } elseif($idea_status == 'pending') {
                                    $status = "Pending";
                                    $status_color = "badge-outline-pending";
                                    } elseif( $idea_status == 'under_approving_authority') {
                                    $status = "Under Approving Authority";
                                    $status_color = "badge-outline-info";
                                    } elseif($idea_status == 'implementation') {
                                    $status = "Implementation";
                                    $status_color = "badge-outline-warning";
                                    }elseif($idea_status == 'reject') {
                                    $reason = $idea->reject_reason == null ? '' : '(Reason : '.$idea->reject_reason.')';
                                    $status = "Rejected ".$reason;
                                    $status_color = "badge-outline-danger";
                                    }elseif($idea_status == 'on_hold') {
                                    $status = "On-hold";
                                    $status_color = "badge-outline-dark";
                                    }elseif($idea_status == 'resubmit') {
                                    $reason = $idea->resubmit_reason == null ? '' : '(Reason :
                                    '.$idea->resubmit_reason.')';
                                    $status = "Revise Request ".$reason;
                                    $status_color = "badge-outline-resubmit";
                                    }elseif($idea_status == 'implemented') {
                                    $status = "Implemented";
                                    $status_color = "badge-outline-success";
                                    }
                                    $category = $idea->category_id == '' || !isset($idea->category_id) ? 'Not
                                    Assigned':
                                    Category::where('category_id',$idea->category_id)->first()['category_name'];
                                    @endphp
                                    <tr>
                                        {{-- {{dd($user['name'])}} --}}
                                        <td>{{ $srno }}</td>
                                        <td>{{ '000'.$idea->idea_id }}</td>
                                        @if(isset($user))
                                        <td>{{ $user['name'] }} {{ $user['last_name'] }}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        <td>{{ $idea->title }}</td>
                                        <td>
                                            @php
                                            $files = IdeaImages::where('idea_uni_id',$idea->idea_uni_id)->get();
                                            // dd($idea->idea_uni_id);
                                            // foreach($files as $file) {
                                            // dd(asset('storage/app/public/'.$file->image_path));
                                            // }
                                            @endphp
                                            {{-- @if($image_path == '' || !isset($image_path))
                                            File Not Uploaded
                                            @else
                                            @if($ext == 'png')
                                            <img src="{{ asset('/storage/app/public/uploads/asset/png-icon.png') }}"
                                                alt="Image not available">
                                            @elseif($ext == 'jpg' || $ext == 'jpeg')
                                            <img src="{{ asset('/storage/app/public/uploads/asset/jpg-icon.png') }}"
                                                alt="Image not available">
                                            @elseif($ext == 'pdf')
                                            <a href="{{ asset($full_image_path) }}" target="_blanck"><img
                                                    src="{{asset('/storage/app/public/uploads/asset/pdf-icon.png')}}"
                                                    alt="Image not available"></a>
                                            @elseif($ext == 'doc' || $ext == 'docx')
                                            <a href="{{ asset($full_image_path) }}"><img
                                                    src="{{asset('/storage/app/public/uploads/asset/doc-icon.png')}}"
                                                    alt="Image not available"></a>
                                            @endif
                                            @endif --}}
                                            @if(count($files) > 0)
                                            <a href="#" class="images_modal_class"
                                                data-id="{{ $idea->idea_uni_id }}">{{count($files).' files'}}</a>
                                            @else
                                            <p>No files yet</p>
                                            @endif
                                        </td>
                                        <td>{{ explode(' ',$idea['created_at'])[0] }}</td>
                                        <td><label class="badge {{$status_color}}">{{ $status }}</label></td>
                                        <td>{{ $category }}</td>
                                        <td style="display:Flex;">
                                            {!! Form::open([
                                            'method'=>'GET',
                                            'url' => ['/admin/ideaView',$idea->idea_id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-eye"></i>',
                                            ['type' => 'submit',
                                            'class' => 'btn btn-info mr-1'
                                            ]) !!}
                                            {!! Form::close() !!}
                                            {{-- For certificate view --}}
                                            @if($idea->certificate == '1')
                                            {!! Form::open([
                                            'method'=>'GET',
                                            'url' => ['admin/rewards/view',$idea->idea_id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa-solid fa-file"></i>',
                                            ['type' => 'submit',
                                            'class' => 'btn btn-info btn-orange',
                                            'data-toggle' => 'tooltip',
                                            'data-placement' => 'top',
                                            'title' => 'View Idea Certificate'
                                            ]) !!}
                                            {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                    @php $srno++; @endphp
                                    @endforeach
                                    @else
                                    <h1>Ideas not posted yet!</h1>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" aria-labelledby="imagesModallLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- w-100 class so that header
            div covers 100% width of parent div -->
                    <h5 class="modal-title w-100" id="imagesModallLabel">
                        Idea Images
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x
                        </span>
                    </button>
                </div>
                <!--Modal body with image-->
                <div class="modal-body">
                    <div style="display:grid;grid-template-columns: auto auto auto auto;grid-gap:10px">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('public/backend-assets/vendors/js/datatables.min.js') }}">
</script>
<script src="{{ asset('public/backend-assets/vendors/js/dataTables.bootstrap4.min.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
</script>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#tbl-datatable thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#tbl-datatable thead');

        var table = $('#tbl-datatable').DataTable({
            orderCellsTop: true
            , fixedHeader: true
            , initComplete: function() {
                var api = this.api();

                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        if (title == 'Submitted On') {
                            $(cell).html('<input type="date" placeholder="' + title + '" />');
                        } else {
                            $(cell).html('<input type="text" placeholder="' + title + '" />');
                        }
                        // On every keypress in this input
                        $(
                                'input'
                                , $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                            .off('keyup change')
                            .on('change', function(e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                        regexr.replace('{search}', '(((' + this.value + ')))') :
                                        ''
                                        , this.value != ''
                                        , this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function(e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            }
        , });
        //console.log(role);
        minDateFilter = "";
        maxDateFilter = "";

        $("#daterange").daterangepicker();
        $("#daterange").on("apply.daterangepicker", function(ev, picker) {
            minDateFilter = Date.parse(picker.startDate);
            maxDateFilter = Date.parse(picker.endDate);
            
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var date = Date.parse(data[5]);

                if (
                    (isNaN(minDateFilter) && isNaN(maxDateFilter)) ||
                    (isNaN(minDateFilter) && date <= maxDateFilter) ||
                    (minDateFilter <= date && isNaN(maxDateFilter)) ||
                    (minDateFilter <= date && date <= maxDateFilter)
                ) {
                    return true;
                }
                return false;
            });
            table.draw();
        });
    });

    $(document).on("click", ".images_modal_class", function () {
            $('#imagesModal').on('hidden.bs.modal', function () {
            $('#imagesModal .modal-body div').empty();
        });
        var idea_uni_id = $(this).data('id');
        // console.log(idea_uni_id);
            if (idea_uni_id != "") {
                let csrf = '<?php echo csrf_token(); ?>';
                var data = {
                    '_token': csrf,
                    'idea_uni_id': idea_uni_id
                }
                $.ajax({
                    type: 'POST',
                    url: '{{ url('idea/ajax_get_images_modal') }}',
                    data: data,
                    success: function(data) {
                       $('.modal-body div').append(data);
                       $('#imagesModal').modal('show');
                    }
                });
            } 
        });

</script>
@endsection