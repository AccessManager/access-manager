<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BwPolicies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bw_policies', function(Blueprint $t)
		{
			$t->engine = "InnoDB";

			$t->increments('id');
			$t->string('name');
			$t->integer('max_down')->unsigned();
			$t->enum('max_down_unit',['Kbps','Mbps']);
			$t->integer('min_down')->unsigned();
			$t->enum('min_down_unit',['Kbps','Mbps']);
			$t->integer('max_up')->unsigned();
			$t->enum('max_up_unit',['Kbps','Mbps']);
			$t->integer('min_up')->unsigned();
			$t->enum('min_up_unit',['Kbps','Mbps']);
			// $t->timestamps();
			// $t->softDeletes();
		});


		Schema::create('policy_schema_templates', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('name');
			$t->tinyInteger('access');
			$t->integer('bw_policy')->unsigned()->nullable();
			$t->boolean('bw_accountable');
			$t->string('from_time')->nullable();
			$t->string('to_time')->nullable();
			$t->boolean('pr_allowed');
			$t->integer('pr_policy')->unsigned()->nullable();
			$t->boolean('pr_accountable');
			$t->boolean('sec_allowed')->nullable();
			$t->integer('sec_policy')->unsigned()->nullable();
			$t->boolean('sec_accountable');
			// $t->timestamps();
			// $t->softDeletes();
		});

		Schema::create('policy_schemas', function(Blueprint $t)
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
			// $t->timestamps();
			// $t->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('bw_policies');
		Schema::dropIfExists('policy_schema_templates');
		Schema::dropIfExists('policy_schemas');
	}

}
