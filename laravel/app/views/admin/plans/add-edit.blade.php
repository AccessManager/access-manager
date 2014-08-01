@extends('admin.header_footer')
@section('admin_container')
<?php
// echo $plan->limit->limit_type; exit;
// pr($plan->limit);
$limit_type = 'hidden';
$time_limit = 'hidden';
$data_limit = 'hidden';
$aq_access = 'hidden';
$aq_policy = 'hidden';
$single_policy = NULL;
$policy_schema = 'hidden';
// $something = 'policy_id';
// $else = 'schema_id';
if( isset($plan) ) {
  if( $plan->plan_type == 1 ) {
    $limit_type = NULL;
    $aq_access = NULL;
    // if(isset($plan->limit) ) {
      if( $plan->limit_type == 0 || $plan->limit_type == 2 ) {
        $time_limit = NULL;
      }
      if( $plan->limit_type == 1 || $plan->limit_type == 2 ) {
        $data_limit = NULL;
      }
      if( $plan->aq_access ) {
        $aq_policy = NULL;
      }
    // }
  }
  if( $plan->policy_type == 'PolicySchema' ) {
    $single_policy = 'hidden';
    $policy_schema = NULL;
  }
}

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($plan))
          Edit Service Plan
          @else
          Add Service Plan
          @endif
            {{link_to_route('plan.index', 'Back to Plans Listing', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
    
</div>

            <hr />
<div class="row">
	<div class="col-lg-7 col-lg-offset-2">

@if(isset($plan))
{{Form::model($plan,['route'=>['plan.edit'],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('id', $plan->id)}}
  @if(isset($plan->limit_id))
    {{Form::hidden('limit_id', $plan->limit_id)}}
  @endif
@else
{{Form::open(['route'=>'plan.add','class'=>'form-horizontal','role'=>'form'])}}
@endif
{{Form::hidden('aq_access', 0)}}
<fieldset>
    <div class="form-group {{Form::error($errors,'name')}}">
      {{Form::label('plan_name', 'Plan Name', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('name', NULL, ['class'=>'form-control','id'=>'plan_name','placeholder'=>'Service Plan Name'])}}
        {{$errors->first('name',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group form-inline {{Form::error($errors,'plan_type')}}">
      <label class="col-lg-4 control-label">Plan Type</label>
      <div class="col-lg-8">
        <div class="radio">
          <label>
            {{Form::radio('plan_type', 0, true)}}
            Unlimited
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('plan_type', 1, false)}}
            Limited
          </label>
        </div>
      </div>
      {{$errors->first('plan_type',"<span class='help-block'>:message</span>")}}
    </div>
    
    <div class="form-group form-inline limited limit_type {{$limit_type}}" id="limit-type"  {{Form::error($errors,'limit_type')}}>
      <label class="col-lg-4 control-label">Limit Type</label>
      <div class="col-lg-8">
        <div class="radio">
          <label>
            {{Form::radio('limit_type', 0, False, [])}}
            Time Limit
          </label>
        </div>
        
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('limit_type', 1, False, [])}}
            Data Limit
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('limit_type', 2, False, [])}}
            Both limit
          </label>
        </div>
        {{$errors->first('limit_type',"<span class='help-block'>:message</span>")}}
      </div>
      
    </div><!-- ends limit type -->
   
    <div class="form-group limited time_limit {{$time_limit}} {{Form::error($errors,'limit[time_limit]')}} {{Form::error($errors,'time_limit')}}">
      <label for="inputEmail" class="col-lg-4 control-label">Time Limit</label>
      <div class="col-lg-6">
        {{Form::text("time_limit", NULL, ['class'=>'form-control','placeholder'=>'time limit'])}}
        {{$errors->first('time_limit',"<span class='help-block'>:message</span>")}}
      </div>
      <div class="col-lg-2">
        {{Form::select("time_unit", ['Hrs'=>'Hrs','Mins'=>'Mins'], NULL, ['class'=>'form-control'])}}
      </div>
  </div>
  <div class="form-group limited data_limit {{$data_limit}}  {{Form::error($errors,'data_limit')}}">
      <label for="inputEmail" class="col-lg-4 control-label">Data Limit</label>
      <div class="col-lg-6">
        {{Form::text("data_limit", NULL, ['class'=>'form-control','placeholder'=>'data limit'])}}
        {{$errors->first('data_limit',"<span class='help-block'>:message</span>")}}
      </div>
      <div class="col-lg-2">
        {{Form::select("data_unit", ['MB'=>'MBs','GB'=>'GBs'], NULL, ['class'=>'form-control'])}}
      </div>
  </div>
   <div class="form-group limited aq_access {{$aq_access}} {{Form::error($errors,'aq_access')}}">
      {{Form::label('allow', 'After Quota Access', ['class'=>'control-label col-lg-4'])}}
      <div class="col-lg-8">
        <div class="checkbox col-lg-5">
          <label>
            {{Form::checkbox('aq_access', 1, false, ['class'=>'checkbox','id'=>'aq-allowed'])}}
            Allowed?
          </label>
        </div>
      </div>
      {{$errors->first('aq_access',"<span class='help-block'>:message</span>")}}
    </div>
    <div class="form-group limited aq_policy {{$aq_policy}} {{Form::error($errors,'aq_policy')}}">
      <label for="inputEmail" class="col-lg-4 control-label">Select AQ Policy</label>
        <div class="col-lg-8">
        {{Form::select('aq_policy',$policies, NULL, ['class'=>'form-control'])}}
        {{$errors->first('aq_policy',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group form-inline {{Form::error($errors,'policy_type')}}">
      <label class="col-lg-4 control-label">Bandwidth Policy</label>
      <div class="col-lg-8">
        <div class="radio">
          <label>
            {{Form::radio('policy_type', 'Policy', true, [])}}
            Single Policy
          </label>
        </div>
        <div class="radio col-lg-offset-1">
          <label>
            {{Form::radio('policy_type', 'PolicySchema', false, [])}}
            Policy Schema
          </label>
        </div>
        {{$errors->first('policy_type',"<span class='help-block'>:message</span>")}}
      </div>
    </div>
    <div class="form-group single-policy  {{$single_policy}}">
      <label for="inputEmail" class="col-lg-4 control-label">Select Policy</label>
        <div class="col-lg-8">
        {{Form::select("policy_id", $policies, NULL, ['class'=>'form-control','id'=>'policy'])}}
      </div>
  </div>
  <div class="form-group policy-schema {{$policy_schema}}">
      <label for="schema" class="col-lg-4 control-label">Select Policy Schema</label>
        <div class="col-lg-8">
        {{Form::select("schema_id", $schemas, NULL, ['class'=>'form-control','id'=>'schema'])}}
      </div>
  </div>
    <div class="form-group {{Form::error($errors,'sim_sessions')}}">
      <label for="sessions" class="col-lg-4 control-label">Simultaneous Sessions</label>
      <div class="col-lg-8">
        {{Form::text('sim_sessions', NULL, ['class'=>'form-control','placeholder'=>'simultaneous sessions','id'=>'sessions'])}}
        {{$errors->first('sim_sessions',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group {{Form::error($errors, 'interim_updates')}}">
      <label for="interim" class="col-lg-4 control-label">Interim Updates</label>
      <div class="col-lg-8">
        {{Form::text('interim_updates', NULL, ['class'=>'form-control','placeholder'=>'interim updates','id'=>'interim'])}}
        {{$errors->first('interim_updates',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group {{Form::error($errors, 'validity')}}">
      <label for="inputEmail" class="col-lg-4 control-label">Plan Validity</label>
      <div class="col-lg-6">
        {{Form::text('validity', NULL, ['class'=>'form-control','placeholder'=>'plan validity'])}}
        {{$errors->first('validity',"<span class='help-block'>:message</span>")}}
      </div>
      
      <div class="col-lg-2">
        {{Form::select('validity_unit', ['Days'=>'Days','Months'=>'Months'], NULL, ['class'=>'form-control'])}}

      </div>

  </div>
    <div class="form-group {{Form::error($errors,'price')}}">
      
      <label for="price" class="col-lg-4 control-label">Plan Price</label>
      <div class="col-lg-8">
        {{Form::text('price', NULL, ['class'=>'form-control','placeholder'=>'plan price','id'=>'price'])}}
        {{$errors->first('price',"<span class='help-block'>:message</span>")}}
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