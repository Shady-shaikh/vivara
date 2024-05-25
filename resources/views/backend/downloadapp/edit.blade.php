@extends('backend.layouts.app')
@section('title', 'Edit Download App Image')

@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Edit Download App Image</h5>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Edit
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section id="multiple-column-form">
          <div class="row match-height">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <a href="{{ route('admin.downloadapp') }}" class="btn btn-outline-secondary mr-1 mb-1 float-right"><i class="bx bx-arrow-back"></i><span class="align-middle ml-25">Back</span></a>
                  <h4 class="card-title">Edit Download App Image</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    @include('backend.includes.errors')
                    {!! Form::model($downloadapp_image, [
                        'method' => 'POST',
                        'url' => ['admin/downloadapp/update'],
                        'class' => 'form',
                        'enctype' => 'multipart/form-data'
                    ]) !!}
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-12 col-12">
                            <div class="form-group">
                              {{ Form::hidden('frontend_image_id', $downloadapp_image->downloadapp_id) }}
                              {{ Form::label('image_url', 'Image *') }}
                              <div class="custom-file">
                                {{ Form::file('image_url', ['class' => 'custom-file-input','id'=>'image_url']) }}
                                <label class="custom-file-label" for="image_url">Choose file</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12 col-12">
                            <div class="form-group">
                              {{ Form::label('url', 'Image Url *') }}
                              {{ Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Enter Image path Url', 'required' => true]) }}
                            </div>
                          </div>
                          @if(isset($downloadapp_image->image_url))
                            <div class="col-xl-3 col-md-3 img-top-card">
                              <div class="card widget-img-top">
                                <div class="card-content">
                                  <img class="card-img-top img-fluid mb-1" src="{{ asset('public/backend-assets/uploads/downloadapp_image/') }}/{{ $downloadapp_image->image_url }}" alt="{{$downloadapp_image->image_name}} Image">
                                </div>
                              </div>
                            </div>
                          @endif
                          <div class="col-12 d-flex justify-content-start">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary mr-1 mb-1')) }}
                          </div>
                        </div>
                      </div>
                    {{ Form::close() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <script>
      $(document).ready(function()
      {
        // if ($(".category").val() != '')
        // {
        //   subcategories($(".category").val());
        // }
        $(".category").change(function(){
          var category_id = $(this).val();
          subcategories(category_id);
        });
        $(".subcategory").change(function(){
          var subcategory_id = $(this).val();
          var category_id = $(".category").val();
            console.log(subcategory_id);
          subsubcategories(category_id,subcategory_id);
        });
        $(".subsubcategory").change(function(){
          
          $('.hsncode_id').html('');
          $('.material_id').trigger('change');
        });
        $(".material_id").change(function(){
          var material_id = $(this).val();
          var sub_subcategory_id = $(".subsubcategory").val();
          var subcategory_id = $(".subcategory").val();
          var category_id = $(".category").val();
          // console.log(subcategory_id);
          if (material_id && sub_subcategory_id && subcategory_id && category_id) 
          {
            hsncodes(category_id,subcategory_id,sub_subcategory_id,material_id);
          }
          
        });
        function subcategories(category_id)
        {
          $.ajax({
              url: '{{url("admin/products/getsubcategory")}}',
              type: 'post',
              data:
              {
                category_id: category_id ,_token: "{{ csrf_token() }}",
              },
              success: function (data)
              {
                //console.log(data);
                $('.subcategory').html(data);
                $('.subsubcategory').html('');
                $('.hsncode_id').html('');
              }
           });
        }
        function subsubcategories(category_id,subcategory_id)
        {
          $.ajax({
              url: '{{url("admin/products/getsubsubcategory")}}',
              type: 'post',
              data:
              {
                category_id: category_id, subcategory_id: subcategory_id, _token: "{{ csrf_token() }}",
              },
              success: function (data)
              {
                //console.log(data);
                $('.subsubcategory').html(data);
                $('.hsncode_id').html('');
                $('.material_id').trigger('change');
              }
           });
        }
        function hsncodes(category_id,subcategory_id,sub_subcategory_id,material_id)
        {
          $.ajax({
              url: '{{url("admin/products/gethsncodes")}}',
              type: 'post',
              data:
              {
                category_id: category_id, subcategory_id: subcategory_id,
                sub_subcategory_id : sub_subcategory_id, material_id : material_id,
                 _token: "{{ csrf_token() }}",
              },
              success: function (data)
              {
                //console.log(data);
                $('.hsncode_id').html(data);
              }
           });
        }
        $("#product_type").change(function()
        {
          var product_type = $(this).val();
          var product_sku = $("#product_sku").val();
          var product_price = $("#product_price").val();
          // console.log(product_type);
          if(product_type !='' && product_sku !='' && product_price !='')
          {
            productconfiguration(product_type,product_sku);
          }
        });
        $("#product_sku").change(function()
        {
          var product_sku = $(this).val();
          var product_type = $("#product_type").val();
          var product_price = $("#product_price").val();
          // console.log(product_type);
          if(product_type !='' && product_sku !='' && product_price !='')
          {
            productconfiguration(product_type,product_sku);
          }
        });
        $("#product_price").change(function()
        {
          var product_sku = $("#product_sku").val();
          var product_type = $("#product_type").val();
          var product_price = $(this).val();
          // console.log(product_type);
          if(product_type !='' && product_sku !='' && product_price !='')
          {
            productconfiguration(product_type,product_sku);
          }
        });
        function productconfiguration(product_type,product_sku)
        {
          // alert('in');
          if (product_type == 'configurable')
          {
            $('#config_color_div').show();
            $('#config_size_div').show();
            $('#variantsdiv').show();
            $('#config_product_qty').hide();
            $('#sim_color_div').hide();
            $('#sim_size_div').hide();
          }
          else
          {
            $('#config_color_div').hide();
            $('#config_size_div').hide();
            $('#variantsdiv').hide();
            $('#variantstable').html('');
            $('#sim_color_div').show();
            $('#sim_size_div').show();
            $('#config_product_qty').show();
          }
        }

        $("#config_color_id").change(function()
        {
          var color_id = $(this).val();
          var size_id = $("#config_size_id").val();
          var product_type = $("#product_type").val();
          var product_sku = $("#product_sku").val();
          var product_price = $("#product_price").val();
          // console.log(color_id);
          if(color_id !='' && product_type !='' && product_sku !='' && product_price !='')
          {
            getproductvariants(color_id,size_id,product_type,product_sku,product_price);
          }
        });
        $("#config_size_id").change(function()
        {
          var size_id = $(this).val();
          var color_id = $("#config_color_id").val();
          var product_type = $("#product_type").val();
          var product_sku = $("#product_sku").val();
          var product_price = $("#product_price").val();
          // console.log(color_id);
          if(color_id !='' && product_type !='' && product_sku !='' && product_price !='')
          {
            getproductvariants(color_id,size_id,product_type,product_sku,product_price);
          }
        });
        function getproductvariants(color_id,size_id,product_type,product_sku,product_price)
        {
          if (product_type == 'configurable')
          {
            $.ajax({
                url: '{{url("admin/products/getproductvariants")}}',
                type: 'post',
                data:
                {
                  color_id: color_id, size_id: size_id,product_type: product_type,
                  product_sku: product_sku,product_price: product_price, _token: "{{ csrf_token() }}",
                },
                success: function (data)
                {
                  //console.log(data);
                  $('#variantsdiv').show();
                  $('#variantstable').html(data);
                  $('#sim_color_div').hide();
                  $('#sim_size_div').hide();
                  $('#config_product_qty').hide();
                }
             });
          }
          else
          {
            $('#variantsdiv').hide();
            $('#variantstable').html('');
            $('#config_color_div').hide();
            $('#config_size_div').hide();
            $('#sim_color_div').show();
            $('#sim_size_div').show();
            $('#config_product_qty').show();
          }
        }

        $("#manufacturer_id").change(function(){
          var manufacturer_id = $(this).val();
          brands(manufacturer_id);
        });

        function brands(manufacturer_id)
        {
          $.ajax({
              url: '{{url("admin/products/getbrands")}}',
              type: 'post',
              data:
              {
                manufacturer_id: manufacturer_id ,_token: "{{ csrf_token() }}",
              },
              success: function (data)
              {
                //console.log(data);
                $('#brand_id').html(data);
              }
           });
        }

        //product discount price calculation
        $("#product_price,#product_discount,#product_discount_type").change(function()
        {
          var product_price = $("#product_price").val();
          var product_discount = $("#product_discount").val();
          var product_discount_type = $("#product_discount_type").val();
          // console.log(product_discount);
          var product_discounted_price = 0;
          if(product_price !='' && product_discount !='')
          {
            if (product_discount_type=='percent')
            {
              product_discounted_price = product_price - ((product_price*product_discount)/100);
            }
            else
            {
              product_discounted_price = product_price - product_discount;
            }

            if (product_discounted_price <= 0)
            {
              alert('Product Discount cannot be greater than or equals to Product Price');
              // alert('Product Discount Price cannot be less than or equals to Zero');
              $("#product_discounted_price").val('');
            }
            else
            {
              product_discounted_price = Math.round(product_discounted_price);
              $("#product_discounted_price").val(product_discounted_price);
            }
          }
          else if(product_price !='' && product_discount =='')
          {
            $("#product_discounted_price").val(product_price);
          }
          else
          {

          }
        });
      });
    </script>
@endsection
