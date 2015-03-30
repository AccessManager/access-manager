@extends('admin.header_footer')
<?php
	$general = NULL;
	   $smtp = NULL;
	 $paypal = NULL;
$advancepaid = NULL;
$segment = Request::segment(3);
// echo $segment; exit;
switch($segment) {
	case 'general' :
	case 'themes' :
		$general = 'active';
			break;
	case 'smtp':
	case 'email':
		$smtp = 'active';
			break;
	case 'direcpay':
	case 'paypal':
		$paypal = 'active';
			break;
	case 'advancepaid':
	$advancepaid = 'active';
			break;
}
?>
@section('admin_container')
<div class="row">
	<div class="col-lg-6">
		<h2>
			<i class="fa fa-cogs"></i>
			@yield('title')
			Settings</h2>
	</div>
	<div class="col-lg-6">
		<ul class="nav nav-pills pull-right" style='margin-top: 25px;'>
  <li class="{{$general}}">
  	{{link_to_route('setting.general','General')}}
  </li>
  <li class="{{$smtp}}">
  	{{link_to_route('setting.email','Email')}}
  </li>
  <li class="{{$paypal}}">
  	{{link_to_route('setting.paypal','Payment Gateways')}}
  </li>
  <li class="{{$advancepaid}}">
  	{{link_to_route('setting.advancepaid.form','AdvancePaid Settings')}}
  </li>
  </ul>
	</div>
</div>
			<hr>
			@yield('settings_container')
@stop
