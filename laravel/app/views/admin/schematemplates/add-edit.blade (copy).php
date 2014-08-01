@extends('admin.header_footer')
@section('admin_container')
<?php
foreach($errors->all() as $error):
  echo $error . "<br />";
  endforeach;
?>

<div class="row">
    <div class="col-lg-5 col-md-5 col-sm-5">
        <h1>
          @if(isset($template))
          Edit Schema Template
          @else
          Add Schema Template
          @endif
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="nav navbar-default">
            <div class="navbar-header">
              
            </div>
            {{link_to_route('admin.schematemplates', 'Back to Schema Templates', NULL, ['class'=>'btn btn-primary navbar-right'])}}
        </div>
  </div>
</div>
            <hr />
<div class="row" ng-controller="planCtrl">
	<div class="col-lg-7 col-lg-offset-2" ng-controller="planCtrl">

@if(isset($template))
{{Form::model($template,['route'=>['admin.schematemplates.edit.post',$template->id],'class'=>'form-horizontal','role'=>'form'])}}
@else
{{Form::open(['route'=>'admin.schematemplates.add.post','class'=>'form-horizontal','role'=>'form'])}}
@endif

<fieldset>
    <div class="form-group" class="has-error">
      {{Form::label('template_name', 'Template Name', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('name', NULL, ['class'=>'form-control','placeholder'=>'Schema Template Name'])}}
        {{$errors->first('name',"<span class=help-block>:message</span>")}}
      </div>
  </div>
  <div class="form-group">
       <label class="col-lg-4 control-label">Access</label>
      <div class="col-lg-8 form-inline">
        <div class="radio">
          <label>
            {{Form::radio('access', 0, true, ["ng-model"=>'access',])}}
            Allowed
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('access', 1, false, ["ng-model"=>'access','ng-checked'=>true])}}
            Not Allowed
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('access', 2, false, ["ng-model"=>'access',])}}
            Partial
          </label>
        </div>
      </div>
    </div>
    <div class="form-group" ng-show="access == 0">
       <label for="select" class="col-lg-4 control-label">Bandwidth Policy</label>
      <div class="col-lg-8">
        {{Form::select('bw_policy', $policies, NULL, ['class'=>'form-control'])}}
    </div>
    </div>
    <div class="form-group" ng-show="access == 0">
       <label class="col-lg-4 control-label">Accountable</label>
      <div class="col-lg-8 form-inline">
          <label>
            {{Form::checkbox('bw_accountable', 1, FALSE, ['class'=>'checkbox'])}}
          </label>
      </div>
    </div>
    <div class="form-group" ng-show="access == 2">
      <label for="select" class="col-lg-4 control-label">Primary Time</label>
      <div class="col-lg-2">
        {{Form::select('from_time', $times, NULL, ['class'=>'form-control'])}}
      </div>
        <div class="col-lg-2">
          {{Form::select('to_time', $times, NULL, ['class'=>'form-control'])}}
        </div>
        <span class="help-block">
          Remaining time will automatically be calculated as secondary time.
        </span>
    </div>
    <div class="form-group" ng-show="access == 2">
      {{Form::label('allow', 'Allow', ['class'=>'control-label col-lg-4'])}}
      <div class="col-lg-8">
        <div class="checkbox col-lg-5">
          <label>
            {{Form::checkbox('allow_primary', 1, true, ['class'=>'checkbox', 'ng-model'=>'pr_time',])}}
            Primary Time
          </label>
        </div>
        <div class="checkbox col-lg-5">
          <label>
            {{Form::checkbox('allow_secondary', 1, false, ['class'=>'checkbox','ng-model'=>'sec_time'])}}
            Secondary Time
          </label>
        </div>
      </div>
    </div>
    <div class="form-group" ng-show="access == 2 && (pr_time || sec_time)">
      {{Form::label('allow', 'Select Policy', ['class'=>'control-label col-lg-4'])}}
      <div class="col-lg-3" >
        {{Form::select('pr_policy', $policies, NULL, ['class'=>'form-control', 'ng-show'=>"pr_time"])}}
      </div>
      <div class="col-lg-3">
        {{Form::select('sec_policy', $policies, NULL, ['class'=>'form-control','ng-show'=>"sec_time"])}}
      </div>
    </div>
    <div class="form-group" ng-show="access == 2 && (pr_time || sec_time)">
       <label class="col-lg-4 control-label">Accountable</label>
      <div class="col-lg-3 form-inline">
          <label ng-show="pr_time">
            {{Form::checkbox('pr_accountable', 1, true, ['class'=>'checkbox'])}}
            primary
          </label>
      </div>
      <div class="col-lg-3 form-inline">
          <label ng-show="sec_time">
            {{Form::checkbox('sec_accountable', 1, true, ['class'=>'checkbox'])}}
            secondary
          </label>
      </div>
    </div>
     
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-6">

        <button type="reset" class="btn btn-default">Reset</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
</fieldset>
{{Form::close()}}
</div>
</div>
@stop