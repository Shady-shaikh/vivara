@php
use App\Models\backend\Category;
@endphp
@extends('frontend.layouts.app')
@section('title', 'User Dashboard | Add Idea')

@section('content')

<style>
    #drop-area {
        border: 2px dashed #ccc;
        border-radius: 20px;
        width: 480px;
        font-family: sans-serif;
        margin: 100px auto;
        padding: 20px;
    }

    #drop-area.highlight {
        border-color: purple;
    }

    p {
        margin-top: 0;
    }

    .my-form {
        margin-bottom: 10px;
    }

    #gallery {
        margin-top: 10px;
    }

    #gallery img {
        width: 150px;
        margin-bottom: 10px;
        margin-right: 10px;
        vertical-align: middle;
    }

    .form-control:focus {
        color: inherit;
        background-color: #fff;
        border-color: #90b5e2;
        outline: 0;
        box-shadow: 0 0 0 2px rgba(32, 106, 196, 0.301) !important;
    }

    .form-group label {
        margin-bottom: 10px;
        font-weight: 600;
    }

    .change-btn {
        padding: 5px 15px;
    }

    .button {
        display: inline-block;
        padding: 10px;
        background: #ccc;
        cursor: pointer;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .button:hover {
        background: #ddd;
    }

    #fileElem {
        display: none;
    }

</style>
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

                <li class="breadcrumb-item active">Add</li>

            </ol>

        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="content-header row pt-3 pb-3">
        <div class="content-header-left col-md-6 col-6 col-sm-6">
            <h3 class="content-header-title">Add Idea</h3>
        </div>

        <div class="content-header-left col-sm-6 col-md-6 col-6">
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
                            {{ Form::open(['url' => url('/ideas/storeIdea'),'method'=>'POST','files' => true]) }}
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            {{ Form::label('title', 'Title *') }}
                                            {{ Form::text('title', null, ['class' => 'form-control',
                                            'placeholder' => 'Enter Title here', 'required' => true,'id'=>'title']) }}
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="dropzone-container form-group">
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
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('description', 'Description *') }}
                                                {{ Form::textarea('description', null, ['class' =>
                                            'form-control',
                                            'placeholder' => 'Describe your Idea here', 'rows'=>'4',
                                            'required'
                                            => true,'id'=>'description']) }}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('category_id', 'Select Category *') }}
                                                {!! Form::select('category_id',
                                                Category::pluck('category_name','category_id')->all(), null,
                                                ['class' => 'form-control', 'placeholder' => 'Select Category',
                                                'required' => true,'id'=>'category_id']) !!}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                            {{ Form::submit('Add', array('class' => 'btn btn-primary change-btn','id'=>'submit')) }}
                                            <button type="reset" class="btn btn-dark change-btn">Reset</button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                    <div id="selected-images" class="mt-4 row g-2 idea_imgaes_container">
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



<script type="text/javascript">
    $(document).ready(function() {
        $('#error_message').hide();
        if (window.File && window.FileList && window.FileReader) {
            $(".image-file").on("change", function(e) {
                $("#error_message").hide();
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
                        //$src_value = 
                        $("#selected-images").append(`
                        <div class="pip boxDiv col-lg-2 col-md-4 col-sm-6">
                            <div class="card border-0 shadow">
                                <div style="width:100%;height:150px;overflow:hidden;padding:15px 0px;">
                                    <img class="card-img-top prescriptions" src="${img_src}" alt="Image to upload" style="width:100%;height:100%;object-position:center;object-fit:contain">
                                </div>
                                <div class="card-body">
                                    <p style="text-overflow: ellipsis;overflow: hidden;width: 100%;white-space: nowrap;" class="card-text">${value.name}</p>
                                    <p class="btn btn-sm btn-danger cross-image remove">Remove</p>
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


{{-- <script>
    var imgUpload = document.getElementById('upload-img')
        , imgPreview = document.getElementById('img-preview')
        , imgUploadForm = document.getElementById('form-upload')
        , totalFiles
        , previewTitle
        , previewTitleText
        , img;

    imgUpload.addEventListener('change', previewImgs, true);

    function previewImgs(event) {
       
        totalFiles = imgUpload.files.length;

        if (totalFiles) {
            imgPreview.classList.remove('img-thumbs-hidden');
        }

        for (var i = 0; i < totalFiles; i++) {
            var fileName = imgUpload.files[i].name
            var patternFileExtension = /\.([0-9a-z]+)(?:[\?#]|$)/i;
            var fileExtension = (fileName).match(patternFileExtension);

            wrapper = document.createElement('div');
            wrapper.classList.add('wrapper-thumb');
            removeBtn = document.createElement("span");
            nodeRemove = document.createTextNode('x');
            removeBtn.classList.add('remove-btn');
            removeBtn.appendChild(nodeRemove);
            fileNameLabel = document.createElement("span");
            nodeFileNameLabel = document.createTextNode(fileName);
            fileNameLabel.classList.add('file_name_label');
            fileNameLabel.appendChild(nodeFileNameLabel);
            img = document.createElement('img');
            if (fileExtension[1] == 'doc') {
                img.src = '{{asset("/storage/app/public/uploads/asset/doc_old.png")}}';
} else if (fileExtension[1] == 'pdf') {
img.src = '{{asset("/storage/app/public/uploads/asset/pdf_old.png")}}';
} else {
img.src = URL.createObjectURL(event.target.files[i]);
}
img.classList.add('img-preview-thumb');
wrapper.appendChild(img);
wrapper.appendChild(removeBtn);
imgPreview.appendChild(wrapper);
wrapper.appendChild(fileNameLabel);

$('.remove-btn').click(function() {
$(this).parent('.wrapper-thumb').remove();
imgPreview.contains('.wrapper-thumb');
});

}


}

</script> --}}

@endsection
