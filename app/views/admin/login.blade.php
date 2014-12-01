<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

 @include('layouts.common-css')

<title>Login : Dubai Chamber of Commerce </title>


</head>
<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <h2> DC : Login</h2>
               
                <h5>( Login yourself to get access )</h5>
                 <br />
            </div>
        </div>
         <div class="row ">
               
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>   Enter Details To Login </strong>  
                            </div>
                            <div class="panel-body">
                                {{ Form::open(array('url' => 'admin/login')) }}
                                   <!--     <br /> -->
                                        <!-- if there are login errors, show them here -->

@if (  isset($general_error)  )
  <label class="control-label has-error" style="color:#a94442">{{$general_error}}</label>
@endif

@if (  $errors && $errors->first('username'))
  <label class="control-label has-error" style="color:#a94442">{{$errors->first('username')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif

       

              <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>


      {{ Form::text('username', Input::old('username'), 
      array('placeholder' => 'Your Username', 'class'=>'form-control')) }}
      <!-- <input type="text" class="form-control" placeholder="Your Username " /> -->
              </div>
@if (  $errors && $errors->first('password'))
  <label class="control-label has-error" style="color:#a94442">{{$errors->first('password')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
                  <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
      {{ Form::password('password',  
      array('placeholder' => 'Your Password', 'class'=>'form-control')) }}
                 <!--  <input type="password" class="form-control"  placeholder="Your Password" /> -->
              </div>
          <div class="form-group">
                  <label class="checkbox-inline">
                      <input type="checkbox" name="persist"/> Remember me
                  </label>
                  <span class="pull-right">
                         <a href="#" >Forgot password ? </a> 
                  </span>
              </div>
              @if (Auth::user())
              <p>already logged in as  {{Auth::user()->username }}. 
              <a href="/admin/logout">logout ?</a></p>
          @else
          {{ Form::submit('Login Now',['class'=>'btn btn-primary']) }} 
          @endif
           
<!--            <a href="index.html" class="btn btn-primary ">Login Now</a> -->
         <!--  <hr />
          Not register ? <a href="registeration.html" >click here </a>  -->
        {{ Form::close() }}
  </div>
                           
                        </div>
                    </div>
                
                <!-- <a href="{{ URL::to('logout') }}">Logout</a> -->
        </div>
    </div>


     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
@include('layouts.common-js')
   
</body>
</html>
