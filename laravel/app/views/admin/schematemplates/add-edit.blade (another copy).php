@extends('admin.header_footer')
@section('admin_container')
<?php
foreach($errors->all() as $error):
  echo $error . "<br />";
  endforeach;

  $hideWhenAllowed = 'hidden';
  $hideWhenNotAllowed = 'hidden';
  $hideWhenPartial = 'hidden';
  $hidePrPolicy = 'hidden';
  $hideSecPolicy = 'hidden';
  $hidePolicyLabel = 'hidden';

  if( isset($template) ) {

    $hideWhenAllowed = ($template->access == 0 ) ? 'hidden' : NULL;
    $hideWhenNotAllowed = ($template->access == 1 ) ? 'hidden' : NULL;
    $hideWhenPartial = ($template->access == 2 ) ? 'hidden' : NULL;
    $hidePolicyLabel = ($template->access == 2 && ($template->pr_allowed || $template->sec_allowed) ) ? NULL : 'hidden';
    $hidePrAllowed = ($template->access  && $template->pr_allowed ) ? NULL : 'hidden';
    $hideSecAllowed = ($template->access && $template->sec_allowed ) ? NULL : 'hidden';
  }
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
<div class="row">
	<div class="col-lg-7 col-lg-offset-2">

@if(isset($template))
{{Form::model($template,['route'=>['admin.schematemplates.edit.post',$template->id],'class'=>'form-horizontal','role'=>'form'])}}
@else
{{Form::open(['route'=>'admin.schematemplates.add.post','class'=>'form-horizontal','role'=>'form'])}}
@endif

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
            {{Form::radio('access', 0, false)}}
            Allowed
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('access', 1, true)}}
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
    </div>
    <div class="form-group allowed 
    {{"$hideWhenNotAllowed $hideWhenPartial"}}
    {{Form::error($errors, 'policy_name')}}">
       <label for="select" class="col-lg-4 control-label">Bandwidth Policy</label>
      <div class="col-lg-8 {{Form::error($errors, 'policy_name')}}">
        {{Form::select('bw_policy', $policies, NULL, ['class'=>'form-control'])}}
    </div>
    </div>
    <div class="form-group allowed 
    {{"$hideWhenNotAllowed $hideWhenPartial"}}
    ">
       <label class="col-lg-4 control-label">Accountable</label>
      <div class="col-lg-8 form-inline">
          <label>
            {{Form::checkbox('bw_accountable', 1, FALSE, ['class'=>'checkbox'])}}
          </label>
      </div>
    </div>
    <div 
        class="
              form-group 
              partial 
              partial-main 
              {{"$hideWhenAllowed $hideWhenNotAllowed"}}
              {{Form::error($errors, 'from_time')}}"
    >
      <label for="select" class="col-lg-4 control-label">Primary Time</label>
      <div class="col-lg-2 {{Form::error($errors, 'from_time')}}">
        {{Form::select('from_time', $times, NULL, ['class'=>'form-control'])}}
      </div>
        <div class="col-lg-2 {{Form::error($errors, 'to_time')}}">
          {{Form::select('to_time', $times, NULL, ['class'=>'form-control'])}}
        </div>
        <span class="help-block">
          Remaining time will automatically be calculated as secondary time.
        </span>
    </div>
    <div class="form-group partial partial-main {{$hideWhenAllowed}}">
      {{Form::label('allow', 'Allow', ['class'=>'control-label col-lg-4'])}}
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
    <div class="form-group partial partial-sub 
    {{$hideWhenAllowed}} {{$hideWhenNotAllowed}}
    ">
      {{Form::label('allow', 'Select Policy', ['class'=>"control-label col-lg-4 partial-sub $hidePolicyLabel"])}}
      <div class="col-lg-3" >
        {{Form::select('pr_policy', $policies, NULL, ['class'=>"form-control pr-policy $hidePrPolicy"])}}
      </div>
      <div class="col-lg-3">
        {{Form::select('sec_policy', $policies, NULL, ['class'=>"form-control sec-policy $hideSecPolicy"])}}
      </div>
    </div>
    <div class="form-group partial partial-sub 
    {{$hideWhenAllowed}} {{$hideWhenNotAllowed}} {{$hidePolicyLabel}}
    ">
       <label class="col-lg-4 control-label partial-sub {{$hidePolicyLabel}}">Accountable</label>
      <div class="col-lg-3 form-inline">
          <label class="pr-accountable {{$hidePrPolicy}}">
            {{Form::checkbox('pr_accountable', 1, true, ['class'=>'checkbox'])}}
            primary
          </label>
      </div>
      <div class="col-lg-3 form-inline">
          <label class="sec-accountable {{$hideSecPolicy}}">
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