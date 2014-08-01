<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Templates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voucher_templates', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('name');
			$t->mediumText('body');
		});

		Schema::create('email_templates', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('name');
			$t->string('subject');
			$t->mediumText('body');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('voucher_templates');
		Schema::dropIfExists('email_templates');
	}

}
