@extends('frontend.layouts.app')
@section('title','Change Role')
@section('content')


<!-- login -->
<section class="container-fluidcustom top-padding login-page">
    <div class="container-fluid">
        <div class="card-body">
      
 
                        <form class="login-form form-field" action="{{ url('/users/updaterole') }}" method="post"
                          enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input name="user_id" type="hidden" value="{{Auth::user()->user_id}}">

                          {{-- {{dd(Auth()->user()->sub_role_final)}} --}}
                
                          <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('role', 'User Role *') }}
                                    {!! Form::select('role',$role ,
                                   Auth::user()->sub_role_final, ['class' => 'form-control ','id'=>'role']) !!}
                                </div>
                            </div>
                          </div>


                          <div class="form-group mb-0 col-md-12 terms-conditions-size pt-0">
                            <button type="submit" class="btn-sm  btn-block  text-center ">Update</button>
                          </div>
       
                        </div>
                              
        </div>
  </div>
</section>

<!-- login end-->






@endsection