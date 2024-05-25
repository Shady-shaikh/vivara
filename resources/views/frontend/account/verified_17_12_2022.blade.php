@extends('backend.layouts.fullempty')
@section('title', 'Forgot Password')
@section('content')
<style>
    body {
        display: flex;
        align-items: center;
        justify-items: center;
        justify-content: center;
    }

    .message_container h2 {
        margin-bottom: 20px;
    }

</style>
<div class="message_container">
    <h2>Your Email has been verified successfully</h2>
    <a class="btn btn-primary" href="{{ route('user.login') }}">Go to login page</a>
</div>
@endsection
