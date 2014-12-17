<?php

Route::group(['prefix'=>'user-panel','before'=>'isUser'],function(){

	Route::get('/',function(){
		return Redirect::route('user.panel');
	});

	Route::get('login',[
		'as'		=>		'user.panel',
		function(){
			$user = Auth::user();
			switch( $user->plan_type ) {
				case PREPAID_PLAN :
					return Redirect::route('prepaid.dashboard');
				break;
				case ADVANCEPAID_PLAN :
					return Redirect::route('advancepaid.dashboard');
				break;
				case FREE_PLAN :
					return Redirect::route('frinternet.dashboard');
				break;
			}
		}]);

	Route::get('logout',[
		'as'		=>		'user.logout',
		function(){
				Auth::logout();
				return Redirect::route('user.login.form');
		}]);

	Route::get('change-password',[
		'as'		=>		'user.password.form',
		'uses'		=>		'UserController@getChangePassword',
		]);

	Route::post('change-password',[
		'as'		=>		'user.change.password',
		'uses'		=>		'UserController@postChangePassword',
		]);

});

Route::group(['prefix'=>'prepaid-panel','before'=>'isPrepaidUser'], function(){

	Route::get('/',function(){
		return Redirect::route('prepaid.dashboard');
	});

	Route::get('dashboard',[
		'as'		=>		'prepaid.dashboard',
		'uses'		=>		'PrepaidUserController@dashboard',
		]);
	Route::get('recharge',[
		'as'		=>		'prepaid.recharge.form',
		'uses'		=>		'PrepaidUserController@getRecharge',
		]);
	Route::post('recharge',[
		'as'		=>		'prepaid.recharge',
		'uses'		=>		'PrepaidUserController@postRecharge',
		]);
	Route::get('refill',[
		'as'		=>		'prepaid.refill.form',
		'uses'		=>		'PrepaidUserController@getRefill',
		]);
	Route::get('recharge-history',[
		'as'		=>		'prepaid.recharge.history',
		'uses'		=>		'PrepaidUserController@getRechargeHistory',
		]);
	Route::get('session-history',[
		'as'		=>		'prepaid.session.history',
		'uses'		=>		'PrepaidUserController@getSessionHistory'
		]);

});

Route::group(['prefix'=>'advancepaid-panel','before'=>'isAdvanceUser'], function(){

	Route::get('dashboard',[
		'as'		=>		'advancepaid.dashboard',
		'uses'		=>		'AdvanceUserController@dashboard',
		]);
	Route::get('session-history',[
		'as'		=>		'advancepaid.session.history',
		'uses'		=>		'AdvanceUserController@sessionHistory',
		]);
});

Route::group(['prefix'=>'frinternet-panel','before'=>'isFreeUser'], function(){

	Route::get('dashbord',[
		'as'	=>		'free.dashboard',
		'uses'	=>		'FreeUserController@dashboard',
		]);
});

Route::group(['prefix'=>'online-recharge','before'=>'isRechargeable'], function(){
	
	Route::post('select-payment-gateway',[
		'as'		=>		'recharge.select.pg',
		'uses'		=>		'OnlineRechargeController@selectPaymentGateway',
		]);
	Route::post('initiate-online-recharge',[
		'as'		=>		'initiate.online.recharge',
		'uses'		=>		'OnlineRechargeController@initiateOnlineRecharge'
		]);
	Route::post('online-recharge-direcpay-success',[
		'as'		=>		'direcpay.recharge.success',
		'uses'		=>		'DirecpayController@rechargeSuccess',
		]);
	Route::post('online-recharge-direcpay-failed',[
		'as'		=>		'direcpay.recharge.failure',
		'uses'		=>		'DirecpayController@rechargeFailure'
		]);
});

//end of file user_routes.php