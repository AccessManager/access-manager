@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>       Recharge Account       
              {{link_to_route('voucher.index', 'All Vouchers', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>
            <hr />
<div class="row">
	<div class="col-lg-7 col-lg-offset-2">
{{Form::open(['route'=>'voucher.recharge','class'=>'form-horizontal','role'=>'form'])}}

<fieldset>
	<div class="form-group {{Form::error($errors,'account')}}">
      <label for="select" class="col-lg-4 control-label">Select Account</label>
      <div class="col-lg-8">
        @if(count($accounts))
        {{Form::select('user_id', $accounts, Request::segment(4, NULL), ['class'=>'form-control'])}}
        @else
          <h5>
            Please {{link_to_route('subscriber.add.form','create an account')}} first.
          </h5>
        @endif
        {{$errors->first('account',"<span class='help-block'>:message</span>")}}
    </div>
</div>
<div class="form-group {{Form::error($errors,'plan')}}">
      <label for="select" class="col-lg-4 control-label">Service Plan</label>
      <div class="col-lg-8">
        @if(count($plans))
        {{Form::select('plan_id', $plans, NULL, ['class'=>'form-control'])}}
        @else
        <h5>
          Please {{link_to_route('plan.add.form','create an service plan')}} first.
        </h5>
        @endif
        {{$errors->first('plan',"<span class='help-block'>:message</span>")}}
    </div>
</div>
    
    <div class="form-group">
      <div class="col-lg-4 col-lg-offset-5">
        <!-- <div class="btn-toolbar"> -->
          <!-- <div class="btn-group"> -->
        <!-- {{Form::button('Reset', ['type'=>'reset','class'=>'btn btn-default'])}} -->
        {{Form::submit('Recharge',['class'=>'btn btn-primary btn-block'])}}
        <!-- </div> -->
        <!-- </div> -->
      </div>
    </div>
</fieldset>
{{Form::close()}}
</div>
</div>
@stop