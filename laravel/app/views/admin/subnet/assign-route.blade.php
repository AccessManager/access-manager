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
	<div class="col-lg-9">
		<div class="panel panel-default">
		  <div class="panel-body">
            <div class="row">
                {{Form::open(['route'=>'subnet.assignroute','class'=>'form-inline','role'=>'form'])}}
                {{Form::hidden('user_id', $profile->id)}}
                <div class="col-lg-10 col-lg-offset-2">
                    <div class="form-group col-lg-6 {{Form::error($errors, 'subnet')}}">
                      <label for="select" class="col-lg-5 control-label">New Route</label>
                      <div class="col-lg-3">
                        {{Form::text('subnet', NULL, ['class'=>'form-control','placeholder'=>"e.g. 192.168.1.8/30"])}}
                        {{$errors->first('subnet',"<span class='help-block'>:message</span>")}}
                    </div>
                </div>
                <div class="fom-group col-lg-6">
                    {{Form::submit('Assign Route', ['class'=>'form-control btn-primary'])}}
                </div>
                </div>
                {{Form::close()}}
            </div>
		  </div> <!-- ends panel body -->
		</div> <!-- ends panel-default -->
	</div>
</div>
@stop