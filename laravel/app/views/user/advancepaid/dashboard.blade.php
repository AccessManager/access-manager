@extends('user.advancepaid.header_footer')

@section('user_title')
	Welcome {{$profile->fname}} {{$profile->lname}}!
@stop

@section('user_container')
<div class="row">
	<div class="col-lg-8">
		<blockquote class="">
	  <p class="text-danger">{{$profile->uname}}</p>
	  <h5>
	  	<i class="fa fa-home"></i>
	  	{{$profile->address}}
	  </h5>	
	  <h5>
	  	<i class="fa fa-envelope"></i>
	  	{{$profile->email}}
	  </h5>
	  <h5>
	  	<i class="fa fa-phone"></i>
	  	<a href="tel:{{$profile->contact}}">
	  		{{$profile->contact}}
	  	</a>
	  	
	  </h5>
	</blockquote>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					Service Plan
				</h4>

			</div>
			<div class="panel-body">
			@if(! is_null($plan))
				<h3>
					{{$plan->plan_name}}
				</h3>
				@if($plan->plan_type == LIMITED )
				<table class='table'>
				<tr>
					<th>Time Bal</th>
					<th>Data Bal</th>
				</tr>
					<tr>
						<td>
							@if($plan->limit_type == TIME_LIMIT || $plan->limit_type == BOTH_LIMITS)
								{{formatTime($plan->time_limit)}}
							@else
								N/A
							@endif
						</td>
						<td>
							@if($plan->limit_type == DATA_LIMIT || $plan->limit_type == BOTH_LIMITS)
								{{formatBytes($plan->data_limit)}}
							@else
							@endif
						</td>
					</tr>
				</table>
				@endif
			@else
			<h3>No Active Services</h3>
			@endif
			</div>
		</div>
		@if( ! is_null($plan) )
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Service Expiry</h4>
			</div>
			<div class="panel-body">
					<h5>
						{{$plan->expiration}}
					</h5>
			</div>
		</div>
		@endif
	</div>
</div>

@stop