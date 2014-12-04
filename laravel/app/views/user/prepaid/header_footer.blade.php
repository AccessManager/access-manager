@extends('user.header_footer')
@section('sub_header')
<?php
	$home = NULL;
	$recharge = NULL;
	$refill = NULL;
	$r_history = NULL;
	$s_history = NULL;

	$segment = Request::segment(2);

	Switch($segment) {
		case 'dashboard':
		case NULL :
			$home = 'active';
			break;
		case 'recharge' :
			$recharge = 'active';
			break;
		case 'refill' :
			$refill = 'active';
		break;
		case 'recharge-history' :
			$r_history = 'active';
			break;
		case 'session-history' :
			$s_history = 'active';
	}
?>
<div class="container">
		<ul class="nav nav-pills navbar-right">
		  <li class="{{$home}}">
		  	{{link_to_route('user.panel', 'Home')}}
		  </li>
		  <li class="{{$recharge}}">
		  	{{link_to_route('prepaid.recharge.form','Recharge')}}
		  </li>
		  <li class="{{$refill}}">
		  	{{link_to_route('prepaid.refill.form','Refill Account')}}
		  </li>
		  <li class="{{$r_history}}">
		  	{{link_to_route('prepaid.recharge.history', 'Recharge History')}}
		  </li>
		  <li class="{{$s_history}}">
			{{link_to_route('prepaid.session.history', 'Session History')}}
		  </li>
		</ul>
	<h2>
		@yield('user_title')
	</h2>
	<hr>

		@yield('user_container')

	</div>
@stop