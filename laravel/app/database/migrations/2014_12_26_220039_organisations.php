<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Organisations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organisations', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('name');
			$t->string('address');
			$t->string('tin');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('organisations');
	}

}
