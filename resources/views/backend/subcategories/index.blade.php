@extends('backend.layouts.app')
@section('title', 'Sub Categories')

@section('content')
<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title">Sub Categories</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('admin.category') }}">Category Master</a>
        </li>

          <li class="breadcrumb-item active">Sub Categories</li>
        </ol>
      </div>
    </div>
  </div>
  <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
      <div class="btn-group" role="group">
        <a class="btn btn-outline-primary" href="{{ route('admin.subcategory.create',['id'=> $id]) }}">
          <i class="feather icon-plus"></i> Add
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
                    <th>Sub Category</th>
                    <th>Visibility</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($subcategories) && count($subcategories)>0)
                  @php $srno = 1; @endphp
                  @foreach($subcategories as $data)
                  <tr>
                    <td>{{ $srno }}</td>
                    <td>{{ $data->sub_category_name }}</td>
                    <td>
                        @if ($data->visibility == 1)
                                <span class="badge badge-primary">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if ($data->subcategory_details)
                        &nbsp; &nbsp; <a href="{{ url('admin/subcategorydetails/'.$data->sub_category_id) }}" class="btn btn-primary">Subcategory Details</a>
                        @endif

                        <a href="{{ url('admin/subcategory/edit/'.$data->sub_category_id) }}" class="btn btn-primary"><i class="feather icon-edit-2"></i></a>
                        <a href="{{ url('admin/subcategory/delete/'.$data->sub_category_id) }}" class="btn btn-danger" onclick = "return confirm('Are you sure you want to Delete this Entry ?')"> <i class="feather icon-trash"></i></a>

                        {{--  <!-- @can('Delete') -->
                        <!-- @endcan -->

                        {!! Form::open([
                        'method'=>'GET',
                        'url' => ['admin/subcategory/delete',$data->sub_category_id],
                        ]) !!}
                        {!! Form::button('<i class="feather icon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger','onclick'=>"return confirm('Are you sure you want to Delete this Entry ?')"]) !!}
                        {!! Form::close() !!}  --}}

                        </td>
                    <td>
                    </td>
                  </tr>
                  @php $srno++; @endphp
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
</section>

@endsection
@section('scripts')
<script src="{{ asset('public/backend-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('public/backend-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/backend-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
@endsection
