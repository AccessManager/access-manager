<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApPolicySchemaTemplates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ap_policy_schema_templates', function(Blueprint $t){

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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ap_policy_schema_templates');
	}

}
