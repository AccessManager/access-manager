@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($policy))
          Modify Policy
          @else
          Create Policy
          @endif
          {{link_to_route('policies.index', 'Back to Policies', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>
            <hr />
<div class="row">
	<div class="col-lg-2"></div>
	<div class="col-lg-7">
@if(isset($policy))
{{Form::model($policy,['route'=>['policy.edit'],'class'=>'form-horizontal','role'=>'form',])}}
{{Form::hidden('id', $policy->id)}}
@else
{{Form::open(['class'=>'form-horizontal','role'=>'form',])}}
@endif
<?php
$policyError = NULL;
if($errors->has('name') ) {
  $policyError = 'has-error';
}
?>
<fieldset>
    <div class="form-group {{Form::error($errors, 'name')}}">
          {{Form::label('p_name', 'Policy Name',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8">
            {{Form::text('name', NULL, ['class'=>'form-control','placeholder'=>'Policy Name',])}}
            {{$errors->first('name',"<span class=help-block>:message</span>")}}
          </div>
        </div>
        <div class="form-group {{Form::error($errors, 'max_down')}}">
          {{Form::label('max_download', 'Maximum Download',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-6">
          {{Form::text('max_down', NULL, ['class'=>'form-control','placeholder'=>'Maximum Download'])}}
          {{$errors->first('max_down',"<span class=help-block>:message</span>")}}
          
          </div>
          <div class="col-lg-2">
            {{Form::select('max_down_unit', ['Kbps'=>'Kbps','Mbps'=>'Mbps'], NULL, ['class'=>'form-control'])}}
          </div>
        </div>
        <div class="form-group {{Form::error($errors, 'min_down')}}">
          {{Form::label('min_download', 'Minimum Download',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-6">
            {{Form::text('min_down', NULL, ['class'=>'form-control','placeholder'=>'Minimum Download'])}}
            {{$errors->first('min_down',"<span class=help-block>:message</span>")}}
          </div>
          <div class="col-lg-2">
            {{Form::select('min_down_unit', ['Kbps'=>'Kbps','Mbps'=>'Mbps'], NULL, ['class'=>'form-control'])}}
          </div>
        </div>
        <div class="form-group {{Form::error($errors, 'max_up')}}">
          {{Form::label('max_upload', 'Maximum Upload',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-6">
            {{Form::text('max_up', NULL, ['class'=>'form-control','placeholder'=>'Maximum Upload'])}}
            {{$errors->first('max_up',"<span class=help-block>:message</span>")}}
          </div>
          <div class="col-lg-2">
            {{Form::select('max_up_unit', ['Kbps'=>'Kbps','Mbps'=>'Mbps'], NULL, ['class'=>'form-control col-lg-2'])}}
          </div>
        </div>
        <div class="form-group {{Form::error($errors, 'min_up')}}">
          {{Form::label('min_upload', 'Minimum Upload',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-6">
            {{Form::text('min_up', NULL, ['class'=>'form-control','placeholder'=>'Minimum Upload'])}}
            {{$errors->first('min_up',"<span class=help-block>:message</span>")}}
          </div>
          <div class="col-lg-2">
            {{Form::select('min_up_unit', ['Kbps'=>'Kbps','Mbps'=>'Mbps'], NULL, ['class'=>'form-control col-lg-2'])}}
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