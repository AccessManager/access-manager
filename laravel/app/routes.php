<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('json/get-ip-list/{id}',[
	'as'	=>		'subnet.ip.list',
				function($subnet_id){
							$list = SubnetIP::where('subnet_id',$subnet_id)
											->whereNull('user_id')
											->lists('ip','id');
							foreach($list as $id => $ip) {
								$ips[$id] = long2ip($ip);
							}
							return Response::json($ips);
						}
	]);

Route::get('send-email','SystemController@sendEmail');

Route::get('/',[
	'as'	=>		'welcome.user',
	function(){
		return Redirect::route('user.panel');
	}]);

Route::get('admin',[
	'as'	=>		'welcome.admin',
	function(){
		return Redirect::to('admin-panel');
	}]);

Route::get('admin/login',[
	'as'		=>		'admin.login.form',
	'uses'		=>		'LoginController@getAdmin',
	]);

Route::post('admin/login',[
	'as'		=>		'admin.login',
	'uses'		=>		'LoginController@postAdmin',
	]);

Route::get('internet/login',[
	'as'		=>		'internet.login.form',
	'uses'		=>		'LoginController@getInternetLogin'
	]);

Route::post('internet/login',[
	'as'		=>		'internet.login',
	'uses'		=>		'LoginController@postInternetLogin'
	]);
Route::post('internet/authorize',[
	'as'		=>		'internet.login.authorize',
	'uses'		=>		'LoginController@postAuthorizeInternetLogin',
	]);
Route::get('user/self-registration',[
	'as'		=>		'user.selfregistration.form',
	'uses'		=>		'LoginController@getSelfRegister'
	]);
Route::post('user/self-registration',[
	'as'		=>		'user.selfregistration',
	'uses'		=>		'LoginController@postSelfRegister'
	]);

Route::controller('/login','LoginController',[
	'getIndex'		=>		'user.login.form',
	'postLogin'		=>		'user.login',
	]);


/**
 * user_routes.php cotains all routes related to user accounts.
 */
require_once __DIR__ . '/user_routes.php';

// Route::group(['prefix'=>'user-panel','before'=>'isUser'], function(){
	

// 	Route::get('/',function(){
// 		return Redirect::route('user-panel');
// 	});

// 	Route::get('logout',[
// 		'as'	=>		'user.logout',
// 		function(){
// 			Auth::logout();
// 			return Redirect::route('user.login.form');
// 		}]);

// 	Route::controller('my-account','UserController',[
// 			  'getIndex'   =>	'user-panel',
// 		  	 'getRecharge' =>	'user.recharge.form',
// 		 	'postRecharge' =>	'user.recharge',
//      'getRechargeHistory'  =>	'user.recharge.history',
// 	  'getSessionHistory'  =>	'user.session.history',
// 	  'getChangePassword'  =>	'user.password.form',
// 	  'postChangePassword' =>	'user.changepassword',
// 		]);
// });


/**
 * Prefix all the routes to Admin Panel with /admin-panel/
 */
