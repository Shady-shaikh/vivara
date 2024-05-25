@extends('backend.layouts.inner')
@section('title')
Gst
@stop

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Name</th><th>GST Percent</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $gst->gst_id }}</td> <td> {{ $gst->gst_name }} </td><td> {{ $gst->gst_percent }} </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
