@extends('backend.layouts.app')
@section('title', 'Email Configuration')

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Email Configuration</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Email Configuration</li>
                </ol>
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
                        {!! Form::open([
                        'method'=>'POST',
                        'url' => ['admin/email_config/update'],

                        ]) !!}
                        <div class="table-responsive">
                            <table class="table zero-configuration" id="tbl-datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Team</th>
                                        <th>Emails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($emails) && count($emails)>0)
                                    @php
                                    $srno = 1;
                                    @endphp
                                    {{-- $emails_arr = array();
                                    $email_config_id_arr = array();
                                    $i = 0; --}}

                                    @foreach($emails as $data)

                                    <tr>
                                        <td>{{ $srno }}</td>
                                        <td>{{ $data->team }}</td>
                                        <td>
                                            {{-- @php
                                            $emails_arr[$i] = $data->emails;
                                            $email_config_id_arr[$i] = $data->email_config_id;
                                            @endphp --}}
                                            @csrf
                                            {{-- <input type="text" class="form-control" value="{{$data->emails}}" name="emails" data-role="tagsinput"> --}}
                                            {{ Form::text('emails_arr['.$loop->index.']', $data->emails, ['class' => 'form-control','data-role'=>'tagsinput']) }}
                                            {{-- <input type="hidden" name="emails_arr" value="{{$emails_arr}}[]"> --}}
                                            {{-- <input type="hidden" name="email_config_id" value="{{$data->email_config_id}}"> --}}
                                            {{ Form::hidden('email_config_id_arr['.$loop->index.']', $data->email_config_id, ['class' => 'form-control']) }}
                                            {{-- <input type="hidden" name="email_config_id_arr" value="{{$email_config_id_arr}}[]"> --}}
                                        </td>

                                    </tr>

                                    @php
                                    $srno++;
                                    @endphp
                                    {{-- $i++; --}}
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ Form::submit('Update', array('class' => 'btn btn-primary mr-1 mb-1 mt-4')) }}
                        <button type="reset" class="btn btn-dark mr-1 mb-1 mt-4">Reset</button>
                        {{ Form::close()  }}
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
<script>
    $('#tbl-datatable').DataTable({
        responsive: true
    });

</script>
@endsection
