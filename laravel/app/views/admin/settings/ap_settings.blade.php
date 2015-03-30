@extends('admin.settings.setting')
@section('title')
	Advance Paid
@stop
@section('settings_container')
	<div class="row">
        <div class="col-lg-7 col-lg-offset-1">
      {{Form::model($ap,['route'=>['setting.advancepaid'],'class'=>'form-horizontal','role'=>'form'])}}
      {{Form::hidden('id',$ap->id)}}
      {{Form::hidden('disconnection_status', 0)}}
      {{Form::hidden('due_amount_penalty_status', 0)}}
      {{Form::hidden('plan_taxable', 0)}}
      <fieldset>
          <div class="form-group">
            {{Form::label('service_taxable','ServicePlan Taxable',['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::checkbox('plan_taxable',1, FALSE, ['class'=>'checkbox','id'=>'service_taxable',])}}
            </div>
          </div>
          <div class="form-group">
            {{Form::label('service_tax','Tax Rate', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::text('plan_tax_rate', NULL, ['class'=>'form-control','id'=>'service_tax','placeholder'=>'number in %'])}}
            </div>
          </div>
          <div class="form-group">
            {{Form::label('idle', 'Payment Due In Days', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::text('payment_due_in_days', NULL, ['class'=>'form-control','id'=>'idle','placeholder'=>'number of days'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('self-registration', 'Disconnect in Non Payment', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::checkbox('disconnection_status', 1, false, ['class'=>'checkbox','id'=>'self-registration'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('disconnect', 'Disconnect after days:', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::text('disconnection_days', NULL, ['class'=>'form-control','id'=>'disconnect','placeholder'=>'number of days from Invoicing'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('plenty_after_days', 'Penalty after due date', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::checkbox('due_amount_penalty_status', 1, false, ['class'=>'checkbox','id'=>'plenty_after_days'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('min_plenty', 'Minimum Penalty', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::text('due_amount_penalty_minimum', NULL, ['class'=>'form-control','id'=>'min_plenty','placeholder'=>'minimum penalty'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('plenty_percent', 'Penalty Percent', ['class'=>'col-lg-4 control-label'])}}
            <div class="col-lg-8">
              {{Form::text('due_amount_penalty_percent', NULL, ['class'=>'form-control','id'=>'plenty_percent','placeholder'=>'% of invoice amount as penalty'])}}
            </div>
        </div>
      <div class="form-group">
            <div class="col-lg-10 col-lg-offset-5">
              {{Form::buttons()}}
            </div>
          </div>
          {{Form::close()}}
        </fieldset>
        </div>
      </div>

@stop