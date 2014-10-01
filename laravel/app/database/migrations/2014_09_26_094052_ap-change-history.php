<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApChangeHistory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_change_history', function(Blueprint $t) {
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->timestamp('from_date');
			$t->timestamp('to_date');
			$t->string('plan_name');
			$t->tinyInteger('plan_type');
			$t->tinyInteger('limit_type')->nullable();
			$t->integer('time_limit')->unsigned()->nullable();
			$t->enum('time_unit',['Mins','Hrs'])->nullable();
			$t->integer('data_limit')->unsigned()->nullable();
			$t->enum('data_unit',['MB','GB'])->nullable();
			$t->boolean('aq_access')->nullable();
			$t->string('aq_policy')->nullable();
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
		Schema::dropIfExists('ap_change_history');
	}

}
