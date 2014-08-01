@extends('admin.settings.setting')
@section('title')
SMTP
@stop
<?php
// $hidden = NULL;
if($smtp->status == 1) {
  $hidden = NULL;
} else {
  $hidden = 'hidden';
}
?>
@section('settings_container')

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li>
    {{link_to_route('setting.email.form','Notifications')}}
  </li>
  <li class="active">
    {{link_to_route('setting.smtp.form','SMTP Config')}}
  </li>
</ul>

<div class="row">
  <div class="col-lg-7 col-lg-offset-1">

{{Form::model($smtp,['route'=>['setting.smtp'],'class'=>'form-horizontal','role'=>'form'])}}

{{Form::hidden('id',$smtp->id)}}
{{Form::hidden('status',0)}}
<fieldset>
  <div class="form-group">
      {{Form::label('status', 'Enable', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::checkbox('status', 1, false, ['class'=>'checkbox','id'=>'status'])}}
      </div>
  </div>
    <div class="form-group {{$hidden}} smtp">
      {{Form::label('email', 'Email Address', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('email', NULL, ['class'=>'form-control','id'=>'email','placeholder'=>'email address to be used'])}}
      </div>
  </div>
  <div class="form-group {{$hidden}} smtp">
      {{Form::label('name', 'Name', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('name', NULL, ['class'=>'form-control','id'=>'name','placeholder'=>'give a name to send emails as ...'])}}
      </div>
  </div>
  <div class="form-group {{$hidden}} smtp">
      {{Form::label('username', 'Username', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('username', NULL, ['class'=>'form-control','id'=>'username','placeholder'=>'username required to login to SMTP server'])}}
      </div>
  </div>
  <div class="form-group {{$hidden}} smtp">
      {{Form::label('password', 'Password', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('password', NULL, ['class'=>'form-control','id'=>'password','placeholder'=>'password required to login to SMTP server'])}}
      </div>
  </div>
  <div class="form-group {{$hidden}} smtp">
      {{Form::label('smtp', 'SMTP Host', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('host', NULL, ['class'=>'form-control','id'=>'smtp','placeholder'=>'name of your SMTP Host'])}}
      </div>
  </div>
  <div class="form-group {{$hidden}} smtp">
      {{Form::label('port', 'Port Number', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('port', NULL, ['class'=>'form-control','id'=>'smtp','placeholder'=>'port number to connect to your SMTP Host','id'=>'port'])}}
      </div>
  </div>
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-5">
        {{Form::buttons()}}
      </div>
    </div>
    {{Form::close()}}
</fieldset>
  </div> <!-- ends col-lg-7 -->
</div> <!-- ends row -->
			

@stop