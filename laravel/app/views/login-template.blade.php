<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Page</title>
</head>
<body>
	{{Form::open(['route'=>'internet.login.authorize'])}}
		<input type="text" name='username' value=''>
		<input type="text" name='password' value=''>
		<input type="submit" value='Submit'>
		{{Form::close()}}
	{{$error}}
</body>
</html>