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
                @if(count($subnets))
                {{Form::open(['route'=>'subnet.assignip.form','class'=>'form-inline','role'=>'form'])}}
                {{Form::hidden('user_id', $profile->id)}}
                <div class="col-lg-10 col-lg-offset-2">
                    <div class="form-group {{Form::error($errors, 'plan')}}">
                      <label for="select" class="col-lg-5 control-label">Select Subnet</label>
                      <div class="col-lg-3">
                            {{Form::select('subnet_id', $subnets, 0, ['class'=>'form-control','id'=>'subnet'])}}
                            {{$errors->first('subnet_id',"<span class='help-block'>:message</span>")}}
                        </div>
                    </div>
                    <div class="form-group hidden {{Form::error($errors, 'plan')}}" id='ip-div'>
                      <label for="select" class="col-lg-5 control-label">Select Subnet</label>
                      <div class="col-lg-3">
                            {{Form::select('framed_ip', $subnets, NULL, ['class'=>'form-control','id'=>'ip-list'])}}
                            {{$errors->first('framed_ip',"<span class='help-block'>:message</span>")}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::submit('Assign IP', ['class'=>'form-control btn-primary'])}}
                    </div>
                </div>
                {{Form::close()}}
                @else
                <label for="" class='col-lg-6 col-lg-offset-4'>Please {{link_to_route('subnet.add.form','add a subnet')}} first.</label>
                @endif
            </div>
		  </div> <!-- ends panel body -->
		</div> <!-- ends panel-default -->
	</div>
</div>
@stop