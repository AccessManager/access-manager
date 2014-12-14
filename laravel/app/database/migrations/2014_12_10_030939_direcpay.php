<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Direcpay extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('direcpay_transactions',function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->bigInteger('dp_refrence_id')->nullable();
			$t->string('status')->nullable();
			$t->string('other_details')->nullable();
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
		Schema::dropIfExists('direcpay_transactions');
	}

}
