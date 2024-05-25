@if(count($errors))
<div class="form-group">
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li id="error_message">{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
