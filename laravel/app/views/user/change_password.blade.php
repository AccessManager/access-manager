@extends('user.header_footer')
@section('user_title')
Change Password
@stop

@section('user_container')
	
	<div class="row">
	<div class="col-lg-7 col-lg-offset-1">

{{Form::open(['route'=>['user.change.password'],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('user_id', Auth::id())}}
<fieldset>
  
  <div class="form-group">
      {{Form::label('current', 'Current Password', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::password('current', ['class'=>'form-control','id'=>'current','placeholder'=>'your current password'])}}
      </div>
  </div>
  <div class="form-group">
      {{Form::label('new', 'New Password', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
      	{{Form::password('password', ['class'=>'form-control','id'=>'new','placeholder'=>'choose a new password'])}}
      </div>
  </div>
  <div class="form-group">
      {{Form::label('confirm', 'Confirm Password', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
      	{{Form::password('confirm_password', ['class'=>'form-control','id'=>'confirm','placeholder'=>'confirm new password'])}}
      </div>
  </div>
    
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-6">
        {{Form::buttons()}}
      </div>
    </div>
    {{Form::close()}}
</fieldset>
</div>
</div>

@stop