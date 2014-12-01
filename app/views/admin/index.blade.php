@extends('layouts.main')

@section('head')
<title>Dubai Chamber of Commerce : Admin</title>
@stop

@section('content')
<h1>hello world</h1>
@stop

@section('script')
@stop

@section('sidebar')
 @include('layouts.sidebar', array('page' => 'dashboard'))
@stop