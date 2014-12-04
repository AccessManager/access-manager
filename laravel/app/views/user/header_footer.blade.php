
<html>
<head>
	<title>User Panel - Access Manager</title>
	{{HTML::style("public/css/themes/$user_theme.css")}}
	{{HTML::style('public/css/font-awesome.min.css')}}
	{{HTML::style('public/css/alertify.core.css')}}
    {{HTML::style('public/css/alertify-bootstrap3.css')}}
    <style>
		body {
			padding-bottom: 40px;
		}
    </style>
</head>
<body>

	<header>
		<nav class="navbar navbar-inverse">
			<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
		      <span class="icon-bar"></span>
		      <span class="icon-bar"></span>
		      <span class="icon-bar"></span>
		    </button>
		    <a class="navbar-brand" href="#"><b>Access Manager</b></a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
		    <ul class="nav navbar-nav navbar-right">
		      <li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->fname}} {{Auth::user()->lname}}<b class="caret"></b></a>
		        <ul class="dropdown-menu">
		          <li>
					{{link_to_route('user.password.form','Change Password')}}
		          </li>
		          <li><a href="#">My Profile</a></li>
		          <li>{{link_to_route('user.logout', 'Sign Out')}}</li>
		        </ul>
		      </li>
		    </ul>
		  </div>
		  </div>
		</nav>
	</header>


	@yield('sub_header')
	<footer>
		<nav class="navbar navbar-inverse navbar-fixed-bottom">
			<div class="container">
			<div class="navbar-header navbar-right	">
			    <p class="navbar-text">
			    	<a class="navbar-link" href="http://accessmanager.in" target='_blank'>Access Manager</a>
			    	&copy; 2014
			    </p>
			</div>
			</div>
		</nav>
	</footer>
	{{HTML::script('public/js/jquery.2.1.min.js')}}
	{{HTML::script('public/js/boostrap.min.js')}}
	{{HTML::script('public/js/alertify.js')}}
<!-- Show Notifications via alertify.js -->
<script type="text/javascript">
    {{ Notification::showError('
        alertify.error(":message");
    ') }}
 
    {{ Notification::showInfo('
        alertify.log(":message");
    ') }}
 
    {{ Notification::showSuccess('
        alertify.success(":message");
    ') }}
</script>
</body>
</html>