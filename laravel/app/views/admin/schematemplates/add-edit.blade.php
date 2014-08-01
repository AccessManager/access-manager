@extends('admin.header_footer')
@section('admin_container')
<?php
$allowed = 'hidden';
$partial = 'hidden';
$partial_labels = 'hidden';
$prAllowed = 'hidden';
$secAllowed = 'hidden';

if(isset($template)) {
  switch($template->access)
    {
      case 0:
        $allowed = NULL;
        break;

      case 2:
        $partial = NULL;
        if($template->pr_allowed || $template->sec_allowed) {
          $partial_labels = NULL;
        }
        if($template->pr_allowed) {
          $prAllowed = NULL;
        }
        if($template->sec_allowed) {
          $secAllowed = NULL;
        }
        break;
    }
}

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($template))
          Edit Schema Template
          @else
          Add Schema Template
          @endif
            {{link_to_route('schematemplate.index', 'Back to Listing', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>
            <hr />
<div class="row">
	<div class="col-lg-7 col-lg-offset-2">

@if(isset($template))
{{Form::model($template,['route'=>['schematemplate.edit',$template->id],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('id', $template->id)}}
@else
{{Form::open(['route'=>'schematemplate.add','class'=>'form-horizontal','role'=>'form'])}}
@endif
{{Form::hidden('bw_accountable', 0)}}
{{Form::hidden('pr_allowed', 0)}}
{{Form::hidden('sec_allowed', 0)}}
{{Form::hidden('pr_accountable', 0)}}
{{Form::hidden('sec_accountable', 0)}}
<fieldset>
    <div class="form-group {{Form::error($errors, 'name')}}">
      {{Form::label('template_name', 'Template Name', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8 {{Form::error($errors, 'name')}}">
        {{Form::text('name', NULL, ['class'=>'form-control','placeholder'=>'Schema Template Name'])}}
        {{$errors->first('name',"<span class=help-block>:message</span>")}}
      </div>
  </div>
  <div class="form-group {{Form::error($errors, 'access')}}">
       <label class="col-lg-4 control-label">Access</label>
      <div class="col-lg-8 form-inline">
        <div class="radio">
          <label>
            {{Form::radio('access', 1, false)}}
            Allowed
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('access', 0, true)}}
            Not Allowed
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('access', 2, false)}}
            Partial
          </label>
        </div>
      </div>
      {{$errors->first('access',"<span class='help-block'>:message</span>")}}
    </div>
    <div class="form-group allowed {{$allowed}}
    {{Form::error($errors, 'bw_policy')}}">
       <label for="select" class="col-lg-4 control-label">Bandwidth Policy</label>
      <div class="col-lg-8 {{Form::error($errors, 'policy_name')}}">
        {{Form::select('bw_policy', $policies, NULL, ['class'=>'form-control'])}}
        {{$errors->first('bw_policy',"<span class='help-block'>:message</span>")}}
    </div>
    </div>
    <div class="form-group allowed {{$allowed}}
    ">
       <label class="col-lg-4 control-label">Accountable</label>
      <div class="col-lg-8 form-inline">
          <label>
            {{Form::checkbox('bw_accountable', 1, FALSE, ['class'=>'checkbox'])}}
          </label>
      </div>
      {{$errors->first('bw_accountable',"<span class='help-block'>:message</span>")}}
    </div>
    <div 
        class="
              form-group 
              partial 
              partial-main 
              {{$partial}}
              {{Form::error($errors, 'from_time')}}"
    >
      <label for="select" class="col-lg-4 control-label">Primary Time</label>
      <div class="col-lg-2 clockpicker {{Form::error($errors, 'from_time')}}">
        <!-- <input type="text" class='form-control'> -->
        {{Form::text('from_time', NULL, ['class'=>'form-control','placeholder'=>'From Time'])}}
        {{$errors->first('from_time',"<span class='help-block'>:message</span>")}}
        <!-- {{Form::select('from_time', $times, NULL, ['class'=>'form-control'])}} -->
      </div>
        <div class="col-lg-2 clockpicker {{Form::error($errors, 'to_time')}}">
          <!-- {{Form::select('to_time', $times, NULL, ['class'=>'form-control'])}} -->
          {{Form::text('to_time', NULL, ['class'=>'form-control','placeholder'=>'To Time'])}}
          {{$errors->first('to_time',"<span class='help-block'>:message</span>")}}
        </div>
        <span class="help-block">
          Remaining time will automatically be calculated as secondary time.
        </span>
    </div>
    <div class="form-group partial partial-main {{$partial}}">
      {{Form::label('allow', 'Allow', ['class'=>'control-label col-lg-4',])}}
      <div class="col-lg-8">
        <div class="checkbox col-lg-5">
          <label>
            {{Form::checkbox('pr_allowed', 1, false, ['class'=>'checkbox','id'=>'pr-allowed'])}}
            Primary Time
          </label>
        </div>
        <div class="checkbox col-lg-5">
          <label>
            {{Form::checkbox('sec_allowed', 1, false, ['class'=>'checkbox','id'=>'sec-allowed'])}}
            Secondary Time
          </label>
        </div>
      </div>
    </div>
    <div class="form-group partial partial-sub {{$partial_labels}}
    ">
      {{Form::label('allow', 'Select Policy', ['class'=>"control-label col-lg-4 partial-sub $partial_labels"])}}
      <div class="col-lg-3" >
        {{Form::select('pr_policy', $policies, NULL, ['class'=>"form-control pr-policy $prAllowed"])}}
      </div>
      <div class="col-lg-3">
        {{Form::select('sec_policy', $policies, NULL, ['class'=>"form-control sec-policy $secAllowed"])}}
      </div>
    </div>
    <div class="form-group partial partial-sub {{$partial_labels}}
    ">
       <label class="col-lg-4 control-label partial-sub {{$partial_labels}}">Accountable</label>
      <div class="col-lg-3 form-inline">
          <label class="pr-accountable {{$prAllowed}}">
            {{Form::checkbox('pr_accountable', 1, true, ['class'=>"checkbox"])}}
            primary
          </label>
      </div>
      <div class="col-lg-3 form-inline">
          <label class="sec-accountable  {{$secAllowed}}">
            {{Form::checkbox('sec_accountable', 1, true, ['class'=>"checkbox"])}}
            secondary
          </label>
      </div>
    </div>
     
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-5">
        {{Form::buttons()}}
      </div>
    </div>
</fieldset>
{{Form::close()}}
</div>
</div>
@stop