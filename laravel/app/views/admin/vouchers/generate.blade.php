@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h1>       Generate Vouchers        
              {{link_to_route('voucher.index', 'Back to Vouchers List', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h1>
    </div>
    
</div>
            <hr />
            
<div class="row">
	<div class="col-lg-7 col-lg-offset-2">
    @if(count($plans))
{{Form::open(['route'=>'voucher.generate','class'=>'form-horizontal','role'=>'form',])}}

<fieldset>
	<div class="form-group {{Form::error($errors,'plan')}}">
      <label for="select" class="col-lg-4 control-label">Service Plan</label>
      <div class="col-lg-8">
        
        {{Form::select('plan_id', $plans, NULL, ['class'=>'form-control'])}}

        {{$errors->first('plan',"<span class=help-block>:message</span>")}}
    </div>
</div>

    <div class="form-group {{Form::error($errors,'count')}}">
          {{Form::label('p_name', 'Number of Vouchers',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8">
            {{Form::text('count', NULL, ['class'=>'form-control','placeholder'=>'how many vouchers to generate?','id'=>'p_name'])}}
            {{$errors->first('count',"<span class=help-block>:message</span>")}}
          </div>
        </div>
	<div class="form-group {{Form::error($errors,'validity')}}">
          {{Form::label('v_validity', 'Voucher Validity',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-6">
            {{Form::text('validity', NULL, ['class'=>'form-control','placeholder'=>'how long vouchers should stand valid?'])}}
            {{$errors->first('validity',"<span class=help-block>:message</span>")}}
          </div>
          <div class="col-lg-2">
            {{Form::select('validity_unit', ['days'=>'Days','months'=>'Months'], NULL, ['class'=>'form-control col-lg-2'])}}
          </div>
        </div>

        
        <div class="form-group">
      <div class="col-lg-10 col-lg-offset-5">
        {{Form::buttons('Generate')}}
      </div>
    </div>
</fieldset>
{{Form::close()}}
@else
  <h4>
    Please {{link_to_route('plan.add.form','create a service plan')}} first.
  </h4>
@endif
</div>
</div>

@stop