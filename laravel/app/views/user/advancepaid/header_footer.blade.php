@extends('user.header_footer')
@section('sub_header')
<?php
		 $home = NULL;
	$s_history = NULL;

	$segment = Request::segment(2);
	switch($segment) {
		case 'dashboard':
		case NULL :
			$home = 'active';
			break;
		
		case 'session-history' :
			$s_history = 'active';
		break;
	}
?>
<div class="container">
		<ul class="nav nav-pills navbar-right">
		  <li class="{{$home}}">
		  	{{link_to_route('user.panel', 'Home')}}
		  </li>
		  <li class="{{$s_history}}">
			{{link_to_route('advancepaid.session.history', 'Session History')}}
		  </li>
		</ul>
	<h2>
		@yield('user_title')
	</h2>
	<hr>

		@yield('user_container')

	</div>
@stop