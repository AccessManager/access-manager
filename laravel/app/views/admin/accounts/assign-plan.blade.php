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
                
                <div class="col-lg-12">
                    @if(count($plans))
                    {{Form::open(['route'=>'subscriber.assign','class'=>'form-horizontal','role'=>'form'])}}
                    {{Form::hidden('user_id', $profile->id)}}
                    <fieldset>
                    <div class="form-group {{Form::error($errors, 'plan')}}">
                      <label for="select" class="col-lg-5 control-label">Select Plan</label>
                          <div class="col-lg-3">
                            {{Form::select('plan_id', $plans, NULL, ['class'=>'form-control'])}}
                            {{$errors->first('plan_id',"<span class='help-block'>:message</span>")}}
                        </div>
                    </div>
                    <div class="form-group {{Form::error($errors, 'price')}}">
                        <label for="inputEmail" class="col-lg-5 control-label">Price</label>
                        <div class="col-lg-3">
                          {{Form::text('price', NULL, ['class'=>'form-control','placeholder'=>"plan price"])}}
                          {{$errors->first('price',"<span class='help-block'>:message</span>")}}
                        </div>
                    </div>
                    <div class="form-group">
                          <div class="col-lg-10 col-lg-offset-5">
                            {{Form::buttons('Assign Plan')}}
                          </div>
                        </div>
                    </fieldset>
                    {{Form::close()}}
                    @else
                <label for="" class='col-lg-6 col-lg-offset-4'>Please {{link_to_route('plan.add.form','create a service plan')}} first.</label>
                @endif
                </div>
            </div>

		  </div> <!-- ends panel body -->
		</div> <!-- ends panel-default -->
	</div>
</div>


@stop