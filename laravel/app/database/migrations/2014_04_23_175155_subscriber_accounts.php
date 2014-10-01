<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubscriberAccounts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_accounts', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('uname');
			$t->string('pword');
			$t->string('clear_pword');
			$t->tinyInteger('plan_type');
			$t->string('fname')->nullable();
			$t->string('lname')->nullable();
			$t->string('contact')->nullable();
			$t->string('email')->nullable();
			$t->mediumText('address')->nullable();
			$t->boolean('status');
			$t->boolean('is_admin');
			$t->timestamps();
			$t->string('remember_token',100)->nullable();
			$t->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_accounts');
	}

}
