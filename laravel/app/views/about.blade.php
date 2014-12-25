@extends('admin.header_footer')

@section('admin_container')
<h1>About</h1>
<hr>
<div class="row">
	<div class="col-lg-3 col-lg-offset-2">
		<div class="thumbnail center-block">
			{{HTML::image('public/img/access_logo.png', 'Access Manager', ['class'=>'img-responsive'])}}
		</div>
	</div>
	<div class="col-lg-4">
		<h1>Access Manager</h1>
		
		<p>
			Free Hotspot Management System
		</p>
		<p>
			v2.4
		</p>
	</div>
	
</div>

@stop