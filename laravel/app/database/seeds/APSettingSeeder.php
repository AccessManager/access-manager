<?php
class APSettingSeeder extends Seeder {

	public function run()
	{
		$this->_seedAPSettings();
	}

	private function _seedAPSettings()
	{
		APSetting::truncate();
		APSetting::insert([
			   'payment_due_in_days'		=>		15,
			  'disconnection_status'		=>		0,
				'disconnection_days'		=>		15,
		 'due_amount_penalty_status'		=>		15,
		'due_amount_penalty_minimum'		=>		100,
		'due_amount_penalty_percent'		=>		2,
		 			  'plan_taxable'		=>		1,
		 			 'plan_tax_rate'		=>		14.28,
			]);
	}
}
//end of file APSettingSeeder.php