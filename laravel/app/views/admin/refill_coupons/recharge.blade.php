@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>       Refill Account       
              {{link_to_route('refill.index', 'Back to Refill Coupons', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>
            <hr />
<div class="row">
	<div class="col-lg-7 col-lg-offset-2">
{{Form::open(['route'=>'refill.recharge','class'=>'form-horizontal','role'=>'form'])}}

<fieldset>
	<div class="form-group {{Form::error($errors,'account')}}">
      <label for="select" class="col-lg-4 control-label">Select Account</label>
      <div class="col-lg-8">
        @if(count($accounts))
        {{Form::select('user_id', $accounts, NULL, ['class'=>'form-control'])}}
        @else
          <h5>
            Please {{link_to_route('subscriber.add.form','create an account')}} first.
          </h5>
        @endif
        {{$errors->first('account',"<span class='help-block'>:message</span>")}}
    </div>
</div>
<div class="form-group {{Form::error($errors,'pin')}}">
          {{Form::label('p_name', 'Enter PIN',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8">
            {{Form::text('pin', NULL, ['class'=>'form-control','placeholder'=>'enter pin mentioned on refill coupon here','id'=>'p_name'])}}
            {{$errors->first('pin',"<span class=help-block>:message</span>")}}
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