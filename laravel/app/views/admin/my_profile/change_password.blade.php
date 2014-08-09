@extends('admin.header_footer')


@section('admin_container')
  
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
          <h2> 
          Change Password
          </h2>
    </div>
</div>
            <hr />
	<div class="row">
	<div class="col-lg-7 col-lg-offset-1">

{{Form::open(['route'=>['admin.changepassword'],'class'=>'form-horizontal','role'=>'form'])}}

<fieldset>
  
  <div class="form-group {{Form::error($errors,'current')}}">
      {{Form::label('current', 'Current Password', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
      	{{Form::password('current', ['class'=>'form-control','id'=>'new','placeholder'=>'your current password'])}}
        {{$errors->first('current',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group {{Form::error($errors,'password')}}">
      {{Form::label('new', 'New Password', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::password('password', ['class'=>'form-control','id'=>'new','placeholder'=>'choose a new password'])}}
        {{$errors->first('password',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group {{Form::error($errors,'confirm')}}">
      {{Form::label('confirm', 'Confirm Password', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
      	{{Form::password('confirm', ['class'=>'form-control','id'=>'new','placeholder'=>'confirm new password'])}}
        {{$errors->first('confirm',"<span class='help-block'>:message</span>")}}
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