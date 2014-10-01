@extends('admin.header_footer')
@section('admin_container')
<div class="row">
	<div class="col-lg-6">
		<h2>{{{$profile->uname}}}</h2>
	</div>
	<!-- <div class="col-lg-6">
		<ul class="nav nav-pills pull-right" style='margin-top: 25px;'>
		  <li class="active"><a href="#">Profile</a></li>
		  <li><a href="#">IP Addresses</a></li>
		</ul>
	</div> -->
</div>
<!-- <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
          <h2> 
            {{$profile->uname}}
            {{link_to_route('subscriber.index', 'Back to Accounts Listing', NULL, ['class'=>'btn btn-default navbar-right'])}}
          </h2>
    </div>
</div> -->

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li>
    {{link_to_route('subscriber.profile','User Profile', $profile->id)}}
</li>
  <li class="active"><a>Active Services</a></li>
</ul>
<div class="row">
	<div class="col-lg-9">
		<div class="panel panel-default">
		  <div class="panel-body">
            <div class="row">
                @if(count($plans))
                {{Form::open(['route'=>'subscriber.assign','class'=>'form-inline','role'=>'form'])}}
                {{Form::hidden('user_id', $profile->id)}}
                <div class="col-lg-10 col-lg-offset-2">
                    <div class="form-group col-lg-6 {{Form::error($errors, 'plan')}}">
                      <label for="select" class="col-lg-5 control-label">Select Plan</label>
                          <div class="col-lg-3">
                            {{Form::select('plan_id', $plans, NULL, ['class'=>'form-control'])}}
                            {{$errors->first('plan',"<span class='help-block'>:message</span>")}}
                        </div>
                    </div>
                    <div class="fom-group col-lg-6">
                        {{Form::submit('Assign Plan', ['class'=>'form-control btn-primary'])}}
                    </div>
                </div>
                {{Form::close()}}
                @else
                <label for="" class='col-lg-6 col-lg-offset-4'>Please {{link_to_route('plan.add.form','create a service plan')}} first.</label>
                @endif
            </div>
            <hr>
            <div class="row all" id='profile'>
                <div class="col-lg-6">
                    <!-- <blockquote class=""> -->
                        <div class="row">
                            <div class="col-lg-1">
                                <h5>
                                    <i class="fa fa-home"></i>
                                </h5>
                            </div>
                            <div class="col-lg-11">
                                <h5>{{$profile->address}}
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <h5>
                                    <i class="fa fa-envelope"></i>
                                </h5>
                            </div>
                            <div class="col-lg-11">
                                <h5>
                                    <a href="mailto:{{$profile->email}}">
                                        {{$profile->email}}
                                    </a>
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <h5>
                                    <i class="fa fa-phone"></i>
                                </h5>
                            </div>
                            <div class="col-lg-11">
                                <h5>
                                    <a href="tel:{{$profile->contact}}">
                                     {{$profile->contact}}
                                    </a>        
                                </h5>
                            </div>
                        </div>
                    <!-- </blockquote> -->

                </div>
                <div class="col-lg-6">
                    <blockquote class="">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5>
                                    <b>Service Status:</b>
                                </h5>
                            </div>
                            <div class="col-lg-7">
                                <h5>Active</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <h5>
                                    <i class="fa fa-envelope"></i>
                                </h5>
                            </div>
                            <div class="col-lg-11">
                                <h5>
                                    <a href="mailto:{{$profile->email}}">
                                        {{$profile->email}}
                                    </a>
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <h5>
                                    <i class="fa fa-phone"></i>
                                </h5>
                            </div>
                            <div class="col-lg-11">
                                <h5>
                                    <a href="tel:{{$profile->contact}}">
                                     {{$profile->contact}}
                                    </a>        
                                </h5>
                            </div>
                        </div>
                    </blockquote>
                </div>
            </div> <!-- ends profile row inside panel body -->

            <div class="row all hidden" id='reset-password'>
                <div class="col-lg-7 col-lg-offset-2">

                    {{Form::open(['route'=>'subscriber.reset.password','class'=>'form-horizontal'])}}
                    {{Form::hidden('id', $profile->id)}}
                    <div class="form-group">
                        <label for="" class="col-lg-4 control-label">
                            New Password
                        </label>
                        <div class="col-lg-8">
                            {{Form::password('npword', ['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-4 control-label">
                            Confirm Password
                        </label>
                        <div class="col-lg-8">
                            {{Form::password('cpword', ['class'=>'form-control'])}}
                        </div>
                    </div>
                        <div class="form-group">
                          <div class="col-lg-10 col-lg-offset-4">
                                {{Form::buttons()}}
                          </div>
                        </div>
                    {{Form::close()}}
                </div>
            </div> <!-- ends reset password row inside panel body -->

            <!-- <div class="row all hidden" id='refill'>
                <div class="col-lg-12">
                    <h1>Refill (Manually)</h1>
                </div>
            </div> --> <!-- ends refill row inside panel body -->

		  </div> <!-- ends panel body -->
		</div> <!-- ends panel-default -->
	</div>
        <div class="col-lg-3">
        	<ul class="nav nav-pills nav-stacked" style="max-width: 300px;">
        		<li class="profile-nav active" target='profile'><a href='#'>
                    <i class="fa fa-angle-double-left"></i>
                    User Profile</a></li>
			  <li class="profile-nav" target='reset-password'><a href='#'>
                <i class="fa fa-angle-double-left"></i>
                Reset Password</a></li>
			  <!-- <li class='profile-nav' target='refill'><a href='#'>
                <i class="fa fa-angle-double-left"></i>
                Refill (Manually)</a></li> -->
			</ul>
        </div>
</div>


@stop