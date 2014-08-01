@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($schema))
          Edit Policy Schema
          @else
          Add Policy Schema
          @endif
          {{link_to_route('schema.index', 'Back to Policy Schemas', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>

            <hr />
<div class="row" ng-controller="planCtrl">
	<div class="col-lg-7 col-lg-offset-1">

@if(isset($schema))
{{Form::model($schema,['route'=>['schema.edit',$schema->id],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('id', $schema->id)}}
@else
{{Form::open(['route'=>'schema.add','class'=>'form-horizontal','role'=>'form'])}}
@endif

<fieldset>
    <div class="form-group {{Form::error($errors,'name')}}">
      {{Form::label('schema_name', 'Schema Name', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('name', NULL, ['class'=>'form-control','id'=>'plan_name','placeholder'=>'Schema Name'])}}
        {{$errors->first("name","<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group {{Form::error($errors,'mo')}}" id="monday">
      <label class="col-lg-4 control-label">Monday</label>
      <div class="col-lg-8">
    {{Form::select('mo', $templates, NULL, ['class'=>'form-control'])}}
    {{$errors->first("mo","<span class='help-block'>:message</span>")}}
      </div>
    </div><!-- ends monday -->
    <div class="form-group {{Form::error($errors,'tu')}}" id="tuesday">
      <label class="col-lg-4 control-label">Tuesday</label>
      <div class="col-lg-8">
    {{Form::select('tu', $templates, NULL, ['class'=>'form-control'])}}
    {{$errors->first("tu","<span class='help-block'>:message</span>")}}
      </div>
    </div><!-- ends tuesday -->
  <div class="form-group {{Form::error($errors,'we')}}" id="wednesday">
      <label class="col-lg-4 control-label">Wednesday</label>
      <div class="col-lg-8">
    {{Form::select('we', $templates, NULL, ['class'=>'form-control'])}}
    {{$errors->first("we","<span class='help-block'>:message</span>")}}
      </div>
    </div><!-- ends wednesday -->
     <div class="form-group {{Form::error($errors,'th')}}" id="thursday">
      <label class="col-lg-4 control-label">Thursday</label>
      <div class="col-lg-8">
    {{Form::select('th', $templates, NULL, ['class'=>'form-control'])}}
    {{$errors->first("th","<span class='help-block'>:message</span>")}}
      </div>
    </div><!-- ends thursday -->
    <div class="form-group {{Form::error($errors,'fr')}}" id="monday">
      <label class="col-lg-4 control-label">Friday</label>
      <div class="col-lg-8">
    {{Form::select('fr', $templates, NULL, ['class'=>'form-control'])}}
    {{$errors->first("fr","<span class='help-block'>:message</span>")}}
      </div>
    </div><!-- ends friday -->
    <div class="form-group {{Form::error($errors,'sa')}}" id="monday">
      <label class="col-lg-4 control-label">Saturday</label>
      <div class="col-lg-8">
    {{Form::select('sa', $templates, NULL, ['class'=>'form-control'])}}
    {{$errors->first("sa","<span class='help-block'>:message</span>")}}
      </div>
    </div><!-- ends saturday -->
    <div class="form-group {{Form::error($errors,'su')}}" id="monday">
      <label class="col-lg-4 control-label">Sunday</label>
      <div class="col-lg-8">
    {{Form::select('su', $templates, NULL, ['class'=>'form-control'])}}
    {{$errors->first("su","<span class='help-block'>:message</span>")}}
      </div>
    </div><!-- ends sunday -->
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