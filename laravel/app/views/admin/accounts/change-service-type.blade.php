@extends('admin.header_footer')
@section('admin_container')
<div class="row">
	<div class="col-lg-6">
		<h2>{{{$profile->uname}}}</h2>
	</div>
</div>
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
                            ({{{$profile->uname}}})
                        : Change Service Type
                    </h2>
                        
                </div>
            </div>
            <hr>
            <div class="row all" id='profile'>
                <div class="col-lg-7 col-lg-offset-2">
                    {{Form::open(['class'=>'form-horizontal'])}}
                    {{Form::hidden('user_id', $profile->id)}}
                <fieldset>
                    <div class="form-group">
                        <label for="" class="col-lg-4 control-label">Service Type</label>
                        <div class="col-lg-8">
                            {{Form::select('plan_type', [FREE_PLAN => 'FRiNTERNET',ADVANCEPAID_PLAN => "Advance Paid",PREPAID_PLAN => 'Prepaid'], NULL, ['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class='col-lg-4 control-label'>Organisation</label>
                        <div class="col-lg-8">
                            {{Form::select('org_id',$orgs,NULL,['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class='col-lg-4 control-label'>Bill Duration Type</label>
                        <div class="col-lg-8">
                            {{Form::select('bill_duration_type',['1'=>'Cycle','2'=>'Full'],BILL_DURATION_FULL,['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group {Form::error($errors,'billing_cycle')}} {{Form::error($errors,'billing_cycle')}}">
                      <label for="inputEmail" class="col-lg-4 control-label">Bill Cycle</label>
                      <div class="col-lg-5">
                        {{Form::text("billing_cycle", NULL, ['class'=>'form-control','placeholder'=>'e.g. 1 Month, 3 Months'])}}
                        {{$errors->first('billing_cycle',"<span class='help-block'>:message</span>")}}
                      </div>
                      <div class="col-lg-3">
                        {{Form::select("billing_unit", ['Months'=>'Months'], NULL, ['class'=>'form-control'])}}
                      </div>
                  </div>
                  <div class="form-group">
                        <label for="" class="col-lg-4 control-label">Raise Invoice On</label>
                        <div class="col-lg-8">
                            {{Form::select('bill_date', array_combine( range(1, 28), range(1, 28) ), NULL, ['class'=>'form-control'])}}
                        </div>
                    </div>
                  <div class="form-group">
                        <label for="" class="col-lg-4 control-label">Contract Expires</label>
                        <div class="col-lg-8">
                            {{Form::text('expiration', NULL, ['class'=>'form-control','placeholder'=>'e.g. September 30, 2015','id'=>'datepicker','data-date-format'=>"YYYY-MM-DD"])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-5">
                            {{Form::buttons()}}
                        </div>
                    </div>
                </fieldset>
                {{Form::close()}}
                </div>
            </div> <!-- ends profile row inside panel body -->

		  </div> <!-- ends panel body -->
		</div> <!-- ends panel-default -->
	</div>
        <div class="col-lg-3">
        	<ul class="nav nav-pills nav-stacked" style="max-width: 300px;">
        		<li class="profile-nav active" target='profile'><a href='#'>
                    <i class="fa fa-angle-double-left"></i>
                    Change Service Type</a></li>
			</ul>
        </div>
</div>

@stop