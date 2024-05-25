@php
use App\Models\backend\Category;
use App\Models\frontend\IdeaImages;
@endphp
@extends('frontend.layouts.app')
@section('title', 'User Dashboard | Edit Idea')

@section('content')


<div class="container-fluid">

    <div class="row breadcrumbs-top mt-3">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('ideas.index') }}">My Ideas</a>
                </li>

                <li class="breadcrumb-item active">Edit</li>

            </ol>
        </div>
    </div>
</div>


<div class="container-fluid">

    <div class="content-header row  pt-3 pb-3">
        <div class="content-header-left col-md-6 col-6">
            <h3 class="content-header-title">Edit Idea</h3>

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
            @include('frontend.includes.errors')
             <div id="error_message" class="form-group">
                <div class="alert alert-danger">
                    <ul>
                        <li></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            {{
                            Form::model($idea,[
                            'method' => 'POST',
                            'url' => ['ideas/update'],
                            'files'=> true
                            ])
                            }}
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            {{ Form::hidden('idea', $idea->idea_id, ['class' =>
                                            'form-control']) }}
                                            {{ Form::label('title', 'Title *') }}
                                            {{ Form::text('title', null, ['class' => 'form-control',
                                            'placeholder' => 'Enter Title here', 'required' => true]) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('description', 'Description *') }}
                                            {{ Form::textarea('description', null, ['class' =>
                                            'form-control', 'placeholder' => 'Describe your Idea here',
                                            'rows'=>'4', 'required' => true]) }}
                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('category_id', 'Select Category *') }}
                                            {!! Form::select('category_id',
                                            Category::pluck('category_name','category_id')->all(), null,
                                            ['class' => 'form-control', 'placeholder' => 'Select Category',
                                            'required' => true]) !!}
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4 col-12">
                                        <div class="dropzone-container">
                                            <label for="files">Upload your file here</label>
                                            <span style="color:#777">(only png, jpeg, jpg, doc, and pdf files are
                                                allowed)</span>
                                            <div class="drop-zone">
                                                <span class="drop-zone__prompt">Drop file here or click to upload</span>
                                                <input type="file" name="image" class="drop-zone__input">
                                            </div> --}}
                                    {{-- {{ asset('storage/app/public/'.$idea['image_path']) }} --}}
                                    {{--
                                        </div>
                                    </div> --}}
                                    <div class="col-12 col-sm-4 col-md-4">
                                        <div class="dropzone-container">
                                            <label for="files">Upload your file here <span style="color:#777">(only png,
                                                    jpeg, jpg, doc, and pdf files are
                                                    allowed)</span></label>
                                            <div class="drop-zone">
                                                {{-- <span class="drop-zone__prompt d-inline-block my-1">Drop file here
                                                    or click to upload</span>
                                                <input type="file" class="form-control" name="images[]" multiple
                                                    id="upload-img" /> --}}
                                                <input type="file" class="form-control image-file" multiple="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col md-12">
                                        {{ Form::submit('Update', array('class' => 'btn btn-primary mr-1
                                        mb-1','id'=>'submit')) }}
                                        <button type="reset" class="btn btn-dark mr-1 mb-1">Reset</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                                <fieldset style="border-color: #12c712;display:none;padding:2.3em;margin:1em 0px;">
                                    <legend style="font-size:1.3em">Preview</legend>
                                    <div id="selected-images" class="row g-2">
                                    </div>
                                </fieldset>
                                @php
                                $images = IdeaImages::where('idea_uni_id',$idea->idea_uni_id)->get();
                                // dd($images);
                                @endphp
                                @if(count($images) > 0)
                                <fieldset style="border-color: #206bc4;padding:2.3em;margin:1em 0px;">
                                    <legend style="font-size:1.3em">Uploaded Files</legend>
                                    <div id="uploaded_images" class="row g-2">
                                        @foreach($images as $image)
                                        @php
                                        // dd($image);
                                        $img_path = '';
                                        $label_text = '';
                                        $file_path = asset('storage/app/public/' . $image->image_path);
                                        $fileNameParts = explode('.', $image->file_name);
                                        $ext = end($fileNameParts);
                                        // dd($ext);
                                        if($ext == 'doc' || $ext == 'docx') {
                                        $img_path = asset('storage/app/public/uploads/asset/doc.png');
                                        } elseif ($ext == 'pdf'){
                                        $img_path = asset('storage/app/public/uploads/asset/pdf.png');
                                        } else {
                                        $img_path = asset('storage/app/public/' . $image->image_path);
                                        }
                                        @endphp
                                        <div class="col-lg-2 col-md-4 col-sm-6">
                                            <div class="card border-0 shadow">
                                                <div style="width:100%;height:150px;overflow:hidden;padding:15px 0px;">
                                                    <img class="card-img-top" src="{{$img_path}}" alt="Card image cap" style="width:100%;height:100%;object-position:center;object-fit:contain">
                                                </div>
                                                <div class="card-body">
                                                    <p style="text-overflow: ellipsis;overflow: hidden;width: 100%;white-space: nowrap;" class="card-text">{{ $image->file_name }}</p>
                                                    <a href="{{route('ideas.delete_image',['id'=>$image->image_id])}}" class="btn btn-sm btn-danger cross-image
                                                        remove" style="margin:5px 8px 5px 0px;" onclick="return confirm('Are you sure you want to delete this File')">Remove</a>
                                                    @if($ext == 'doc' || $ext == 'pdf' || $ext == 'docx')
                                                    <a style="margin:5px 5px 5px 0px;" href="{{$file_path}}" class="btn btn-sm btn-primary {{$ext == 'pdf' || $ext == 'doc' || $ext == 'docx'?'':'test-popup-link'}}" target="_blank">View</a>
                                                    @else
                                                    <a style="margin:5px 5px 5px 0px;" href="{{$img_path}}" class="btn btn-sm btn-primary test-popup-link">View</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                                @else
                                <div>
                                    <h2 class=" mt-4">Images not uploaded yet</h2>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
    </section>

</div>


@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#error_message').hide();
        if (window.File && window.FileList && window.FileReader) {

            $(".image-file").on("change", function(e) {
                $('#error_message').hide();
                var file = e.target.files
                    , imagefiles = $(".image-file")[0].files;
                var i = 0;
                $.each(imagefiles, function(index, value) {
                    var f = file[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var img_src;
                        fn_ext = f.name;
                        // Regular expression for file extension.
                        var patternFileExtension = /\.([0-9a-z]+)(?:[\?#]|$)/i;

                        //Get the file Extension 
                        var fn_ext = (fn_ext).match(patternFileExtension);
                        if (fn_ext[1] == 'doc' || fn_ext[1] == 'docx') {
                            img_src = '{{asset("storage/app/public/uploads/asset/doc.png")}}';
                        } else if (fn_ext[1] == 'pdf') {
                            img_src = '{{asset("storage/app/public/uploads/asset/pdf.png")}}';
                        } else if (fn_ext[1] == 'png' || fn_ext[1] == 'jpeg' || fn_ext[1] == 'jpg') {
                            img_src = e.target.result
                        } else {
                            $('#error_message li').empty();
                            $('.image-file').val('');
                            $("#error_message li").append(`Select the specified type of files`);
                            $("#error_message").show();
                            return;
                        }
                        $("#selected-images").parent('fieldset').addClass('d-block');
                        $("#selected-images").append(`
                        <div class="pip boxDiv col-lg-2 col-md-4 col-sm-6">
                            <div class="card border-0 shadow">
                                <div style="width:100%;height:150px;overflow:hidden;padding:15px 0px;">
                                    <img class="card-img-top prescriptions" src="${img_src}" alt="Image to upload" style="width:100%;height:100%;object-position:center;object-fit:contain">
                                </div>
                                <div class="card-body">
                                    <p style="text-overflow: ellipsis;overflow: hidden;width: 100%;white-space: nowrap;" class="card-text">${value.name}</p>
                                    <a style="margin:5px 5px 5px 0px;" class="btn btn-sm btn-danger cross-image remove">Remove</a>
                                </div>
                            </div>           
                            <input type="hidden" name="file[]" value="${e.target.result}">
                            <input type="hidden" name="fileName[]" value="${value.name}">
                        </div>`);
                        $(".remove").click(function() {
                            $(this).parent().parent().parent(".pip").remove();
                        });
                    });
                    fileReader.readAsDataURL(f);
                    i++;
                });
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });

</script>

<script>
    $('document').ready(function(e) {
        $('.upload-image').click(function(e) {
            var imageDiv = $(".boxDiv").length;
            if (imageDiv == '') {
                alert('Please upload image'); // Check here image selected or not
                return false;
            } else if (imageDiv > 5) {
                alert('You can upload only 5 images'); //You can select only 5 images at a time to upload
                return false;
            } else if (imageDiv != '' && imageDiv < 6) { // image should not be blank or not greater than 5
                $("#upload_image").submit();
            }
        });
    });

</script>

@endsection
