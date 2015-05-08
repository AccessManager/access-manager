<?php

  $dashboard = NULL;
$subscribers = NULL;
    $prepaid = NULL;
   $services = NULL;
  $customize = NULL;
    $network = NULL;
     $system = NULL;

$segment = Request::segment(2);
if( $segment == 'subscribers' && Request::segment(3) == 'active') {
    $dashboard = 'active';
}
if($segment == 'subscribers' && Request::segment(3) != 'active') {
    $subscribers = 'active';
}
if($segment == 'prepaid-vouchers' || $segment == 'refill-coupons') {
    $prepaid = 'active';
}
if($segment == 'service-plans' || $segment == 'bandwidth-policies' || $segment == 'policy-schemas') {
    $services = 'active';
}
if( $segment == 'templates') {
    $customize = 'active';
}
if( $segment == 'routers') {
    $network = 'active';
}
if( $segment == 'settings' ) {
    $system ='active';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Access Manager</title>
        <base href="{{URL::to('/')}}">
        {{HTML::style("public/css/themes/$admin_theme.css")}}
        {{HTML::style('public/css/font-awesome.min.css')}}
        {{HTML::style('public/css/bootstrap-clockpicker.min.css')}}
        {{HTML::style('public/css/alertify.core.css')}}
        {{HTML::style('public/css/alertify-bootstrap3.css')}}
        {{HTML::style('public/css/custom.css')}}
        {{HTML::style('public/css/bootstrap-datetimepicker.min.css')}}
    </head>
    <body>
        <header>
            <nav class="nav navbar-inverse">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{route('subscriber.active')}}"><b>Access Manager</b></a>
                </div>
                
                <div class="navbar-collapse collapse navbar-responsive-collapse">
                    @if( ! is_null(Auth::user()))
                        <ul class="nav navbar-nav  navbar-right">
                            <li>
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                   <i class="fa fa-user"></i> 
                                   {{Auth::user()->fname}} {{Auth::user()->lname}}
                                    <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{route('admin.changepassword.form')}}">
                                        <i class="fa fa-key"></i>
                                        Change Password</a></li>
                                    <li><a href="{{route('admin.profile.edit')}}">
                                        <i class="fa fa-user"></i>
                                        My Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{route('admin.logout')}}">
                                            <i class="fa fa-sign-out"></i>
                                            Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @endif
                </div>
            </nav>

            <nav class="nav navbar-default">
                <div class="navbar-collapse collapse navbar-responsive-collapse">
                    <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li class="{{$dashboard}}">
                            <a href="{{route('subscriber.active')}}">
                                <i class="fa fa-bullseye"></i>
                                Dashboard
                            </a>
                            </li>
                        <li class="{{$subscribers}}">
                            <a href="{{route('subscriber.index')}}">
                                <i class='fa fa-users'></i>
                                Subscribers
                            </a>
                        </li>
                        <li class="dropdown {{$prepaid}}">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tags"></i>
                                Prepaid<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                {{HTML::link(route('voucher.index'), 'Recharge Vouchers')}}
                                </li>
                                <li>
                                    {{link_to_route('refill.index','Refill Coupons')}}
                                </li>
                                <li>{{link_to_route('refill.recharge.form','Refill Account')}}</li>
                                <li>
                                    {{link_to_route('voucher.recharge.form','Recharge Account')}}
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{$services}}">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-codepen"></i>

                                Services<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                {{link_to_route('plan.index','Service Plans')}}
                                </li>
                                <li>
                                    {{link_to_route('plan.free.form','FRiNTERNET')}}
                                </li>
                                <li>
                                    {{link_to_route('policies.index','Bandwidth Policies')}}
                                </li>
                                <li>
                                    {{link_to_route('schema.index','Policy Schemas')}}
                                </li>
                                <li>
                                    {{link_to_route('schematemplate.index','Schema Templates')}}
                                </li>

                            </ul>
                        </li>
                        <li class="dropdown {{$customize}}">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cubes"></i>
                                Customize<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    {{link_to_route('tpl.email.index','Email Templates')}}
                                </li>
                                <li>
                                    {{link_to_route('tpl.voucher.index','Voucher Templates')}}
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{$network}}">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-sitemap"></i>

                                Network<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    {{link_to_route('router.index','Routers')}}
                                </li>
                                <li>
                                    {{link_to_route('subnet.index','IP Subnets')}}
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{$system}}">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-sliders"></i>
                                System<b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">

                                <li class='disabled'>
                                    <a href="">
                                        <!-- <i class="fa fa-database"></i> -->
                                        Backup/Restore
                                    </a>
                                </li>
                                  <li class='disabled'>
                                    <a href="">Groups & Permissions</a>
                                </li>
                                <li>
                                    <a href="{{route('setting.general')}}">
                                    <!-- <i class="fa fa-cogs"></i> -->
                                    Settings</a>
                                </li>
                                <li>
                                    <a href="{{route('setting.general')}}">
                                    Reports</a>
                                </li>
                                <li>
                                    {{link_to_route('org.index','Organisations')}}
                                </li>
                                <li class="divider"></li>
                                <li>
                                    {{link_to_route('system.about','About')}}
                                </li>
                            </ul>
                        </li>
                    </ul> 
                    <!-- <div class=""> -->
                    {{Form::open(['route'=>'subscriber.search'])}}
