<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrepaidVouchers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prepaid_vouchers', function(Blueprint $t){

			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->bigInteger('pin')->unsigned();
			$t->enum('method',['pin','online','admin'])->nullable();
			$t->date('expires_on');
			$t->timestamps();
			$t->string('plan_name');
			$t->tinyInteger('plan_type');
			$t->integer('limit_id')->unsigned()->nullable();
			$t->enum('policy_type',['Policy','PolicySchema']);
			$t->integer('policy_id')->unsigned();
			$t->integer('sim_sessions')->unsigned();
			$t->integer('interim_updates')->unsigned();
			$t->float('price');
			$t->integer('validity')->unsigned();
			$t->enum('validity_unit',['Days','Months']);
		});


		Schema::create('voucher_limits', function(Blueprint $t)
		{
			$t->engine = "InnoDB";

			$t->increments('id');
			$t->enum('limit_type',[0,1,2]);
			$t->integer('time_limit')->unsigned()->nullable();
			$t->enum('time_unit',['Mins','Hrs'])->nullable();
			$t->integer('data_limit')->unsigned()->nullable();
			$t->enum('data_unit',['MB','GB'])->nullable();
			$t->boolean('aq_access')->nullable();
			$t->string('aq_policy')->nullable();
		});

		Schema::create('voucher_bw_policies', function(Blueprint $t)
		{
			$t->engine = "InnoDB";

			$t->increments('id');
			$t->string('bw_policy');
		});

		Schema::create('voucher_policy_schema_templates', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('name');
			$t->tinyInteger('access');
			$t->string('bw_policy')->nullable();
			$t->boolean('bw_accountable');
			$t->string('from_time')->nullable();
			$t->string('to_time')->nullable();
			$t->boolean('pr_allowed');
			$t->string('pr_policy')->nullable();
			$t->boolean('pr_accountable');
			$t->boolean('sec_allowed')->nullable();
			$t->string('sec_policy')->nullable();
			$t->boolean('sec_accountable');
		});

		Schema::create('voucher_policy_schemas', function(Blueprint $t)
		{
			$t->engine = "InnoDB";

			$t->increments('id');
			$t->string('name');
			$t->integer('mo')->unsigned();
			$t->integer('tu')->unsigned();
			$t->integer('we')->unsigned();
			$t->integer('th')->unsigned();
			$t->integer('fr')->unsigned();
			$t->integer('sa')->unsigned();
			$t->integer('su')->unsigned();
		});

		Schema::create('user_recharges', function(Blueprint $t){

			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->integer('voucher_id')->unsigned()->nullable();
			$t->datetime('recharged_on')->nullable();
			$t->bigInteger('time_limit')->nullable()->default(0);
			$t->bigInteger('data_limit')->nullable()->default(0);
			$t->string('expiration',20);
			$t->boolean('aq_invocked');
			$t->integer('active_tpl')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('prepaid_vouchers');
		Schema::dropIfExists('voucher_limits');
		Schema::dropIfExists('voucher_bw_policies');
		Schema::dropIfExists('voucher_policy_schemas');
		Schema::dropIfExists('voucher_policy_schema_templates');
		Schema::dropIfExists('user_recharges');
	}

}
