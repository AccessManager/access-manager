<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FreeBalance extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('free_balance', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->string('bw_policy',100);
			$t->tinyInteger('plan_type');
			$t->tinyInteger('limit_type')->nullable();
			$t->integer('time_limit')->unsigned()->nullable();
			$t->enum('time_unit',['Mins','Hrs']);
			$t->bigInteger('time_balance')->nullable();
			$t->integer('data_limit')->nullable();
			$t->enum('data_unit',['MB','GB'])->nullable();
			$t->bigInteger('data_balance')->nullable();
			$t->boolean('aq_access')->nullable();
			$t->string('aq_policy',100)->nullable();
			$t->integer('sim_sessions')->unsigned();
			$t->integer('interim_updates')->unsigned();
			$t->integer('reset_every')->unsigned();
			$t->enum('reset_unit',['Days','Months','Years']);
			$t->timestamp('last_reset_on');
			$t->string('expiration',20);
			$t->boolean('aq_invocked')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('free_balance');
	}

}