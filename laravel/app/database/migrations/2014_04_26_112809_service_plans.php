<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServicePlans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('service_plans', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('name');
			$t->tinyInteger('plan_type');
			// $t->integer('limit_id')->unsigned();
			$t->enum('policy_type',['Policy','PolicySchema']);
			$t->integer('policy_id')->unsigned();
			// $t->integer('schema_id')->unsigned();
			$t->integer('validity')->unsigned();
			$t->enum('validity_unit',['Days','Months']);
			$t->integer('sim_sessions')->unsigned();
			$t->integer('interim_updates')->unsigned();
			$t->float('price');
			$t->timestamps();
		});

		Schema::create('plan_limits', function(Blueprint $t)
		{
			$t->engine = "InnoDB";

			$t->increments('id');
			$t->integer('plan_id')->unsigned();
			// $t->integer('primary_policy')->unsigned()->nullable();
			$t->enum('limit_type',[0,1,2]);
			$t->integer('time_limit')->unsigned()->nullable();
			$t->enum('time_unit',['Mins','Hrs'])->nullable();
			$t->integer('data_limit')->unsigned()->nullable();
			$t->enum('data_unit',['MB','GB'])->nullable();
			$t->boolean('aq_access');
			$t->integer('aq_policy')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::dropIfExists('service_plans');
		Schema::dropIfExists('plan_limits');
	}

}
