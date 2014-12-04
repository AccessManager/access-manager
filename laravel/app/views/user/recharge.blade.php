@extends('user.header_footer')
@section('user_title')
Recharge Account
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

{{Form::open(['route'=>['prepaid.recharge'],'class'=>'form-horizontal','role'=>'form'])}}

<fieldset>

  <div class="form-group">
      {{Form::label('pin', 'PIN', ['class'=>'col-lg-4 control-label'])}}
      <div class="col-lg-8">
      	{{Form::text('pin', NULL, ['class'=>'form-control','id'=>'pin'])}}
      </div>
  </div>
  <div class="form-group">
  <div class="col-lg-3 col-lg-offset-4">
     <div class="radio">
      <label for="prepaid">
        <input type="radio" name='voucher_type' id='prepaid' value='prepaid'>
        Prepaid Voucher
      </label>
     </div> 
    </div>
    <div class="col-lg-4">
     <div class="radio">
      <label for="refill">
        <input type="radio" name='voucher_type' id='refill' value='refill'>
        Refill Coupon
      </label>
     </div> 
    </div>
  </div>
    
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-6">
        {{Form::buttons('Recharge')}}
      </div>
    </div>
    {{Form::close()}}
</fieldset>
</div>
</div>
  </div>
  <div class="tab-pane fade" id="online">
    <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plan Name</th>
                                <th>Primary Bandwidth Policy</th>
                                <th>Plan Type</th>
                                <th>Time Limit</th>
                                <th>Data Limit</th>
                                <th>After Quota Access</th>
                                <th>Validity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if(count($plans))
                          <?php $i = $plans->getFrom(); ?>
                          @foreach($plans as $plan)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$plan->name}}</td>
                                <td>{{$plan->policy->name}}</td>
                                <td>{{$plan->plan_type == 1 ? 'Limited' : 'Unlimited'}}</td>
                                <td>
                                  @if(isset($plan->limit))
                                  {{$plan->limit->time_limit}} {{$plan->limit->time_unit}}
                                  @endif
                                </td>
                                <td>
                                  @if(isset($plan->limit))
                                  {{$plan->limit->data_limit}} {{$plan->limit->data_unit}}
                                  @endif
                                </td>
                                <td>
                                  @if(isset($plan->limit))
                                  {{$plan->limit->aq_access == 1 ? 'Allowed' : 'Not Allowed'}}
                                  @endif
                                </td>
                                <td>{{$plan->validity}} {{$plan->validity_unit}}</td>
                                <td><button type="button" class="btn btn-danger btn-xs">
                                    <i class="fa fa-unlink"></i> Buy Now!</button></td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='8'>No Records Found.</td>
                            </tr>
                            @endif
                        </tbody>
                        
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg12 col-md-12 col-sm-12">
                    {{$plans->links()}}
                </div>
            </div>
  </div>

</div>


@stop