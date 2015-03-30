@extends('admin.header_footer')
@section('admin_container')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        
          <h2> 
          @if(isset($account))
           Edit Account 
          @else
          Add Account
          @endif
            {{link_to_route('subscriber.index', 'All Accounts', NULL, ['class'=>'btn btn-default navbar-right'])}}
          </h2>
        
    </div>
</div>
            <hr />
<div class="row">
	<div class="col-lg-2"></div>
	<div class="col-lg-7">

@if(isset($account))
{{Form::model($account,['route'=>['subscriber.edit',$account->id],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('id', $account->id)}}
@else
{{Form::open(['route'=>'subscriber.add','class'=>'form-horizontal','role'=>'form'])}}
@endif

<fieldset>
  
  <div class="form-group {{Form::error($errors, 'uname')}}">
      <label for="inputEmail" class="col-lg-3 control-label">Username</label>
      <div class="col-lg-8  ">
        {{Form::text('uname',NULL,['class'=>'form-control','placeholder'=>'Username'])}}
          {{$errors->first('uname',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  @if( ! isset($account) )
  <div class="form-group  {{Form::error($errors, 'pword')}}">
      <label for="inputEmail" class="col-lg-3 control-label">Password</label>
      <div class="col-lg-8">
        {{Form::password('pword', ['class'=>'form-control','placeholder'=>'password'])}}
        {{$errors->first('pword',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  @endif
    <div class="form-group {{Form::error($errors, 'fname')}}">
      <label for="inputEmail" class="col-lg-3 control-label">First Name</label>
      <div class="col-lg-8">
        {{Form::text('fname', NULL, ['class'=>'form-control','placeholder'=>"first name"])}}
        {{$errors->first('fname',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group  {{Form::error($errors, 'lname')}}">
      <label for="inputEmail" class="col-lg-3 control-label">Last Name</label>
      <div class="col-lg-8">
        {{Form::text('lname', NULL, ['class'=>'form-control','placeholder'=>'Last Name'])}}
        {{$errors->first('lname',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
    
  <div class="form-group  {{Form::error($errors, 'contact')}}">
      <label for="inputEmail" class="col-lg-3 control-label">Contact Number</label>
      <div class="col-lg-8">
        {{Form::text('contact', NULL, ['class'=>'form-control','placeholder'=>"contact number"])}}
        {{$errors->first('contact',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group  {{Form::error($errors, 'email')}}">
      <label for="inputEmail" class="col-lg-3 control-label">Email Address</label>
      <div class="col-lg-8">
        {{Form::text('email', NULL, ['class'=>'form-control','placeholder'=>"email address"])}}
        {{$errors->first('email',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group  {{Form::error($errors, 'address')}}">
      <label for="inputEmail" class="col-lg-3 control-label">Address</label>
      <div class="col-lg-8">
        {{Form::textarea('address', NULL, ['class'=>'form-control','placeholder'=>"customer's address",'rows'=>'4'])}}
        {{$errors->first('address',"<span class='help-block'>:message</span>")}}
      </div>
  </div>
  <div class="form-group {{Form::error($errors, 'status')}}">
      <label for="select" class="col-lg-3 control-label">Account Status</label>
      <div class="col-lg-8">
        {{Form::select('status', [ACTIVE => 'Active', DEACTIVE => 'Deactive', TERMINATED => 'Terminated'], NULL, ['class'=>'form-control'])}}
        {{$errors->first('status',"<span class='help-block'>:message</span>")}}
    </div>
</div>
<div class="form-group">
      <div class="col-lg-10 col-lg-offset-4">
        {{Form::buttons()}}
      </div>
    </div>
    {{Form::close()}}
</fieldset>

</div>
</div>
@stop