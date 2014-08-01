@extends('user.header_footer')

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
			<div class="panel-body"></div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Quota</h4>
			</div>
			<div class="panel-body"></div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Account Expiry</h4>
			</div>
			<div class="panel-body"></div>
		</div>
	</div>
</div>

@stop