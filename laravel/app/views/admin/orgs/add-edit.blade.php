@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($org))
          Modify Organisation
          @else
          Add Organisation
          @endif
        {{link_to_route('org.index', 'All Organisations', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>

            <hr />
<div class="row">
	<div class="col-lg-2"></div>
	<div class="col-lg-7">
@if(isset($org))
{{Form::model($org,['route'=>['org.edit',$org->id],'class'=>'form-horizontal','role'=>'form',])}}
{{Form::hidden('id', $org->id)}}
@else
{{Form::open(['class'=>'form-horizontal','role'=>'form','route'=>'org.add'])}}
@endif
<?php
// $policyError = NULL;
// if($errors->has('name') ) {
//   $policyError = 'has-error';
// }
?>
<fieldset>
    <div class="form-group">
          {{Form::label('name', 'Organisation Name',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'name')}}">
            {{Form::text('name', NULL, ['class'=>'form-control','placeholder'=>'organisation name',])}}
            {{$errors->first('name',"<span class=help-block>:message</span>")}}
          </div>
        </div>
        <div class="form-group">
          {{Form::label('tin', 'TIN',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'tin')}}">
            {{Form::text('tin', NULL, ['class'=>'form-control','placeholder'=>'TAX Identification Number.',])}}
            {{$errors->first('tin',"<span class=help-block>:message</span>")}}
          </div>
        </div>
        <div class="form-group">
          {{Form::label('address', 'Address',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'policy_name')}}">
            {{Form::textarea('address', NULL, ['class'=>'form-control','placeholder'=>'organisation address','rows'=>4])}}
            {{$errors->first('Address',"<span class=help-block>:message</span>")}}
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