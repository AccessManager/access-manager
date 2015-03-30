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
  @if( $profile->plan_type == ADVANCEPAID_PLAN)
    <li>
        {{link_to_route('subscriber.ap.transactions','Transactions', $profile->id)}}
    </li>
  @endif
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
                    <a href='#add-product' data-toggle='tab'>
                        <i class="fa fa-angle-double-left"></i>
                        Add Product
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade in" id="services">
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2>
                                        @if( isset($plan))
                                            {{$plan->plan_name}}
                                        @else
                                        No Service
                                        @endif
                                    </h2>
                                </div>
                                <div class="col-lg-6">
                                        <p class="pull-right">
                                        @if( is_null($plan) )
                                            {{link_to_route('subscriber.assign.form','Assign Service Plan', $profile->id)}}
                                        @else
                                            {{link_to_route('subscriber.assign.form','Change Service Plan',$profile->id)}}
                                        @endif
                                        </p>
                                </div>
                            </div>
                            @if( ! is_null($plan))
                             <div class="row">
                                    <div class="col-lg-6">
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
                                    </div>
                                    <div class="col-lg-6">
                                        <blockquote>
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
                             </div>
                             <div class="row">
                                    <div class="col-lg-6">
                                        <h3>
                                            Add-on Services
                                        </h3>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#recurring" data-toggle='tab'>Recurring</a>
                                    </li>
                                    <li>
                                        <a href="#non-recurring" data-toggle='tab'>Non-Recurring</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="recurring">
                                         <div class="row">
                                            <div class="col-lg-12">
                                                @include('admin.accounts.partials.recurring_products_table')
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade" id='non-recurring'>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                @include('admin.accounts.partials.non_recurring_products_table')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @include('admin.accounts.partials.add_product_tab_pane')
            </div>
        </div>
    </div>
</div>
@stop