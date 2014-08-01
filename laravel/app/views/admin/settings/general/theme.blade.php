@extends('admin.settings.setting')
@section('title')
General
@stop
@section('settings_container')

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li>
    {{link_to_route('setting.general.form','General Settings')}}
  </li>
  <li class="active">
    {{link_to_route('setting.themes.form','Themes')}}
  </li>
</ul>


<div class="row">
          <div class="col-lg-7 col-lg-offset-1">
        {{Form::model($theme,['route'=>['setting.themes'],'class'=>'form-horizontal','role'=>'form'])}}
        {{Form::hidden('id',$theme->id)}}
        <fieldset>
          <div class="form-group">
              {{Form::label('admin', 'Admin Panel Theme', ['class'=>'col-lg-4 control-label'])}}
              <div class="col-lg-8">
                {{Form::select('admin_theme', $themes, NULL, ['class'=>'form-control','id'=>'admin'])}}
              </div>
          </div>
            
          <div class="form-group">
              {{Form::label('user', 'User Panel Theme', ['class'=>'col-lg-4 control-label'])}}
              <div class="col-lg-8">
                {{Form::select('user_theme', $themes, NULL, ['class'=>'form-control','id'=>'user'])}}
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