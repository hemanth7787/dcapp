@extends('layouts.main')

@section('content')
<h1>Items</h1>
<ul>
	@foreach($items as $item)
	<li>{{{$item->name}}} -- {{{$item->detail}}}</li>
	@endforeach

</ul>
@stop