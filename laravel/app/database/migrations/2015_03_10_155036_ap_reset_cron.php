<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApResetCron extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ap_active_plans', function(Blueprint $t){
			$t->integer('validity')->unsigned();
			$t->enum('validity_unit',['Days','Months']);
			$t->timestamp('last_reset_on');
		});

		Schema::table('ap_change_history', function(Blueprint $t){
			$t->float('tax_rate');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ap_active_plans', function(Blueprint $t){
			$t->dropColumn(['validity','validity_unit','last_reset_on']);
		});
		Schema::table('ap_change_history', function(Blueprint $t){
			$t->dropColumn('tax_rate');
		});
	}

}
