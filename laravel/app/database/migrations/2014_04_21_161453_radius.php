<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Radius extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('radacct', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->bigIncrements('radacctid');
			$t->string('acctsessionid', 64);
			$t->string('acctuniqueid', 32);
			$t->string('username', 64);
			$t->string('groupname', 64);
			$t->string('realm', 64)
				->nullable();
			$t->string('nasipaddress', 15);
			$t->string('nasportid', 15)
				->nullable();
			$t->string('nasporttype', 32)
				->nullable();
			$t->dateTime('acctstarttime')
				->nullable();
			$t->dateTime('acctstoptime')
				->nullable();
			$t->integer('acctsessiontime')
				->nullable();
			$t->string('acctauthentic', 32)
				->nullable();
			$t->string('connectinfo_start', 50)
				->nullable();
			$t->string('connectinfo_stop', 50)
				->nullable();
			$t->bigInteger('acctinputoctets')
				->nullable();
			$t->bigInteger('acctoutputoctets')
				->nullable();
			$t->string('calledstationid', 50)
				->default("''");
			$t->string('callingstationid', 50)
				->default("''");
			$t->string('acctterminatecause', 32)
				->default("''");
			$t->string('servicetype', 32)
				->nullable();
			$t->string('framedprotocol', 32)
				->nullable();
			$t->string('framedipaddress', 32)
				->default("''");
			$t->integer('acctstartdelay')
				->nullable();
			$t->integer('acctstopdelay')
				->nullable();
			$t->string('xascendsessionsvrkey', 10)
				->nullable();
				
			$t->unique('acctuniqueid');
			$t->index('username');
			$t->index('framedipaddress');
			$t->index('acctsessionid');
			$t->index('acctsessiontime');
			$t->index('acctstarttime');
			$t->index('acctstoptime');
			$t->index('nasipaddress');
		});

		Schema::create('radcheck', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';
			
			$t->increments('id')->unsigned();
			$t->string('username', 64)
				->default("''");
			$t->string('attribute', 64)
				->default("''");
			$t->string('op', 2)
				->default('==');
			$t->string('value', 253)
				->default("''");
			$t->index('username');
		});

		Schema::create('radgroupcheck', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';
			
			$t->increments('id')->unsigned();
			$t->string('groupname', 64)
				->default("''");
			$t->string('attribute', 64)
				->default("''");
			$t->string('op', 2)
				->default('==');
			$t->string('value', 253)
				->default("''");
			$t->index('groupname');
		});

		Schema::create('radgroupreply', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id')->unsigned();
			$t->string('groupname', 64)
				->default("''");
			$t->string('attribute', 64)
				->default("''");
			$t->string('op', 2)
				->default('=');
			$t->string('value', 253)
				->default("''");
			$t->index('groupname');
		});

		Schema::create('radreply', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('username', 64)
				->default("''");
			$t->string('attribute', 64)
				->default("''");
			$t->string('op', 2)
				->default('=');
			$t->string('value', 253)
				->default("''");
			$t->index('username');
		});

		Schema::create('radusergroup', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('username', 64)
				->default("''");
			$t->string('groupname', 64)
				->default("''");
			$t->integer('priority')
				->default(1);
		});

		Schema::create('radpostauth', function(Blueprint $t)
		{
			$t->engine = 'InnoDB';

			$t->increments('id');
			$t->string('username', 64)
				->default("''");
			$t->string('pass', 64)
				->default("''");
			$t->string('reply', 32)
				->default("''");
			$t->timestamp('authdate');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropifExists('radacct');
		Schema::dropIfExists('radcheck');
		Schema::dropIfExists('radgroupcheck');
		Schema::dropIfExists('radgroupreply');
		Schema::dropIfExists('radreply');
		Schema::dropIfExists('radusergroup');
		Schema::dropIfExists('radpostauth');
	}

}