Route::group( ['prefix'=>'admin-panel',
	'before'=>'isAdmin'
	], function() {

	Route::get('/',[
		'as'	=>		'admin-panel',
		function(){
			return Redirect::route('subscriber.active');
		}]);

	Route::get('clear-stale-sessions', [
		'as'	=>		'clear-stale-sessions',
		'uses'	=>		'AccountsController@clearStaleSessions',
		]);

	Route::get('logout',[
		'as'	=>		'admin.logout',
		function(){
			Auth::logout();
			Session::flash('success', "Logout Successful.");
			return Redirect::route('admin.login');
		}]);
	Route::get('system/about',[
		'as'	=>		'system.about',
		'uses'	=>		'SystemController@about'
		]);

Route::controller('bandwidth-policies', 'PoliciesController', [
			'getIndex'  =>	'policies.index',
			'getAdd'	=>	'policy.add.form',
			'postAdd'	=>	'policy.add',
			'getEdit'	=>	'policy.edit.form',
			'postEdit'	=>	'policy.edit',
			'postDelete'=>	'policy.delete',
	]);

Route::controller('policy-schemas', 'SchemasController',[
			'getIndex'		=>		'schema.index',
			'getAdd'		=>		'schema.add.form',
			'postAdd'		=>		'schema.add',
			'getEdit'		=>		'schema.edit.form',
			'postEdit'		=>		'schema.edit',
			'postDelete'	=>		'schema.delete',

			'getTemplateIndex'	=>		'schematemplate.index',
			'getAddTemplate'	=>		'schematemplate.add.form',
			'postAddTemplate'	=>		'schematemplate.add',
			'getEditTemplate'	=>		'schematemplate.edit.form',
			'postEditTemplate'	=>		'schematemplate.edit',
			'postDeleteTemplate'	=>	'schematemplate.delete',
	]);

Route::controller('subscribers', 'AccountsController',[
			'getIndex'			=>		'subscriber.index',
			'getAdd'			=>		'subscriber.add.form',
			'postAdd'			=>		'subscriber.add',
			'getEdit'			=>		'subscriber.edit.form',
			'postEdit'			=>		'subscriber.edit',
			'postDelete'		=>		'subscriber.delete',
			'getActive'			=>		'subscriber.active',
			'getProfile'		=>		'subscriber.profile',
			'getActiveServices'	=>		'subscriber.services',
			'getAssignPlan'		=>		'subscriber.assign.form',
			'postAssignPlan'	=>		'subscriber.assign',
			'postResetPassword'	=>		'subscriber.reset.password',
			'postRefill'		=>		'subscriber.refill',
			'getAssignIP'		=>		'subscriber.ip.form',
			'postAssignIP'		=>		'subscriber.ip',
			'getAssignRoute'	=>		'subscriber.route.form',
			'postAssignRoute'	=>		'subscriber.route',
			'getChangeServiceType'	=>	'subscriber.servicetype.form',
			'postChangeServiceType'	=>	'subscriber.servicetype',
			'postSearch'		=>		'subscriber.search',
			'postDisconnect'	=>		'subscriber.disconnect',
			'postAPSettings'	=>		'subscriber.ap.settings',
			'getTransactions'	=>		'subscriber.ap.transactions',
			'postAddTransaction'=>		'subscriber.ap.addTransaction',
	]);

Route::controller('products', 'UserProductsController',[
			'postAddRecurringProduct'		=>		'subscriber.product.add.recurring',
			'postAddNonRecurringProduct'	=>		'subscriber.product.add.nonrecurring',
			'postEditRecurringProduct'		=>		'product.edit.recurring',
			'postEditNonRecurringProduct'	=>		'product.edit.nonrecurring',
			'postDeleteRecurringProduct'	=>		'product.delete.recurring',
			'postDeleteNonRecurringProduct'	=>		'product.delete.nonrecurring',
	]);

Route::controller('prepaid-vouchers','VouchersController',[
			'getIndex'			=>		'voucher.index',
			'getGenerate'		=>		'voucher.generate.form',
			'postGenerate'		=>		'voucher.generate',
			'getRecharge'		=>		'voucher.recharge.form',
			'postRecharge'		=>		'voucher.recharge',
			'postSelectTemplate'=>		'voucher.handle',
			'postPrint'			=>		'voucher.print',
	]);

Route::controller('refill-coupons','RefillController',[
			'getIndex'			=>		'refill.index',
			'getGenerate'		=>		'refill.generate.form',
			'postGenerate'		=>		'refill.generate',
			'getRecharge'		=>		'refill.recharge.form',
			'postRecharge'		=>		'refill.recharge',
			'postSelectTemplate'=>		'refill.handle',
			'postPrint'			=>		'refill.print',
	]);

Route::controller('service-plans','ServicePlansController',[
			'getIndex'			=>		'plan.index',
			'getAdd'			=>		'plan.add.form',
			'postAdd'			=>		'plan.add',
			'getEdit'			=>		'plan.edit.form',
			'postEdit'			=>		'plan.edit',
			'postDelete'		=>		'plan.delete',
			'getFreePlan'		=>		'plan.free.form',
			'postFreePlan'		=>		'plan.free',
	]);

Route::controller('routers','RoutersController',[
			'getIndex'			=>		'router.index',
			'getAdd'			=>		'router.add.form',
			'postAdd'			=>		'router.add',
			'getEdit'			=>		'router.edit.form',
			'postEdit'			=>		'router.edit',
			'postDelete'		=>		'router.delete',
	]);


Route::controller('subnet','SubnetController',[
			'getIndex'			=>		'subnet.index',
			'getAddSubnet'		=>		'subnet.add.form',
			'postAddSubnet'		=>		'subnet.add',
			'getEditSubnet'		=>		'subnet.edit.form',
			'postEditSubnet'	=>		'subnet.edit',
			'postDeleteSubnet'	=>		'subnet.delete',
			'getAssignIP'		=>		'subnet.assignip.form',
			'postAssignIP'		=>		'subnet.assignip',
			'getAssignRoute'	=>		'subnet.assignroute.form',
			'postAssignRoute'	=>		'subnet.assignroute',
			'getDeleteIp'		=>		'subnet.delete.ip',
			'getDeleteRoute'	=>		'subnet.delete.route',
			'getUsedIPs'		=>		'subnet.usage'
	]);

Route::controller('templates','TemplatesController',[
			'getVoucherTemplates'	=>	'tpl.voucher.index',
			'getAddVoucherTemplate'	=>	'tpl.voucher.add.form',
			'postAddVoucherTemplate' =>	'tpl.voucher.add',
			'getEditVoucherTemplate' =>	'tpl.voucher.edit.form',
			'postEditVoucherTemplate' => 'tpl.voucher.edit',
			'postDeleteVoucherTemplate' => 'tpl.voucher.delete',

			'getEmailTemplates'		=>		'tpl.email.index',
			'getAddEmailTemplate'	=>		'tpl.email.add.form',
			'postAddEmailTemplate'	=>		'tpl.email.add',
			'getEditEmailTemplate'	=>		'tpl.email.edit.form',
			'postEditEmailTemplate'	=>		'tpl.email.edit',
			'postDeleteEmailTemplate'	=>	'tpl.email.delete',
	]);
Route::controller('settings','SettingsController',[
			'getGeneral'		=>		'setting.general.form',
			'postGeneral'		=>		'setting.general',
			'getEmail'			=>		'setting.email.form',
			'postEmail'			=>		'setting.email',
			'getSmtp'			=>		'setting.smtp.form',
			'postSmtp'			=>		'setting.smtp',
			'getPaypal'			=>		'setting.paypal.form',
			'postPaypal'		=>		'setting.paypal',
			'getDirecpay'		=>		'setting.direcpay.form',
			'postDirecpay'		=>		'setting.direcpay',
			'getThemes'			=>		'setting.themes.form',
			'postThemes'		=>		'setting.themes',
			'getAdvancepaid'	=>		'setting.advancepaid.form',
			'postAdvancepaid'	=>		'setting.advancepaid'

	]);

Route::controller('organisations','OrganisationsController',[
			'getIndex'			=>		'org.index',
			'getAdd'			=>		'org.add.form',
			'postAdd'			=>		'org.add',
			'getEdit'			=>		'org.edit.form',
			'postEdit'			=>		'org.edit',
			'postDelete'		=>		'org.delete'
	]);

Route::controller('my-profile','AdminProfileController',[
			'getEdit'			=>		'admin.profile.edit',
			'postEdit'			=>		'admin.profile',
			'getChangePassword'	=>		'admin.changepassword.form',
			'postChangePassword'=>		'admin.changepassword',
	]);
	

}); //ends Admin Prefix.

