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

		Schema::table('billing_cycles',function(Blueprint $t){
			$t->integer('org_id')->unsigned();
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
		Schema::table('billing_cycles',function(Blueprint $t){
			$t->dropColumn('org_id');
		});
	}

}
