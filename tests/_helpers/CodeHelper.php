<?php
namespace Codeception\Module;

// here you can define custom functions for CodeGuy

use Codeception\Configuration;
use Fuel\Database\Connection;

class CodeHelper extends \Codeception\Module
{

	public function getDbInstance()
	{
		// Grab the DB config from codeception and create a DB instance we can use to talk to the database with
		$config = Configuration::config();
		$dbConfig = $config['modules']['config']['Db'];
		/** @type Connection $fuelDBConnection */
		$fuelDBConnection = \Fuel\Database\DB::connection(
			[
				'dsn'=> $dbConfig['dsn'],
				'username' => $dbConfig['user'],
				'password' => $dbConfig['password'],
			]
		);

		return $fuelDBConnection;
	}

}
