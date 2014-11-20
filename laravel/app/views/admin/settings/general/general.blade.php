@extends('admin.settings.setting')
@section('title')
General
@stop
@section('settings_container')

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li class="active">
    {{link_to_route('setting.general.form','General Settings')}}
  </li>
  <li>
    {{link_to_route('setting.themes.form','Themes')}}
  </li>
</ul>

<div class="row">
        <div class="col-lg-7 col-lg-offset-1">
      {{Form::model($general,['route'=>['setting.general'],'class'=>'form-horizontal','role'=>'form'])}}
      {{Form::hidden('id',$general->id)}}
      {{Form::hidden('self_signup',0)}}
      <fieldset>
          <div class="form-group">
            {{Form::label('idle', 'Idle Timeout', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::text('idle_timeout', NULL, ['class'=>'form-control','id'=>'idle','placeholder'=>'time in seconds.'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('self-registration', 'User Self Registration', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::checkbox('self_signup', 1, false, ['class'=>'checkbox','id'=>'self-registration'])}}
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