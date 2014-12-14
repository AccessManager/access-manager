<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DirecpaySettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('direcpay_settings',function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->boolean('status');
			$t->boolean('sandbox');
			$t->string('mid');
			$t->string('enc_key');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('direcpay_settings');
	}

}
