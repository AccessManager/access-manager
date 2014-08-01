<!DOCTYPE html>
<base href="{{Request::root().'/'}}" />
<html ng-app='amAdmin'>
    <head>
        <meta charset="UTF-8">
        <title>Access Manager</title>
        {{HTML::style("public/css/themes/$admin_theme.css")}}
        {{HTML::style('public/css/font-awesome.min.css')}}
        {{HTML::style('public/css/custom.css')}}
        <style>
            body {
                padding-top: 8%;
            }
        </style>
    </head>
    <body>
        <header>
            <nav class="nav navbar-inverse navbar-fixed-top">
                <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href=""><b>Access Manager</b></a>
                </div>

                <div class="navbar-collapse collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="" class="navbar-link">
                            <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="" class="navbar-link">
                            <i class="fa fa-twitter"></i>
                            </a> 
                        </li>
                        <li>
                            <a href="" class="navbar-link">
                            <i class="fa fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-lg-offset-3">
                    <legend>
                        <i class="fa fa-lock"></i>
                        Login Here</legend>
                    <div class="well">
                        {{Form::open(['route'=>'admin.login'])}}
                            <fieldset>
                                <div class="form-group">
                                    <label for="" class="control-label">User Name:  </label>
                                    {{Form::text('uname', 'admin', ['class'=>'col-lg-2 form-control',
                                    'placeholder'=>'username'])}}
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Password:  </label>
                                    {{Form::input('password', 'pword', '123456', ['class'=>'form-control','placeholder'=>'password'])}}
                                    <div class="checkbox">
                                        <label for="remember-me"> 
                                            <input type="checkbox" id='remember-me'>
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <button class="btn btn-block btn-primary">Login</button>
                                <div class="form-group">
                                    <div class="btn-toolbar">
                                        <div class="btn-group pull-right">
                                            <a href="#" class='btn btn-link'>Forgot Password?</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </fieldset>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
       
        <footer>
            <div class="nav navbar navbar-inverse navbar-fixed-bottom">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <p class="navbar-text"><a href="" class="navbar-link">Access Manager</a> &copy; 2014</p>
                    </div>

                </div>
            </div>
        </footer>
{{HTML::script('pubilc/js/jquery.2.1.min.js')}}
{{HTML::script('pubilc/js/boostrap.min.js')}}
<!-- {{HTML::script('js/typeahead.js')}} -->
<!-- {{HTML::script('js/alertify.js')}} -->

<!-- Show Notifications via alertify.js -->
<script type="text/javascript">
    // {{ Notification::showError('
    //     alertify.error(":message");
    // ') }}
 
    // {{ Notification::showInfo('
    //     alertify.log(":message");
    // ') }}
 
    // {{ Notification::showSuccess('
    //     alertify.success(":message");
    // ') }}
</script>


</body>
</html>