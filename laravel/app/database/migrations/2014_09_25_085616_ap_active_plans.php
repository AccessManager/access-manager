<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApActivePlans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_active_plans', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->timestamp('assigned_on');
			$t->string('plan_name');
			$t->tinyInteger('plan_type');
			$t->integer('limit_id')->unsigned()->nullable();
			$t->enum('policy_type',['Policy','PolicySchema']);
			$t->integer('policy_id')->unsigned();
			$t->integer('sim_sessions')->unsigned();
			$t->integer('interim_updates')->unsigned();
			$t->bigInteger('time_balance')->nullable()->default(0);
			$t->bigInteger('data_balance')->nullable()->default(0);
			$t->boolean('aq_invocked');
			$t->integer('active_tpl')->unsigned()->nullable();
			$t->float('price');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_active_plans');
	}

}
