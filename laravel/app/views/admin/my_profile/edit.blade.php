@extends('admin.header_footer')
@section('admin_container')
<?php
// pr($account);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        
          <h2> 
          My Profile
          </h2>
        
    </div>
</div>

            <hr />

<div class="row">
	<div class="col-lg-2"></div>
	<div class="col-lg-7">

{{Form::model($profile,['route'=>['admin.profile',$profile->id],'class'=>'form-horizontal','role'=>'form'])}}
{{Form::hidden('id', $profile->id)}}


<fieldset>
  <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">Username</label>
      <div class="col-lg-8">
      {{Form::text('uname', NULL, ['class'=>'form-control','placeholder'=>"username"])}}
      </div>
  </div>
  <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">Password</label>
      <div class="col-lg-8">
        {{link_to_route('admin.changepassword.form','Change Password')}}
      </div>
  </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">First Name</label>
      <div class="col-lg-8">
        {{Form::text('fname', NULL, ['class'=>'form-control','placeholder'=>"first name"])}}
      </div>
  </div>
  <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">Last Name</label>
      <div class="col-lg-8">
        {{Form::text('lname', NULL, ['class'=>'form-control','placeholder'=>'Last Name'])}}
      </div>
  </div>
    <div class="form-group">
      <label for="email" class="col-lg-3 control-label">Email Address</label>
      <div class="col-lg-8">
        {{Form::text('email', NULL, ['class'=>'form-control','placeholder'=>'your email address'])}}
      </div>
  </div>
  <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">Contact Number</label>
      <div class="col-lg-8">
        {{Form::text('contact', NULL, ['class'=>'form-control','placeholder'=>"contact number"])}}
      </div>
  </div>
  <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">Address</label>
      <div class="col-lg-8">
        {{Form::textarea('address', NULL, ['class'=>'form-control','placeholder'=>"customer's address",'rows'=>'4'])}}
      </div>
  </div>
  <!-- <div class="form-group">
      <label for="select" class="col-lg-3 control-label">Account Status</label>
      <div class="col-lg-8">
        {{Form::select('status', [1=>'Active', 0=>'Deactive'], NULL, ['class'=>'form-control'])}}
    </div>
</div> -->
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