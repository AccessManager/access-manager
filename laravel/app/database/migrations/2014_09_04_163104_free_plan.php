<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FreePlan extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('free_plan', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('policy_id')->unsigned();
			$t->tinyInteger('plan_type');
			$t->tinyInteger('limit_type')->nullable();
			$t->integer('time_limit')->nullable();
			$t->enum('time_unit',['Mins','Hrs'])->nullable();
			$t->integer('data_limit')->nullable();
			$t->enum('data_unit',['MB','GB'])->nullable();
			$t->boolean('aq_access')->nullable();
			$t->integer('aq_policy')->unsigned()->nullable();
			$t->integer('sim_sessions')->unsigned();
			$t->integer('interim_updates');
			$t->integer('reset_every');
			$t->enum('reset_unit',['Days','Months','Years']);
			$t->integer('validity');
			$t->enum('validity_unit',['Days','Months','Years']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('free_plan');
	}

}