/**
 * Registering Form Macros.
 */
Form::macro('helpBlock',function($string){
	return "<span class='help-block'>$string</span>";
});

Form::macro('error', function($errors, $field){
  if( $errors->has($field) )
    return 'has-error';
  return NULL;
});

Form::macro('edit', function($path,$value = 'update'){
	return "<a href='{$path}' class='btn btn-xs btn-default'>
                <i class='fa fa-edit'></i> {$value}</a>";
});

Form::macro('delete', function($value = 'delete'){
	return "<button type='submit' class='btn btn-xs btn-danger'>
	<i class='fa fa-trash-o'></i> {$value}
	 </button>";
});

Form::macro('actions', function ($edit_path, $del_path, $edit='update', $delete='delete'){
	return	Form::open(['url'=>$del_path,'onsubmit'=>"return confirm('Do you really want to delete?')"]).
	 "<a href='{$edit_path}' class='btn btn-xs btn-default'>
                <i class='fa fa-edit'></i> {$edit}</a>" .
                "<button type='submit' class='btn btn-xs btn-danger'>
	<i class='fa fa-trash-o'></i> {$delete}
	 </button>" .
	 Form::close();
});

Form::macro('buttons', function($submit = 'Save Changes'){
	return "<div class='btn-toolbar'>
          <div class='btn-group'>" .
          Form::button('Reset', ['type'=>'reset','class'=>'btn btn-default']) .
          Form::submit($submit,['class'=>'btn btn-primary']) .
          "</div>
        </div>";
});


//end of file routes.php