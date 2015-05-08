@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h2>
          @if(isset($router))
          Modify Router
          @else
          Create Router
          @endif
        {{link_to_route('router.index', 'Back to Routers Listing', NULL, ['class'=>'btn btn-default navbar-right'])}}
        </h2>
    </div>
</div>

            <hr />
<div class="row">
	<div class="col-lg-2"></div>
	<div class="col-lg-7">
@if(isset($router))
{{Form::model($router,['route'=>['router.edit',$router->id],'class'=>'form-horizontal','role'=>'form',])}}
{{Form::hidden('id', $router->id)}}
@else
{{Form::open(['class'=>'form-horizontal','role'=>'form','route'=>'router.add'])}}
@endif
<fieldset>
    <div class="form-group">
          {{Form::label('r_name', 'Router Name',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'shortname')}}">
            {{Form::text('shortname', NULL, ['class'=>'form-control','placeholder'=>'Router Name',])}}
            {{$errors->first('shortname',"<span class=help-block>:message</span>")}}
          </div>
        </div>
        <div class="form-group">
          {{Form::label('r_ip', 'IP Address',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'nasname')}}">
            {{Form::text('nasname', NULL, ['class'=>'form-control','placeholder'=>'IP Address',])}}
            {{$errors->first('nasname',"<span class=help-block>:message</span>")}}
          </div>
        </div>
        <div class="form-group">
          {{Form::label('r_ip', 'Secret',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'policy_name')}}">
            {{Form::text('secret', NULL, ['class'=>'form-control','placeholder'=>'Shared Secret',])}}
            {{$errors->first('secret',"<span class=help-block>:message</span>")}}
          </div>
        </div>
        <div class="form-group">
          {{Form::label('desc', 'Description',['class'=>'col-lg-4 control-label'])}}
          <div class="col-lg-8 {{Form::error($errors, 'policy_name')}}">
            {{Form::textarea('description', NULL, ['class'=>'form-control','placeholder'=>'friendly description','rows'=>4])}}
            {{$errors->first('description',"<span class=help-block>:message</span>")}}
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