<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_transactions', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->enum('type',['cr','dr']);
			$t->float('amount');
			$t->string('description');
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_transactions');
	}

}
