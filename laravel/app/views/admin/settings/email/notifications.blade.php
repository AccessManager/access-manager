@extends('admin.settings.setting')
@section('title')
Email
@stop

@section('settings_container')
<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li class="active">
    {{link_to_route('setting.email.form','Notifications')}}
  </li>
  <li>
    {{link_to_route('setting.smtp.form','SMTP Config')}}
  </li>
</ul>

<div class="row">
  <div class="col-lg-7 col-lg-offset-1">
{{Form::model($email,['route'=>['setting.email'],'class'=>'form-horizontal','role'=>'form'])}}

<fieldset>
  <div class="form-group">
      {{Form::label('register', 'New Registration', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-1">
        {{Form::checkbox('registration', 1, false, ['class'=>'checkbox','id'=>'register'])}}
      </div>
      <div class="col-lg-7">
        {{Form::select('registration', $tpls, NULL, ['class'=>'form-control'])}}
      </div>
  </div>
    <div class="form-group">
      {{Form::label('recharge', 'Recharge Successful', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-1">
        {{Form::checkbox('recharge', 1, false, ['class'=>'checkbox','id'=>'recharge'])}}
      </div>
      <div class="col-lg-7">
        {{Form::select('recharge', $tpls, NULL, ['class'=>'form-control'])}}
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