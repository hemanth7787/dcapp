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
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Active</th>
                                            <th>Supeuser</th>
                                        </tr>
                                    </thead>
                                    <tbody>

									@foreach ($data as $user)
									    <tr >
                                           <td > <a href="{{ URL::to('admin/users',$user->id) }}">{{ $user->name }}</a></td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td class="center">{{ $user->active }}</td>
                                            <td class="center">{{ $user->superuser }}</td>
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