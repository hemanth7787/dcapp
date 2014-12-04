@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Categories</title>
@stop

@section('content')
 <div class="row">
<div class="col-md-12">
<h2>Dynamic categories</h2>   
<h5>Add/Edit dynamic categories</h5>
</div>
</div> 
<hr />

<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                   Avaliable categories
<div style="float:right">

    <a href="{{ URL::to('admin/category/create')}}" class="btn btn-default btn-xs">Add New &nbsp;<i class="fa fa-plus-circle"></i></a>


</div>
                   
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>name</th>
                                            <th>slug</th>
                                            <th>parent id</th>
                                            <th>parent slug</th>
                                            <th>operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    @foreach ($categories as $category)
                                        <tr >
                                           <td > <a href="{{--  URL::to('admin/users',$user->id) --}}">{{ $category->id }}</a></td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td class="center">{{ $category->parent_id }}</td>
                                            <td class="center">{{ $category->parent_slug }}</td>
                                            <td class="center">
@if($category->parent_id != 0 )
<a href="{{ URL::to('admin/category/'.$category->id.'/edit')}}" class="btn btn-default btn-xs">Edit</a>&nbsp;
{{ Form::model($category, array('route' => array('admin.category.destroy', $category->id),'method' => 'delete','style'=>'display:inline')) }}
{{ Form::submit('Delete',array('class'=>'btn btn-danger btn-xs')) }} 
{{ Form::close() }}
@endif
                                            </td>
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
 @include('layouts.sidebar', array('page' => 'category'))
@stop