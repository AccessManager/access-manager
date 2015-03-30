<?php

Class DefaultsSeeder extends Seeder {

	public function run()
	{
		$this->_seedSubscribers();
		$this->_seedThemes();
		$this->_seedSettings();
	}

	private function _seedSubscribers()
	{
		$accounts = [
			[
					 'uname'	=>		'admin',
					 'pword'	=>		Hash::make('123456'),
				 'plan_type'	=>		1,
			   'clear_pword'	=>		'123456',
				  	 'fname'	=>		'Admin',
					'status'	=>		1,
				  'is_admin'	=>		1,
				'created_at'	=>		date('Y-m-d H:i:s'),
				'updated_at'	=>		date('Y-m-d H:i:s'),
			],
			[
					 'uname'	=>		'demo',
			   'clear_pword'	=>		'123456',
					 'pword'	=>		Hash::make('123456'),
				 'plan_type'	=>		1,
				   	 'fname'	=>		'Demo',
					'status'	=>		1,
				  'is_admin'	=>		0,
				'created_at'	=>		date('Y-m-d H:i:s'),
				'updated_at'	=>		date('Y-m-d H:i:s'),
			],
		];
		Subscriber::truncate();
		Subscriber::insert($accounts);
	}

	private function _seedSettings()
	{
		GeneralSettings::truncate();
		   SmtpSettings::truncate();
		 PaypalSettings::truncate();

		GeneralSettings::insert([
				'idle_timeout'		=>		0,
				'self_signup'		=>		0,
			]);
		SmtpSettings::insert([
				'status'		=>		0,
			]);
		PaypalSettings::insert([
				'status'		=>		0,
				'sandbox'		=>		0,
			]);
		DirecpaySetting::insert([
				'status'		=>		0,
				'sandbox'		=>		0,
			]);
		
	}

	private function _seedThemes()
	{
		Theme::truncate();
		Theme::insert([
					'admin_theme'	=>		12,
					'user_theme'	=>		10,
			]);
	}
}