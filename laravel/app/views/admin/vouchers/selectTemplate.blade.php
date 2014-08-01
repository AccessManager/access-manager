@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>       Select Template      
              {{link_to_route('voucher.index', 'Back to Vouchers List', NULL, ['class'=>'btn btn-default pull-right'])}}
        </h2>
    </div>
    
</div>

            <hr />
<div class="row">
	<div class="col-lg-2"></div>
	<div class="col-lg-7">
{{Form::open(['route'=>'voucher.print','class'=>'form-horizontal','role'=>'form','target'=>'_blank',])}}

<fieldset>
	<div class="form-group">
      <label for="select" class="col-lg-4 control-label">Select Template</label>
      <div class="col-lg-8">
        {{Form::select('template', $templates, NULL, ['class'=>'form-control'])}}
    </div>
</div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-4 control-label">Voucher Per Row</label>
      <div class="col-lg-8">
        {{Form::text('count',NULL, ['class'=>'form-control','placeholder'=>'how many vouchers in a row?'])}}
      </div>
  </div>
    
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-6">
        {{Form::buttons('Print')}}
      </div>
    </div>
        {{Form::close()}}
</fieldset>

</div>
</div>
@stop