@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Users</title>
@stop

@section('content')
 <div class="row">
<div class="col-md-12">
<h2>User Details</h2>   
<h5>user details </h5>
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
<a href="#" class="btn btn-default btn-xs">Edit</a>
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr >
                                         <td class="center">Name</td>
                                         <td class="center">{{ $userdata->name }}</td>
                                        </tr>
                                        <tr >
                                         <td class="center">Username</td>
                                         <td class="center">{{ $userdata->username }}</td>
                                        </tr>
                                         <tr >
                                         <td class="center">Email</td>
                                         <td class="center">{{ $userdata->email }}</td>
                                        </tr>
                                                                                 <tr >
                                         <td class="center">Active</td>
                                         <td class="center">{{ $userdata->active }}</td>
                                        </tr>
                                         <tr >
                                         <td class="center">Superuser</td>
                                         <td class="center">{{ $userdata->superuser }}</td>
                                        </tr>
 <tr >
                                         <td class="center">Company name</td>
                                         <td class="center">{{ $userdata->profile->company_name }}</td>
                                        </tr> <tr >
                                         <td class="center">Company Email</td>
                                         <td class="center">{{ $userdata->profile->company_email }}</td>
                                        </tr> <tr >
                                         <td class="center">Designation</td>
                                         <td class="center">{{ $userdata->profile->designation }}</td>
                                        </tr>
                                         <tr >
                                         <td class="center">Membership Number</td>
                                         <td class="center">{{ $userdata->profile->membership_number }}</td>
                                        </tr>
                                        <tr >
                                         <td class="center">Trade license Number</td>
                                         <td class="center">{{ $userdata->profile->trade_license_number }}</td>
                                        </tr>
                                        <tr >
                                         <td class="center">Profile verified</td>
                                         <td class="center">{{ $userdata->profile->verified }}</td>
                                        </tr>
                                        <tr >
                                         <td class="center">Region</td>
                                         <td class="center">{{ $userdata->profile->region }}</td>
                                        </tr>

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
<script type="text/javascript">
function user_operations(active,superuser,verified)
{
  /* -- Ajax request--*/
 $.ajax({
     type:"POST",
     url:"{{ URL::to('admin/users/edit',$userdata->id) }}",
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