@extends('admin.header_footer')
@section('admin_container')
<?php
foreach($errors->all() as $error):
  echo $error . "<br />";
  endforeach;
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($template))
          Edit Voucher Template
          @else
          Add Voucher Template
          @endif

          {{link_to_route('tpl.voucher.index', 'Back to Listing', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
    
</div>

            <hr />
<div class="row">
	<div class="col-lg-7 col-lg-offset-1">

@if(isset($template))
{{Form::model($template,['route'=>['tpl.voucher.edit',$template->id],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('id', $template->id)}}
@else
{{Form::open(['route'=>'tpl.voucher.add','class'=>'form-horizontal','role'=>'form'])}}
@endif

<fieldset>
    <div class="form-group">
      {{Form::label('name', 'Template Name', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::text('name', NULL, ['class'=>'form-control','id'=>'plan_name','placeholder'=>'give me a name.'])}}
      </div>
  </div>
  <div class="form-group">
      {{Form::label('name', 'Template Body', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
        {{Form::textarea('body', NULL, ['class'=>'form-control','id'=>'plan_name','placeholder'=>'and the code goes here.'])}}
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