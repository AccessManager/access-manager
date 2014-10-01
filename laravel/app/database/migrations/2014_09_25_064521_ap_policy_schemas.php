<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApPolicySchemas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_policy_schemas', function(Blueprint $t){
			$t->engine = "InnoDB";

			$t->increments('id');
			$t->string('name');
			$t->integer('mo')->unsigned();
			$t->integer('tu')->unsigned();
			$t->integer('we')->unsigned();
			$t->integer('th')->unsigned();
			$t->integer('fr')->unsigned();
			$t->integer('sa')->unsigned();
			$t->integer('su')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_policy_schemas');
	}

}
