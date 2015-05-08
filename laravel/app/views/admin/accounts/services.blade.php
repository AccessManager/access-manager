@extends('admin.header_footer')
@section('admin_container')

<div class="row">
	<div class="col-lg-6">
		<h2>{{{$profile->uname}}}</h2>
	</div>
</div>
<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li>
    {{link_to_route('subscriber.profile','User Profile', $profile->id)}}
</li>
  <li class="active"><a>Active Services</a></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <div class="tabbable tabs-right">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href='#services' data-toggle='tab'>
                        <i class="fa fa-angle-double-left"></i>
                        Active Services
                    </a>
                </li>
                <li>
                    <a href='#refill' data-toggle='tab'>
                        <i class="fa fa-angle-double-left"></i>
                        Refill Manually
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id='services'>
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                            {{-- <div class="col-lg-12"> --}}
                                <div class="col-lg-6">
                                    <h2>
                                        @if( isset($plan))
                                            @if( $profile->plan_type == FREE_PLAN )
                                                FRiNTERNET
                                            @else
                                            {{$plan->plan_name}}
                                            @endif
                                        @else
                                        No Service
                                        @endif
                                    </h2>
                                </div>
                                <div class="col-lg-6">
                                    @if( is_null($plan) )
                                        <p class="pull-right">
                                            @if( $profile->plan_type == ADVANCEPAID_PLAN )
                                            {{link_to_route('subscriber.assign.form','Assign Service Plan', $profile->id)}}
                                            @elseif( $profile->plan_type == PREPAID_PLAN )
                                            {{link_to_route('voucher.recharge.form','Recharge Account',$profile->id)}}
                                            @endif
                                        </p>
                                    @else
                                        <p class='pull-right'>
                                            @if( $profile->plan_type == PREPAID_PLAN )
                                            {{link_to_route('voucher.recharge.form','Recharge Account', $profile->id)}}
                                            @elseif( $profile->plan_type == ADVANCEPAID_PLAN )
                                            {{link_to_route('subscriber.assign.form','Change Service Plan',$profile->id)}}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            {{-- </div> --}}
                        </div>
                        @if( ! is_null($plan))
                        <hr>
                        <div class="row all" id='profile'>
                            <div class="col-lg-6">
                                <!-- <blockquote class=""> -->
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>
                                                <b>Plan Type:</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <h5>
                                                {{$plan->plan_type == LIMITED ? 'Limited' : 'Unlimited'}}
                                            </h5>
                                        </div>
                                    </div>
                                    @if($plan->plan_type == LIMITED )
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>
                                                <b>Limit Type:</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-7">
                                            <h5>
                                                    {{$plan->limit_type == TIME_LIMIT ? 'Time Limit' : NULL }}
                                                    {{$plan->limit_type == DATA_LIMIT ? 'Data Limit' : NULL }}
                                                    {{$plan->limit_type == BOTH_LIMITS ? 'Both Limits' : NULL}}
                                            </h5>
                                        </div>
                                    </div>
                                    @if($plan->limit_type == TIME_LIMIT || $plan->limit_type == BOTH_LIMITS )
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>
                                                <b>Time Balance:</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <h5>
                                                {{formatTime($plan->time_limit)}}
                                            </h5>
                                        </div>
                                    </div>
                                    @endif
                                    @if($plan->limit_type == DATA_LIMIT || $plan->limit_type == BOTH_LIMITS)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>
                                                <b>Data Balance:</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <h5>
                                                {{formatBytes($plan->data_limit)}}
                                            </h5>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>
                                                <b>Service Expiry</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-5">
                                            <h5>
                                                {{$plan->expiration}}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>
                                                <b>Next Quota Reset:</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-5">
                                            <h5>
                                                
                                            </h5>
                                        </div>
                                    </div>
                                <!-- </blockquote> -->
                            </div>
                            <div class="col-lg-6">
                                <blockquote class="">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <h5>
                                                <b>IP Addr:</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-5">
                                            <h5>
                                                @if( ! is_null($framedIP))
                                                {{long2ip($framedIP->ip)}}
                                                @else
                                                {{link_to_route('subnet.assignip.form','Assign IP',$profile->id)}}
                                                @endif
                                            </h5>
                                        </div>
                                        @if( ! is_null($framedIP) )
                                        <div class="col-lg-2">
                                            <h5>
                                                {{link_to_route('subnet.assignip.form','change',$profile->id)}}
                                            </h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5>
                                                {{link_to_route('subnet.delete.ip','Remove',$framedIP->id)}}
                                            </h5>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <h5>
                                                <b>Route:</b>
                                            </h5>
                                        </div>
                                        <div class="col-lg-5">
                                            <h5>
                                                @if( ! is_null($framedRoute))
                                                {{$framedRoute->subnet}}
                                                @else
                                                {{link_to_route('subnet.assignroute.form','Assign Route', $profile->id)}}
                                                @endif
                                            </h5>
                                        </div>
                                        @if(! is_null($framedRoute) )
                                        <div class="col-lg-2">
                                            <h5>
                                                {{link_to_route('subnet.assignroute.form','Change',$profile->id)}}
                                            </h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5>
                                                {{link_to_route('subnet.delete.route','Remove',$framedRoute->id)}}
                                            </h5>
                                        </div>
                                        @endif
                                    </div>
                                </blockquote>
                            </div>
                        </div> <!-- ends profile row inside panel body -->
            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="refill">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row" id='refill'>
                                <div class="col-lg-12">
                                    <h2>Refill (Manually)</h2>
                                    <hr>
                                </div>
                            </div> <!-- ends refill row inside panel body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($profile->plan_type == PREPAID_PLAN && count($rc_history))
<hr>
<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li class="active"><a href="#recharge" data-toggle="tab">Recent Recharges</a></li>
</ul>
<div id="myTabContent" class="tab-content">
<div class="tab-pane fade active in" id="recharge">
    <table class="table table-striped table-responsive table-hover table-condensed">
        <thead>
            <tr>
                <th>#</th>
                <th>Service Plan</th>
                <th>Recharged On</th>
                <th>Method</th>
                <th>Plan Validity</th>
                <th>Plan Type</th>
                <th>Time Limit</th>
                <th>Data Limit</th>
            </tr>
        </thead>
        <tbody>
            @if(count($rc_history))
            <?php $i = $rc_history->getFrom(); ?>
            @foreach($rc_history as $voucher)
            <tr>
                <td>{{$i}}</td>
                <td>{{$voucher->plan_name}}</td>
                <td>{{$voucher->updated_at}}</td>
                <td>{{$voucher->method}}</td>
                <td>{{$voucher->validity}} {{$voucher->validity_unit}}</td>
                <td>{{$voucher->plan_type == LIMITED ? 'Limited' : 'Unlimited';}}</td>

                <td>
                @if( $voucher->plan_type == LIMITED && ($voucher->limit_type == TIME_LIMIT || $voucher->limit_type == BOTH_LIMITS ))
                    {{$voucher->limits->time_limit}} {{$voucher->limits->time_unit}}
                @else
                    N/A
                @endif
                </td>
                <td>
                @if( $voucher->plan_type == LIMITED && ($voucher->limit_type == DATA_LIMIT || $voucher->limit_type == BOTH_LIMITS))
                    {{$voucher->limits->data_limit}} {{$voucher->limits->data_unit}}
                @else
                    N/A
                @endif
                </td>
            </tr>
            <?php $i++; ?>
            @endforeach
            @else
            <tr> <td colspan='8'>No Records Found.</td></tr>
            @endif
        </tbody>
    </table>
    {{$rc_history->links()}}
  </div>
@endif
@stop