@php
use App\Models\frontend\Ideas;
use App\Models\frontend\IdeaRevisionImages;
@endphp
@extends('frontend.layouts.app')
@section('title', 'User Dashboard | Idea Revisions')

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
    <div class="content-header row  pt-3 pb-3">
        <div class="content-header-left col-md-6 col-6">
            <h3 class="content-header-title">Idea Revisions</h3>

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


    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration" id="tbl-datatable">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Title</th>
                                            <th>File Uploaded</th>
                                            <th>Revision Date</th>
                                            <th>Revision Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($ideas) && count($ideas)>0)
                                        @php
                                        $srno = 1;
                                        @endphp
                                        @foreach($ideas as $idea)
                                        @php
                                        $image_path = $idea['image_path'];
                                        $full_image_path = 'storage/app/public/'.$image_path;
                                        $extArr = explode('.',$image_path);
                                        $ext = end($extArr);
                                        @endphp
                                        <tr>
                                            <td>{{ $srno }}</td>
                                            <td>{{ $idea->title }}</td>
                                            <td>
                                                @php
                                                $files = ideaRevisionImages::where('idea_uni_id',$idea->idea_uni_id)->whereNotNull('idea_uni_id')->get();
                                                // dd($idea->idea_uni_id);
                                                // foreach($files as $file) {
                                                // dd(asset('storage/app/public/'.$file->image_path));
                                                // }
                                                // dd($files->toArray());
                                                @endphp
                                                {{-- @if($image_path == '' || !isset($image_path))
                                                File Not Uploaded
                                                @else
                                                @if($ext == 'png')
                                                <img src="{{ asset('/storage/app/public/uploads/asset/png-icon.png') }}"
                                                alt="Image not available">
                                                @elseif($ext == 'jpg' || $ext == 'jpeg')
                                                <img src="{{ asset('/storage/app/public/uploads/asset/jpg-icon.png') }}" alt="Image not available">
                                                @elseif($ext == 'pdf')
                                                <a href="{{ asset($full_image_path) }}" target="_blanck"><img src="{{asset('/storage/app/public/uploads/asset/pdf-icon.png')}}" alt="Image not available"></a>
                                                @elseif($ext == 'doc' || $ext == 'docx')
                                                <a href="{{ asset($full_image_path) }}"><img src="{{asset('/storage/app/public/uploads/asset/doc-icon.png')}}" alt="Image not available"></a>
                                                @endif
                                                @endif --}}
                                                @if(count($files) > 0)
                                                <a href="#" class="images_modal_class" data-id="{{ $idea->idea_uni_id }}">{{count($files).' files'}}</a>
                                                @else
                                                <p>No files yet</p>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                $date = explode(' ' ,$idea->created_at);
                                                @endphp
                                                {{ $date[0] }}
                                            </td>
                                            <td>
                                                @php
                                                $date = explode(' ' ,$idea->created_at);
                                                @endphp
                                                {{ $date[1] }}
                                            </td>
                                            <td>
                                                <a href="{{ url('/ideas/viewIdeaRevision',$idea->idea_revision_id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                        $srno++;
                                        @endphp
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" aria-labelledby="imagesModallLabel" aria-hidden="true">
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

</div>

@endsection
@section('scripts')

<script src="{{ asset('public/backend-assets/vendors/js/datatables.min.js') }}">
</script>
<script src="{{ asset('public/backend-assets/vendors/js/dataTables.bootstrap4.min.js') }}">
</script>
<script>
    $(document).on("click", ".images_modal_class", function() {
        $('#imagesModal').on('hidden.bs.modal', function() {
            $('#imagesModal .modal-body div').empty();
        });
        var idea_uni_id = $(this).data('id');
        // console.log(idea_uni_id);
        if (idea_uni_id != "") {
            let csrf = '<?php echo csrf_token(); ?>';
            var data = {
                '_token': csrf
                , 'idea_uni_id': idea_uni_id
            }
            $.ajax({
                type: 'POST'
                , url: '{{ url('idea/ajax_get_idea_revision_images_modal') }}'
                , data: data
                , success: function(data) {
                    // console.log(data);
                    $('.modal-body div').append(data);
                    $('#imagesModal').modal('show');
                }
            });
        }
    });

</script>
@endsection
