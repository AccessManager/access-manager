<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApInvoices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_invoices',function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->bigInteger('invoice_number')->unsigned();
			$t->integer('user_id')->unsigned();
			$t->integer('org_id')->unsigned();
			$t->timestamp('generated_on');
			$t->timestamp('bill_period_start');
			$t->timestamp('bill_period_stop');
			$t->float('prev_adjustments')->default(0);
		});

		Schema::create('ap_invoice_plans',function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('invoice_id')->unsigned();
			$t->string('plan_name');
			$t->float('rate');
			$t->timestamp('billed_from');
			$t->timestamp('billed_till');
			$t->float('amount');
			$t->float('tax_rate');
			$t->float('tax');
			$t->float('adjustment')->default(0);
		});

		Schema::table('billing_cycles',function(Blueprint $t){
			$t->enum('bill_duration_type',['1','2']);
			$t->timestamp('billed_till')->nullable()->default(null);
			$t->timestamp('last_billed_on')->nullable();
			$t->dropColumn(['last_billied_on']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_invoices');
		Schema::dropIfExists('ap_invoice_plans');
		Schema::table('billing_cycles', function(Blueprint $t){
			$t->timestamp('last_billied_on')->nullable();
			$t->dropColumn(['bill_duration_type','billed_till','last_billed_on']);
		});
	}

}
