<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_settings', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('payment_due_in_days')->unsigned();
			$t->boolean('disconnection_status');
			$t->integer('disconnection_days')->unsigned();
			$t->boolean('due_amount_penalty_status');
			$t->integer('due_amount_penalty_minimum')->unsigned();
			$t->float('due_amount_penalty_percent');
			$t->boolean('plan_taxable');
			$t->float('plan_tax_rate');
		});

		Schema::create('ap_user_settings', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->insigned();
			$t->boolean('percent_check');
			$t->float('percent');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_settings');
		Schema::dropIfExists('ap_user_settings');
	}

}
