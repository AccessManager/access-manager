<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subscriber Registration</title>
	{{HTML::style('public/css/alertify.core.css')}}
    {{HTML::style('public/css/alertify-bootstrap3.css')}}
	{{HTML::style("public/css/themes/$user_theme.css")}}
	<style>
		body {
			padding-top: 60px;
		}
	</style>
</head>
<body>
	<div class="container">
		<header>
		<div class="nav navbar-inverse navbar-fixed-top">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">Access Manager</a>
			</div>
		</div>
	</header>
	@if( Session::has('success') )
	<div class="row">
		<div class="col-lg-6 col-lg-offset-2">
			<div class="alert alert-dismissable alert-success">
				<p class='text-center'>
				<strong>Registration Successful.</strong>
				{{link_to_route('welcome.user','Login to user panel')}}
				to recharge your account now.
				</p>
			</div>
		</div>
	</div>
	@endif
	<div class="row">
		<div class="col-lg-6 col-lg-offset-2">
			{{Form::open(['route'=>'user.selfregistration','class'=>'form-horizontal'])}}
			{{Form::hidden('status',1)}}
		<fieldset>
		<legend>
			<h1>
				Register Yourself.
			</h1>
		</legend>
			<div class="form-group {{Form::error($errors, 'uname')}}">
				<label for="" class="col-lg-4 control-label">
					Username
				</label>
				<div class="col-lg-8">
					{{Form::text('uname', NULL, ['class'=>'form-control','placeholder'=>'choose a username'])}}
					{{$errors->first('uname',"<span class='help-block'>:message</span>")}}
				</div>
			</div>
			<div class="form-group {{Form::error($errors, 'pword')}}">
				<label for="" class="col-lg-4 control-label">
					Password
				</label>
				<div class="col-lg-8">
					{{Form::password('pword', ['class'=>'form-control','placeholder'=>'choose a password'])}}
					{{$errors->first('pword',"<span class='help-block'>:message</span>")}}
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-lg-4 control-label">
					Confirm Password
				</label>
				<div class="col-lg-8">
					{{Form::password('pword_confirmation', ['class'=>'form-control','placeholder'=>'repeat password to confirm'])}}
				</div>
			</div>
			<div class="form-group {{Form::error($errors, 'fname')}}">
				<label for="" class="col-lg-4 control-label">
					First Name
				</label>
				<div class="col-lg-8">
					{{Form::text('fname', NULL, ['class'=>'form-control','placeholder'=>'enter your firstname'])}}
					{{$errors->first('fname',"<span class='help-block'>:message</span>")}}
				</div>
			</div>
			<div class="form-group {{Form::error($errors, 'lname')}}">
				<label for="" class="col-lg-4 control-label">
					Last Name
				</label>
				<div class="col-lg-8">
					{{Form::text('lname', NULL, ['class'=>'form-control','placeholder'=>'enter your lastname'])}}
					{{$errors->first('lname',"<span class='help-block'>:message</span>")}}
				</div>
			</div>
			<div class="form-group  {{Form::error($errors, 'email')}}">
				<label for="" class="col-lg-4 control-label">
					Email
				</label>
				<div class="col-lg-8">
					{{Form::text('email', NULL, ['class'=>'form-control','placeholder'=>'enter your email address'])}}
					{{$errors->first('email',"<span class='help-block'>:message</span>")}}
				</div>
			</div>
			<div class="form-group {{Form::error($errors, 'contact')}}">
				<label for="" class="col-lg-4 control-label">
					Contact Number
				</label>
				<div class="col-lg-8">
					{{Form::text('contact', NULL, ['class'=>'form-control','placeholder'=>'enter your contact number'])}}
					{{$errors->first('contact',"<span class='help-block'>:message</span>")}}
				</div>
			</div>
			<div class="form-group {{Form::error($errors, 'address')}}">
				<label for="" class="col-lg-4 control-label">
					Address
				</label>
				<div class="col-lg-8">
					{{Form::textarea('address', NULL, ['class'=>'form-control','placeholder'=>'enter your physical address','rows'=>6])}}
					{{$errors->first('address',"<span class='help-block'>:message</span>")}}
				</div>
			</div>
			<div class="col-lg-6 col-lg-offset-6">
				{{Form::buttons('Register')}}
			</div>
		</fieldset>
	{{Form::close()}}
		</div>
	</div>
	</div>
	<footer>
		<div class="nav navbar-inverse navbar-fixed-bottom">
			<div class="navbar-right">
				<p class="navbar-text">Access Manager &copy;</p>
			</div>
		</div>
	</footer>
	{{HTML::script('public/js/jquery.2.1.min.js')}}
	{{HTML::script('public/js/bootstrap.min.js')}}
</body>
</html>