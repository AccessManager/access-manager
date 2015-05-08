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
	<div class="col-lg-9">
		<div class="panel panel-default">
		  <div class="panel-body">
            <div class="row">

                <div class="col-lg-12">
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
            </div>
            @if( ! is_null($plan))
            <hr>
            <div class="row all" id='services'>
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
            <hr>
            <div class="row">
                <div class="col-lg-6">
                    <h3>
                        Add-on Services
                    </h3>
                </div>
                <div class="col-lg-6">
                    <a href="" class="pull-right">
                        Add Product
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
@endif
            <div class="row all hidden" id='settings'>
                <div class="col-lg-7 col-lg-offset-2">
                    @if(isset($ap_settings))
                    {{Form::model( $ap_settings,['route'=>'subscriber.ap.settings','class'=>'form-horizontal'])}}
                    @else
                    {{Form::open(['route'=>'subscriber.ap.settings','class'=>'form-horizontal'])}}
                    @endif
                    {{Form::hidden('percent_check', 0)}}
                    {{Form::hidden('user_id', $profile->id)}}
                    <fieldset>
                        <div class="form-group">
                            <label for="" class="col-lg-4 control-label">
                                Check payment dues:
                            </label>

                            <div class="col-lg-8">
                                {{Form::checkbox('percent_check',1,FALSE,['class'=>'checkbox'])}}
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-4 control-label">
                                Percentage
                            </label>
                            <div class="col-lg-8">
                                {{Form::text('percent', NULL, ['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-10 col-lg-offset-4">
                                {{Form::buttons()}}
                          </div>
                        </div>
                    </fieldset>
                    
                    {{Form::close()}}
                </div>
            </div> <!-- ends refill row inside panel body -->
            
		  </div> <!-- ends panel body -->
		</div> <!-- ends panel-default -->
	</div>
        <div class="col-lg-3">
        	<ul class="nav nav-pills nav-stacked" style="max-width: 300px;">
        		<li class="profile-nav active" target='services'><a href='#'>
                    <i class="fa fa-angle-double-left"></i>
                    Active Services</a></li>
			  <li class="profile-nav" target='settings'>
                <a href='#'>
                <i class="fa fa-angle-double-left"></i>
                Payment Settings</a>
            </li>
			</ul>
        </div>
</div>
@stop