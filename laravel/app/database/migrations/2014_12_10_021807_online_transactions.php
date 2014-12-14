<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OnlineTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('online_transactions', function(Blueprint $t){
			$t->engine = 'InnoDB';
			
			$t->increments('id');
			$t->integer('user_id');
			$t->string('gw_type');
			$t->integer('gw_id')->unsigned();
			$t->string('order_id');
			$t->float('amount');
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
		Schema::dropIfExists('online_transactions');
	}

}
