@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Edit user</title>
@stop

@section('content')
 <div class="row">
<div class="col-md-12">
<h2>Edit User</h2>  
<h5>Edit existing user </h5>
</div>
</div> 
<hr />

<div class="row">
	<div class="col-md-12">
	<!-- Advanced Tables -->
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $userdata->name }}












				<div style="float:right">
	<!-- <a href="#" class="btn btn-default btn-xs">Edit</a> -->
	<a href="{{ URL::to('admin/users')}}" class="btn btn-default btn-xs">back</a>
@if($companydata->verified == 0)
    <a onclick="user_operations({{ $userdata->active}},{{ $userdata->superuser}},1)" class="btn btn-success btn-xs">Verify</a>
@else
    <a onclick="user_operations({{ $userdata->active}},{{ $userdata->superuser}},0)" class="btn btn-danger btn-xs">Cancel verification</a>
@endif

@if($userdata->active == 0)
<a onclick="user_operations(1,{{ $userdata->superuser}},{{ $companydata->verified}})" class="btn btn-success btn-xs">Activate</a>
@else
<a onclick="user_operations(0,{{ $userdata->superuser}},{{ $companydata->verified}})" class="btn btn-danger btn-xs">Deactivate</a>
@endif

@if($userdata->superuser == 0)
<a onclick="user_operations({{ $userdata->active}},1,{{ $companydata->verified}})" class="btn btn-success btn-xs">Make Superuser</a>
@else
<a onclick="user_operations({{ $userdata->active}},0,{{ $companydata->verified}})" class="btn btn-danger btn-xs">Remove Superuser</a>
@endif			
        </div>
			</div>
			<div class="panel-body">

{{ Form::open( array('route' => array('admin.users.update', $userdata->id),'method' => 'put')) }}


@if (  $errors && $errors->first('name'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('name')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('name', Input::old('name',$userdata->name), 
      array('placeholder' => 'Name', 'class'=>'form-control')) }}
</div>

@if (  $errors && $errors->first('email'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('email')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"></span>
{{ Form::text('email', Input::old('email',$userdata->email), 
      array('placeholder' => 'Email', 'class'=>'form-control')) }}
</div>

 <div class="form-group input-group">

<div class="checkbox">
    <label>
&nbsp;&nbsp;<input id="reset_pwd" name="reset_pwd" onclick="pwd_show();" type="checkbox" }} > Reset password
    </label>
</div>

</div>

@if (  $errors && $errors->first('password'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('password')}}</label>
  <div class="form-group input-group has-error pwd">
@else
  <div class="form-group input-group pwd">
@endif
 <span class="input-group-addon"></span>
{{ Form::password('password',  
      array('placeholder' => 'password', 'class'=>'form-control')) }}
</div>

@if (  $errors && $errors->first('password_again'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('password_again')}}</label>
  <div class="form-group input-group has-error pwd">
@else
  <div class="form-group input-group pwd">
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
{{ Form::text('mobile', Input::old('mobile',$userdata->mobile), 
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
{{ Form::text('company_name', Input::old('company_name',$companydata->company_name), 
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
{{ Form::text('designation', Input::old('designation',$companydata->designation), 
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
{{ Form::text('company_email', Input::old('company_email',$companydata->company_email), 
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
{{ Form::text('trade_license_number', Input::old('trade_license_number',$companydata->trade_license_number), 
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
{{ Form::file('profile_image', $companydata->image, 
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
<script type="text/javascript">
$(document).ready(function(){
    pwd_show();
});

function pwd_show()
{
  if($("input:checkbox[name=reset_pwd]:checked").val()=="on")
  {
    $(".pwd").show();
  }
  else
  {
    $(".pwd").hide();
  }
}


function user_operations(active,superuser,verified)
{
  /* -- Ajax request--*/
 $.ajax({
     type:"POST",
     url:"{{ URL::to('admin/users/operations',$userdata->id) }}",
     data: {
            'active'         : active, 
            'superuser'      : superuser,
            'verified'       : verified
     },
     success: function(json_obj){
        if (json_obj['status'] == "success")
        { 
            // $("#row"+item_id).html("<td class='alert'></td><td class='alert'></td><td class='alert'><td class='alert'><td class='alert'></td><td class='alert'>Deleted</td>");
            location.reload();
            return;
        }
        else
        {
           // $("#btn"+item_id).html("<a class='errorlist'>Error</a>");
           //  return;
            alert("unexpected error");
            return;
        }
    }
});
}

</script>
@stop

@section('sidebar')
 @include('layouts.sidebar', array('page' => 'user_mgmt'))
@stop