<div class="input-group" style="margin-top: 5px;">
    {{Form::text('keyword', NULL, ['data-i-search-input'=>'true','class'=>'form-control col-lg-1',
                                    'placeholder'=>'Search by UserName'])}}
    <!-- <input type="text" data-i-search-input="true" class="form-control col-lg-1" name="word" data-autocomplete="true" data-autocomplete-url="" placeholder="search accounts..."> -->
    <span class="input-group-btn">
        <button class="btn btn-default" type="submit">
        <i class="fa fa-search"></i>
        </button></span>
</div>
{{Form::close()}}
<!-- </div> -->
                    </div>
                </div>
            </nav>
            
        </header>
        
            <div class="container">
            @if(Session::has('success'))
            <div class="alert alert-dismissable alert-success in fade">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{Session::get('success')}}
</div>
@elseif(Session::has('error'))
<div class="alert alert-dismissable alert-danger in fade">
  <button type="button" class="close" data-dismiss="alert">×</button>
{{Session::get('error')}}
</div>
@endif
            @yield('admin_container')
        </div>
        <footer>
            <div class="nav navbar navbar-default navbar-fixed-bottom">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <p class="navbar-text"><a href="http://accessmanager.in" target='_blank' class="navbar-link">Access Manager</a> &copy; 2014</p>
                    </div>
                    <div class="navbar-right visible-lg visible-md">
                        <p class="navbar-text">Connect
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="http://facebook.com/ManagerAccess" target="_blank" class="navbar-link">
                            <i class="fa fa-facebook"></i>
                            </a> 
                        </li>
                        <li>
                            <a href="http://twitter.com/AccessManager" target="_blank" class="navbar-link">
                            <i class="fa fa-twitter"></i>
                            </a> 
                        </li>
                        <li>
                            <a href="http://youtube.com/AccessManager" target="_blank" class="navbar-link">
                            <i class="fa fa-youtube"></i>
                            </a>
                        </li>
                    </ul></p>
                    </div>
                </div>
            </div>
        </footer>
{{HTML::script('public/js/jquery.2.1.min.js')}}
{{HTML::script('public/js/boostrap.min.js')}}
{{HTML::script('public/js/schema_template_show_hide.js')}}
{{HTML::script('public/js/plan_show_hide.js')}}

{{HTML::script('public/js/bootstrap-clockpicker.min.js')}}

{{HTML::script('public/js/moment.js')}}
{{HTML::script('public/js/bootstrap-datetimepicker.min.js')}}

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
<!-- below is the script to check/uncheck vouchers. -->
<script>
    $(function(){
        var check = $('#selectAll');
        check.on('click',function(){
            $('.checkbox').each(function(){
                this.checked = check[0].checked;
            })
        })
    })
</script>
<!-- following snippet enables timepicker on schema template form -->
<script type="text/javascript">
$(function(){
    $('.clockpicker').clockpicker({
    placement : 'left',
    align:'top',
    autoclose: true,
    });
})
</script>
<script>
  $(function(){
    var status = $('#status');
    var form = $('.smtp');
    status.on('change',function(){
        
      if( status[0].checked){
          form.removeClass('hidden');
      } else {
          form.addClass('hidden');
      }
    })
  })
</script>
<script tyle='text/javascript'>
    $(function(){
        $('#datepicker').datetimepicker({pickTime:false});
        $('#datepicker').on('dp.change',function(e){
            $('#datepicker').data("DateTimePicker").setMinDate(e.date);
        });
    });
</script>
<script>
    $(function(){
        $('#subnet').on('change',function(){
            var subnet_id = $(this).val();
            var ip_div = $('#ip-div');
            var ip_list = $('#ip-list');

            var promise = $.ajax({
                url : "<?php echo URL::to('json/get-ip-list'); ?>/" + subnet_id,
                method : 'GET',
            }).promise();
            promise.done(function(result){
                if( ! $.isEmptyObject(result) ) {
                    ip_div.removeClass('hidden');
                    ip_list.empty();
                    // ip_list.append("<option value='0'>NONE</option>");
                    $.each(result, function(index, obj){
                        ip_list.append("<option value='"+index+"'>"+obj+"</option>");
                    });
                } else {
                    ip_div.addClass('hidden');
                    ip_list.val(0);
                }
            });
        });
    });
</script>
</body>
</html>