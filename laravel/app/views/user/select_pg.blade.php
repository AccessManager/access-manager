@extends('user.' . $planType . '.header_footer')
@section('user_title')
Recharge Online
@stop

@section('user_container')
<h3>
Select Payment Gateway
</h3>
<br>
<?php foreach($activeGateways as $gw): ?>
{{Form::open(['route'=>'initiate.online.recharge'])}}
	<button type='submit' name="gateway" value="{{$gw}}" class='btn btn-primary'>{{$gw}}</button>
{{Form::close()}}
<?php endforeach; ?>

@stop