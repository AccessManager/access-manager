<?php extract($data); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>User Login - Authorized</title>
	{{HTML::script('public/js/md5.js')}}
	<script type="text/javascript">
	<!--
	    function doLogin() {
	    <?php if(strlen($chapid) < 1) echo "return true;\n"; ?>
		document.sendin.username.value = document.login.username.value;
		document.sendin.password.value = hexMD5('{{$chapid}}' + document.login.password.value + '{{$chapchallenge}}');
		document.sendin.submit();
		return false;
	    }
	//-->
	</script>
</head>
<body>
<p>
	Please wait, while we log you in ...
</p>
	<form name="sendin" action="{{$linkloginonly}}" method="post">
		<input type="hidden" name="username" />
		<input type="hidden" name="password" />
		<input type="hidden" name="dst" value="{{$linkorig}}" />
		<input type="hidden" name="popup" value="true" />
	</form>

	<form name="login" id='login-form' action="{{$linkloginonly}}" method="post" onSubmit="return doLogin()">
     			<input type="hidden" name="dst" value="{{$linkorig}}" />
				<input type="hidden" name="popup" value="true" />
				<input type="hidden" name='username' value='{{$username}}'>
				<input type="hidden" name='password' value='{{$password}}'>
				<input type="submit" value='submit'>

</body>
{{HTML::script('public/js/jquery.2.1.min.js')}}
<script>
	$(function(){
		$('#login-form').submit();
	});
</script>
</html>