<html>
<head>
	<title>User Login - Access Manager</title>
	{{HTML::style("public/css/themes/$user_theme.css")}}
	{{HTML::style('public/css/admin.login.css')}}
</head>
<body>
	<header>
		<div class="nav navbar-inverse navbar-fixed-top">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">Access Manager</a>
			</div>
		</div>
	</header>
	<div class="container">
		@if(Session::has('error'))
			{{Session::get('error', NULL)}}
		@endif
		{{Form::open(['route'=>'user.login','class'=>'form-signin form-horizontal','role'=>'form'])}}
        <h2 class="form-signin-heading">My Account - Login</h2>
        {{Form::text('uname', NULL, ['class'=>"form-control",'placeholder'=>'User Name','required','autofocus'])}}
        {{Form::password('pword', ['class'=>'form-control','placeholder'=>'password'])}}
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        {{Form::close()}}
      <!-- </form> -->
	</div>
	{{HTML::script('public/js/bootstrap.min.js')}}
</body>
</html>