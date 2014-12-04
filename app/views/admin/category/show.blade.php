@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : View category</title>
@stop

@section('content')
 <div class="row">
<div class="col-md-12">
<h2>View category</h2>   
<h5>Detailed view of a category</h5>
</div>
</div> 
<hr />

<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                   {{$item->name}}
<div style="float:right">

<a href="{{ URL::to('admin/category/'.$item->id.'/edit')}}" class="btn btn-primary btn-xs">Edit again</a>
    <a href="{{ URL::to('admin/category/create')}}" class="btn btn-primary btn-xs">Add New</a>


</div>
                   
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>param</th>
                                            <th>value</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr >
                                        <td >Category Id</td>
                                           <td  class="center">{{ $item->id }}</td>
                                           </tr>
                                         <tr >
                                            <td class="center">Category Name</td>
                                            <td class="center">{{ $item->name }}</td>
                                            </tr>
                                         <tr >

                                             <td class="center">Category Slug</td>
                                            <td class="center">{{ $item->slug }}</td>
                                            </tr>
                                         <tr >
                                         <td class="center">Parent Id</td>
                                            <td class="center">{{ $item->parent_id }}</td>
                                               </tr>
                                         <tr >
                                         <td class="center">Parent Slug</td>
                                            <td class="center">{{ $item->parent_slug }}</td>
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

@stop

@section('sidebar')
 @include('layouts.sidebar', array('page' => 'category'))
@stop