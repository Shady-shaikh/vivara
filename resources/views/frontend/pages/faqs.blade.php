@extends('frontend.layouts.home')
@section('title','FAQs'." - Dadreeios Online Shopping Site")
@section('content')

<!-- Product details start -->
  <div class="container-fluidcustom top-padding ">
    <!-- <div class="images-box"> -->
      <div class="row pt-4">
        <div class=" col-md-12 col-sm-12 col-12">

          <h1>{{ $faqs->cms_pages_title }}</h1>

          <div class="">
            {!! $faqs->cms_pages_content !!}
          </div>

        </div>

     </div>
    <!-- </div> -->
 </div>
<!-- Product details end -->






@endsection
