@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Admin</title>
@stop

@section('content')
 <div class="row">
                    <div class="col-md-12">
                     <h2>Admin Dashboard</h2>   
                        <h5>Welcome  {{Auth::user()->name }}, Love to see you back. </h5>
                    </div>
                </div> 
                <hr />
<h1>hello world</h1>
@stop

@section('script')
@stop

@section('sidebar')
 @include('layouts.sidebar', array('page' => 'dashboard'))
@stop