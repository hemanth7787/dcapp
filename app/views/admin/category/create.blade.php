@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Categories</title>
@stop

@section('content')
 <div class="row">
<div class="col-md-12">
<h2>Add new category</h2>   
<h5>Create new dynamic category</h5>
</div>
</div> 
<hr />

<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                   Create new category
						<div style="float:right">
						<!-- <a href="#" class="btn btn-default btn-xs">Edit</a> -->

						    <a href="{{ URL::to('admin/category')}}" class="btn btn-default btn-xs">back</a>


						</div>
                   
                        </div>
                        <div class="panel-body">

{{ Form::open(array('url' => 'admin/category')) }}
@if (  $errors && $errors->first('name'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('name')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"><!-- <i class="fa fa-lock"  ></i> --></span>
{{ Form::text('name', Input::old('name'), 
      array('placeholder' => 'Category Name', 'class'=>'form-control')) }}
                 <!--  <input type="password" class="form-control"  placeholder="Your Password" /> -->
</div>

@if (  $errors && $errors->first('slug'))
  <label class="control-label has-error" 
  style="color:#a94442">{{$errors->first('slug')}}</label>
  <div class="form-group input-group has-error">
@else
  <div class="form-group input-group">
@endif
 <span class="input-group-addon"><!-- <i class="fa fa-lock"  ></i> --></span>
{{ Form::text('slug', Input::old('slug'), 
      array('placeholder' => 'Category Slug', 'class'=>'form-control')) }}
                 <!--  <input type="password" class="form-control"  placeholder="Your Password" /> -->
</div>

<!-- <div class="form-group">
                                            <label>Select Example</label>
                                            <select class="form-control">
                                                <option>One Vale</option>
                                                <option>Two Vale</option>
                                                <option>Three Vale</option>
                                                <option>Four Vale</option>
                                            </select>
                                        </div> -->
                                           <label>Parent category</label>
  <div class="form-group input-group">

 <span class="input-group-addon"><!-- <i class="fa fa-lock"  ></i> --></span>
{{ Form::select('parent_category', $categories, null,array('class'=>'form-control')) }}

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
 @include('layouts.sidebar', array('page' => 'category'))
@stop