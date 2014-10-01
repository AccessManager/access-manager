<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('general_settings', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('idle_timeout');
			$t->boolean('self_signup');
			$t->boolean('allow_free_ppp');
		});

		Schema::create('paypal_settings', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->boolean('status');
			$t->string('email')->nullable();
			$t->integer('currency')->unsigned()->nullable();
			$t->boolean('sandbox')->nullable();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('general_settings');
		Schema::dropIfExists('paypal_settings');
	}

}
