<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefillCoupons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('refill_coupons', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned()->nullable();
			$t->bigInteger('pin')->unsigned();
			$t->boolean('have_data');
			$t->integer('data_limit')->unsigned()->nullable();
			$t->enum('data_unit',['MB','GB'])->nullable();
			$t->boolean('have_time');
			$t->integer('time_limit')->unsigned()->nullable();
			$t->enum('time_unit',['Mins','Hrs'])->nullable();
			$t->timestamp('expires_on');
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
		Schema::dropIfExists('refill_coupons');
	}

}

