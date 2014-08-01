<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('smtp_settings', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->boolean('status');
			$t->string('email')->nullable();
			$t->string('name')->nullable();
			$t->string('username')->nullable();
			$t->string('password')->nullable();
			$t->string('host')->nullable();
			$t->integer('port')->unsigned()->nullable();
		});

		Schema::create('email_settings', function(Blueprint $t){
			
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->boolean('reg');
			$t->integer('reg_tpl')->unsigned()->nullable();
			$t->boolean('recharge');
			$t->integer('recharge_tpl')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('smtp_settings');
		Schema::dropIfExists('email_settings');
	}

}
