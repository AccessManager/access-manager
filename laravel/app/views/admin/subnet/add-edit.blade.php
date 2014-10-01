@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($subnet))
          Modify subnet
          @else
          Create subnet
          @endif
        {{link_to_route('subnet.index', 'All Subnets', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>

            <hr />
<div class="row">
	<div class="col-lg-2"></div>
	<div class="col-lg-7">
@if(isset($subnet))
{{Form::model($subnet,['route'=>['subnet.edit',$subnet->id],'class'=>'form-horizontal','role'=>'form',])}}
{{Form::hidden('id', $subnet->id)}}
@else
{{Form::open(['class'=>'form-horizontal','role'=>'form','route'=>'subnet.add'])}}
@endif
<fieldset>
    <div class="form-group">
          {{Form::label('subnet', 'Subnet',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'subnet')}}">
            {{Form::text('subnet', NULL, ['class'=>'form-control','placeholder'=>'Valid Subnet (e.g. 192.168.0.0/24)','id'=>'subnet'])}}
            {{$errors->first('subnet',"<span class=help-block>:message</span>")}}
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