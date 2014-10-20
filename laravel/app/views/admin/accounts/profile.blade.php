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
  <li class="active"><a>User Profile</a></li>
  <li>
    {{link_to_route('subscriber.services','Active Services',$profile->id)}}
  </li>
</ul>
<div class="row">
	<div class="col-lg-9">
		<div class="panel panel-default">
		  <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <h2>{{{$profile->fname}}} {{{$profile->lname}}}
                        <!-- <span class="pull-right"> -->
                            <!-- ({{{$profile->uname}}}) -->
                        <!-- </span> -->
                    </h2>
                        
                </div>
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
                                <h5>
                                    {{$profile->status ? 'Active' : 'Deactive'}}
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <h5>
                                    <b>Service Type:</b>
                                </h5>
                            </div>
                            <div class="col-lg-5">
                                <h5>
                                    @if($profile->plan_type == FREE_PLAN)
                                    FRiNTERNET
                                    @elseif($profile->plan_type == PREPAID_PLAN)
                                    Prepaid
                                    @elseif($profile->plan_type == ADVANCEPAID_PLAN)
                                    Advance Paid
                                    @endif
                                </h5>
                            </div>
                            <div class="col-lg-2">
                                <h5>
                                    {{link_to_route("subscriber.servicetype.form",'Change',$profile->id)}}
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

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
  <li class="active"><a href="#session" data-toggle="tab">Recent Sessions</a></li>
</ul>

<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="session">
    <table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Start Time</th>
                                <th>Stop Time</th>
                                <th>Duration</th>
                                <th>Download</th>
                                <th>Upload</th>
                                <th>Total Data Transfer</th>
                                <th>Framed IP</th>
                                <th>MAC Address</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if(count($sess_history))
                            @foreach($sess_history as $session)
                            <tr>
                                <!-- <td>1</td> -->
                                <td>
                                    {{date("d M Y - H:i", strtotime($session->acctstarttime))}}
                                </td>
                                <td>
                                    @if( ! is_null($session->acctstoptime) )
                                    {{date("d M Y - H:i", strtotime($session->acctstoptime))}}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{$session->acctsessiontime}}</td>
                                <td>{{formatBytes($session->acctoutputoctets)}}</td>
                                <td>{{formatBytes($session->acctinputoctets)}}</td>
                                <td>{{formatBytes($session->acctinputoctets + $session->acctoutputoctets)}}</td>
                                <td>{{$session->framedipaddress}}</td>
                                <td>{{$session->callingstationid}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='8'>No Records Found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="row">
                <div class="col-lg12 col-md-12 col-sm-12">
                    {{$sess_history->links()}}
                </div>
            </div>
            <hr>
  </div>
  

@stop