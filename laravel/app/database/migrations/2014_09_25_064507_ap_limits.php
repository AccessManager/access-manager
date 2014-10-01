<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApLimits extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_limits', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->enum('limit_type',[0,1,2]);
			$t->integer('time_limit')->unsigned()->nullable();
			$t->enum('time_unit',['Mins','Hrs'])->nullable();
			$t->integer('data_limit')->unsigned()->nullable();
			$t->enum('data_unit',['MB','GB'])->nullable();
			$t->boolean('aq_access')->nullable();
			$t->string('aq_policy')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_limits');
	}

}
