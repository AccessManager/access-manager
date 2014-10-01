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
    
{{Form::open(['route'=>'refill.generate','class'=>'form-horizontal','role'=>'form',])}}

<fieldset>
	    <div class="form-group {{Form::error($errors,'have_time')}}">
          {{Form::label('v_validity', 'Have Time Limit',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-2">
            {{Form::select('have_time', [1=>'Yes',0=>'No'], NULL, ['class'=>'form-control col-lg-2'])}}
          </div>
          <div class="col-lg-4">
            {{Form::text('time_limit', NULL, ['class'=>'form-control','placeholder'=>'how long?'])}}
            {{$errors->first('time_limit',"<span class=help-block>:message</span>")}}
          </div>
          <div class="col-lg-2">
            {{Form::select('time_unit', ['Mins'=>'Mins','Hours'=>'Hours'], NULL, ['class'=>'form-control col-lg-2'])}}
          </div>
        </div>
    
    <div class="form-group {{Form::error($errors,'have_data')}}">
          {{Form::label('v_validity', 'Have Data Limit',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-2">
            {{Form::select('have_data', [1=>'Yes',0=>'No'], NULL, ['class'=>'form-control col-lg-2'])}}
          </div>
          <div class="col-lg-4">
            {{Form::text('data_limit', NULL, ['class'=>'form-control','placeholder'=>'how much?'])}}
            {{$errors->first('data_limit',"<span class=help-block>:message</span>")}}
          </div>
          <div class="col-lg-2">
            {{Form::select('data_unit', ['MB'=>'MB','GB'=>'GB'], NULL, ['class'=>'form-control col-lg-2'])}}
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
          {{Form::label('validity', 'Voucher Validity',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-6">
            {{Form::text('validity', NULL, ['class'=>'form-control','placeholder'=>'how long vouchers should stand valid?'])}}
            {{$errors->first('validity',"<span class=help-block>:message</span>")}}
          </div>
          <div class="col-lg-2">
            {{Form::select('validity_unit', ['Days'=>'Days','Months'=>'Months'], NULL, ['class'=>'form-control col-lg-2'])}}
          </div>
        </div>
        <div class="form-group">
      <div class="col-lg-10 col-lg-offset-5">
        {{Form::buttons('Generate')}}
      </div>
    </div>
</fieldset>
{{Form::close()}}

</div>
</div>

@stop