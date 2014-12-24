@extends('user.frinternet.header_footer')
@section('user_title')
Refill Quota
@stop

@section('user_container')
	

	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li class="active"><a href="#offline" data-toggle="tab">Using PIN</a></li>
  <li><a href="#online" data-toggle="tab">Buy Online</a></li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="offline">
    <div class="row">
	<div class="col-lg-7 col-lg-offset-1">

{{Form::open(['route'=>['frinternet.refill'],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('voucher_type','refill')}}
<fieldset>

  <div class="form-group">
      {{Form::label('pin', 'PIN', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
      	{{Form::text('pin', NULL, ['class'=>'form-control','id'=>'pin'])}}
      </div>
  </div>
    
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-6">
        {{Form::buttons('Apply Coupon')}}
      </div>
    </div>
    {{Form::close()}}
</fieldset>
</div>
</div>
  </div>
  <div class="tab-pane fade" id="online">
    <div class="row">
                <div class="col-lg-7 col-lg-offset-1">

{{Form::open(['route'=>['recharge.select.pg'],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('have_data',1)}}
{{Form::hidden('type','refill')}}
<fieldset>

  <div class="form-group">
      {{Form::label('value', 'How Much', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-6">
        {{Form::text('data_limit', NULL, ['class'=>'form-control','id'=>'value','placeholder'=>'Enter number of GBs'])}}
      </div>
      <div class="col-lg-2">
        {{Form::select('data_unit',['GB'=>'GB'],NULL,['class'=>'form-control'])}}
      </div>
  </div>
    
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-6">
        {{Form::buttons('Buy Now!')}}
      </div>
    </div>
    {{Form::close()}}
</fieldset>
</div>
            </div>
            
  </div>

</div>


@stop