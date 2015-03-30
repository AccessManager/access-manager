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
  <li>
	{{link_to_route('subscriber.services','Active Services', $profile->id)}}
  </li>
  <li class="active">
  	<a>Transactions</a>
  </li>
</ul>
<div class="row">
	<div class="col-lg-12">
		<div class="tabbable tabs-right">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href='#all' data-toggle='tab'>
			            <i class="fa fa-angle-double-left"></i>
			            All Transactions
		            </a>
		        </li>
			  	<li>
			        <a href='#add' data-toggle='tab'>
				        <i class="fa fa-angle-double-left"></i>
				        Add Transaction
			        </a>
		    	</li>
		    	<li>
		    		<a href="#settings" data-toggle='tab'>
			        	<i class="fa fa-angle-double-left"></i>
			        	Payment Settings
			        </a>
		    	</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id='all'>
					<div class="row">
						<div class="col-lg-10">
							<table class="table table-striped table-responsive table-hover table-condensed">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Credit</th>
										<th>Debit</th>
										
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
									@if( count($txns) )
										<?php $i = $txns->getFrom(); ?>
										@foreach($txns as $txn)
										<tr>
											<td>{{$i}}</td>
											<td>
												{{$txn->created_at->format('d M y H:i:s')	}}
											</td>
											<td>
												@if( $txn->type == 'cr')
													{{$txn->amount}}
												@endif
											</td>
											<td>
												@if($txn->type == 'dr')
													{{$txn->amount}}
												@endif
											</td>
											<td>
												{{$txn->description}}
											</td>
										</tr>
										<?php $i++; ?>
										@endforeach
									@else
										<td colspan="6">
											No Records Found.
										</td>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-10">
							{{$txns->links()}}
						</div>
					</div>
				</div>
				<div class="tab-pane" id="add">
					<div class="row">
						<div class="col-lg-10">
							<h1>
								Add Transaction
							</h1>
							<hr>
							{{Form::open(['class'=>'form-horizontal','role'=>'form','route'=>'subscriber.ap.addTransaction'])}}
							{{Form::hidden('user_id',$profile->id)}}
								<fieldset>
									<div class="form-group">
										{{Form::label('type','Transaction Type',['class'=>'col-lg-4 control-label'])}}
										<div class="col-lg-4">
											{{Form::select('type',['cr'=>'Credit','dr'=>'Debit'],'cr',['class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										{{Form::label('amount','Amount',['class'=>'col-lg-4 control-label'])}}
										<div class="col-lg-4">
											{{Form::text('amount',NULL,['class'=>'form-control','placeholder'=>'Amount'])}}
										</div>
									</div>
									<div class="form-group">
										{{Form::label('description','Description',['class'=>'col-lg-4 control-label'])}}
										<div class="col-lg-4">
											{{Form::textarea('description',NULL,['class'=>'form-control','placeholder'=>'friendly description','rows'=>3])}}
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-5">
											{{Form::buttons('Submit')}}
										</div>
									</div>
			
								</fieldset>
							{{Form::close()}}
						</div>
					</div>
				</div>
				<div class="tab-pane" id="settings">
					<div class="col-lg-10">
					<h1>Payment Settings</h1>
					<hr>
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

                            <div class="col-lg-4">
                                {{Form::checkbox('percent_check',1,FALSE,['class'=>'checkbox'])}}
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-4 control-label">
                                Percentage
                            </label>
                            <div class="col-lg-4">
                                {{Form::text('percent', NULL, ['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-offset-5">
                                {{Form::buttons()}}
                          </div>
                        </div>
                    </fieldset>
                    
                    {{Form::close()}}
                </div>
				</div>
			</div>
		</div>
	</div>
</div>


@stop