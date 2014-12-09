@extends('admin.settings.setting')
@section('title')
Direcpay
@stop
<?php
if($direcpay->status == 1) {
	$hidden = NULL;
} else {
	$hidden = 'hidden';
}
?>
@section('settings_container')

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
<li>
  {{link_to_route('setting.paypal','PayPal')}}
</li>
  <li class="active">
    {{link_to_route('setting.direcpay','Direcpay')}}
  </li>
</ul>

			<div class="row">
	<div class="col-lg-7 col-lg-offset-1">

{{Form::model($direcpay,['route'=>['setting.direcpay'],'class'=>'form-horizontal','role'=>'form'])}}

{{Form::hidden('id',$direcpay->id)}}
{{Form::hidden('status',0)}}
{{Form::hidden('sandbox', 0)}}
<fieldset>
  <div class="form-group">
      {{Form::label('status', 'Enable', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::checkbox('status', 1, false, ['class'=>'checkbox'])}}
      </div>
  </div>
    <div class="form-group smtp {{$hidden}}">
      {{Form::label('email', 'Merchant ID', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('mid', NULL, ['class'=>'form-control','id'=>'email','placeholder'=>'Your Merchant ID Here.'])}}
      </div>
  </div>
  <div class="form-group smtp {{$hidden}}">
      {{Form::label('email', 'Encryption Key', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('enc_key', NULL, ['class'=>'form-control','id'=>'email','placeholder'=>'Your Encryption Key Here.'])}}
      </div>
  </div>
  <div class="form-group smtp {{$hidden}}">
      {{Form::label('sandbox', 'Enable Sandbox', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::checkbox('sandbox', 1, false, ['class'=>'checkbox'])}}
      </div>
  </div>

<div class="form-group">
      <div class="col-lg-10 col-lg-offset-5">
        {{Form::buttons()}}
      </div>
    </div>
    {{Form::close()}}
</fieldset>

</div>
</div>
@stop