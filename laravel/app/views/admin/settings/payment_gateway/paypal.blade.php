@extends('admin.settings.setting')
@section('title')
Paypal
@stop
<?php
if($paypal->status == 1) {
	$hidden = NULL;
} else {
	$hidden = 'hidden';
}
?>
@section('settings_container')

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li class="active">
    {{link_to_route('setting.paypal','Paypal')}}
  </li>
</ul>

			<div class="row">
	<div class="col-lg-7 col-lg-offset-1">

{{Form::model($paypal,['route'=>['setting.paypal'],'class'=>'form-horizontal','role'=>'form'])}}

{{Form::hidden('id',$paypal->id)}}
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
      {{Form::label('email', 'Email Address', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('email', NULL, ['class'=>'form-control','id'=>'email','placeholder'=>'email address to be used'])}}
      </div>
  </div>
  <div class="form-group smtp {{$hidden}}">
      {{Form::label('currency', 'Currency', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
      	{{Form::select('currency', $currencies, NULL, ['class'=>'form-control','id'=>'currency'])}}
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