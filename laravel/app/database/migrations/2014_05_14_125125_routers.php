<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Routers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nas', function(Blueprint $t){

			$t->engine = "InnoDB";

			$t->increments('id');
			$t->string('nasname',128);
			$t->string('shortname',32)->nullable();
			$t->string('type',30)->default('other');
			$t->integer('ports')->default(1812);
			$t->string('secret',60)->default('secret');
			$t->string('server',64)->nullable();
			$t->string('community',50)->nullable();
			$t->string('description',200)->default('Radius Client');
			$t->index('nasname');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('nas');
	}

}
