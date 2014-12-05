@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Create user</title>
@stop

@section('content')
 <div class="row">
<div class="col-md-12">
<h2>Create User</h2>  
<h5>Create new user </h5>
</div>
</div> 
<hr />

<div class="row">
	<div class="col-md-12">
	<!-- Advanced Tables -->
		<div class="panel panel-default">
			<div class="panel-heading">
				Create new User
				<div style="float:right">
	<!-- <a href="#" class="btn btn-default btn-xs">Edit</a> -->
	<a href="{{ URL::to('admin/users')}}" class="btn btn-default btn-xs">back</a>
				</div>
			</div>
			<div class="panel-body">

{{ Form::open(array('url' => 'admin/users')) }}


@if (  $errors && $errors->first('name'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('name')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('name', Input::old('name'), 
      array('placeholder' => 'Name', 'class'=>'form-control')) }}
</div>


@if (  $errors && $errors->first('username'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('username')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('username', Input::old('username'), 
      array('placeholder' => 'Username', 'class'=>'form-control')) }}
</div>


@if (  $errors && $errors->first('email'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('email')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('email', Input::old('email'), 
      array('placeholder' => 'Email', 'class'=>'form-control')) }}
</div>


@if (  $errors && $errors->first('password'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('password')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::password('password',  
      array('placeholder' => 'Password', 'class'=>'form-control')) }}
</div>


@if (  $errors && $errors->first('password_again'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('password_again')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::password('password_again',  
      array('placeholder' => 'Password Again', 'class'=>'form-control')) }}
</div>

@if (  $errors && $errors->first('mobile'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('mobile')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('mobile', Input::old('mobile'), 
      array('placeholder' => 'Mobile No:', 'class'=>'form-control')) }}
</div>
<hr />

@if (  $errors && $errors->first('company_name'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('company_name')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('company_name', Input::old('company_name'), 
      array('placeholder' => 'Company Name', 'class'=>'form-control')) }}
      </div>

@if (  $errors && $errors->first('designation'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('designation')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('designation', Input::old('designation'), 
      array('placeholder' => 'Designation', 'class'=>'form-control')) }}
      </div>


 @if (  $errors && $errors->first('company_email'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('company_email')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('company_email', Input::old('company_email'), 
      array('placeholder' => 'Company Email', 'class'=>'form-control')) }}
      </div>


@if (  $errors && $errors->first('trade_license_number'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('trade_license_number')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('trade_license_number', Input::old('trade_license_number'), 
      array('placeholder' => 'Trade License No:', 'class'=>'form-control')) }}
      </div>


@if (  $errors && $errors->first('profile_image'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('profile_image')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::file('profile_image', Input::old('profile_image'), 
      array('placeholder' => 'Profile Image', 'class'=>'form-control')) }}
      </div>

   

<div class="form-group input-group">
{{ Form::submit('Save',array('class'=>'btn btn-primary')) }} 
</div>
{{ Form::close() }}
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
@stop

@section('script')
@stop

@section('sidebar')
 @include('layouts.sidebar', array('page' => 'user_mgmt'))
@stop