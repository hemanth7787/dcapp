@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Admin</title>
@stop

@section('content')
 <div class="row">
<div class="col-md-12">
<h2>Manage Users</h2>   
<h5>Users are listed below. </h5>
</div>
</div> 
<hr />


  <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Users
                             <div style="float:right">

{{ Form::open( 
    array('route' => array('admin.users.index'),'method' => 'get')) }}
<label>Company</label>
{{ Form::select('company',array('0' => 'All')+$company_list, $default_company_filter) }}
&nbsp;
<label>Type</label>
{{ Form::select('superuser', array('2'=>'All','1'=>'Supeuser','0'=>'Normal'), $default_user_type_filter) }}
&nbsp;
<label>Status</label>
{{ Form::select('active', array('2'=>'All','1'=>'Active','0'=>'Disabled'), $default_user_status_filter) }}
&nbsp;
{{ Form::submit('Go',array('class'=>'btn btn-default btn-xs')) }} 
&nbsp;&nbsp;
 <a  href="{{ URL::to('admin/users/create')}}" class="btn btn-default btn-xs">Add New 
 &nbsp;<i class="fa fa-plus-circle"></i></a>
{{ Form::close() }}





</div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Active</th>
                                            <th>Supeuser</th>
                                            <th>Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>

									@foreach ($data as $key => $user)
									    <tr >
                                        <td > {{ $key+1 }}</td>
                                           <td > {{ $user->name }}</td>
                                            <td>{{ $user->profile->company_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td class="center">{{ $user->active }}</td>
                                            <td class="center">{{ $user->superuser }}</td>
                                            <td class="center"><a class="btn btn-default btn-xs" href="{{ URL::to('admin/users',$user->id) }}">View</a>&nbsp;
                                            <a href="{{ URL::to('admin/users/'.$user->id.'/edit')}}" class="btn btn-default btn-xs">Edit</a></td>
                                        </tr>
									@endforeach

                                    </tbody>
                                </table>
                            </div>
                            
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