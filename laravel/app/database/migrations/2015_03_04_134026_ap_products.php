<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_user_recurring_products', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->string('name');
			$t->integer('billing_cycle')->unsigned();
			$t->enum('billing_unit',['Days','Months']);
			$t->timestamp('assigned_on')->nullable();
			$t->timestamp('last_billed_on');
			$t->timestamp('billed_till');
			$t->float('price');
			$t->boolean('taxable');
			$t->float('tax_rate')->default(0);
			$t->timestamp('expiry')->nullable();
		});

		Schema::create('ap_user_non_recurring_products', function(Blueprint $t){
			$t->engine = 'InnoDB';
 
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->string('name');
			$t->timestamp('assigned_on')->nullable();
			$t->float('price');
			$t->boolean('taxable');
			$t->float('tax_rate')->default(0);
		});

		Schema::create('ap_user_recurring_products_history', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->string('name');
			$t->float('rate');
			$t->timestamp('start_date');
			$t->timestamp('stop_date');
			$t->string('billed_every');
			$t->float('price');
			$t->boolean('taxable');
			$t->float('tax_rate')->default(0);
		});

		Schema::create('ap_invoice_recurring_products', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('invoice_id')->unsigned();
			$t->string('name');
			$t->timestamp('billed_from');
			$t->timestamp('billed_till');
			$t->float('amount');
			$t->float('tax')->default(0);
			$t->float('rate');
		});

		Schema::create('ap_invoice_non_recurring_products', function(Blueprint $t){
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('invoice_id')->unsigned();
			$t->string('name');
			$t->float('amount');
			$t->float('tax')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_user_recurring_products');
		Schema::dropIfExists('ap_user_non_recurring_products');
		Schema::dropIfExists('ap_user_recurring_products_history');
		Schema::dropIfExists('ap_invoice_recurring_products');
		Schema::dropIfExists('ap_invoice_non_recurring_products');
	}

}
//end of file.