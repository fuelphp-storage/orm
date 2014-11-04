<?php
namespace Codeception\Module;

// here you can define custom functions for CodeGuy

use Codeception\Configuration;
use Fuel\Database\Connection;
use Fuel\Orm\QueryBuilder\Fuel;

class CodeHelper extends \Codeception\Module
{

	protected $connection;

	/**
	 * Gets a working DB connection
	 *
	 * @return Connection
	 */
	public function getDbInstance()
	{
		if ($this->connection === null)
		{
			// Grab the DB config from codeception and create a DB instance we can use to talk to the database with
			$config = Configuration::config();
			$dbConfig = $config['modules']['config']['Db'];
			/** @type Connection $fuelDBConnection */
			$this->connection = \Fuel\Database\DB::connection(
				[
					'dsn' => $dbConfig['dsn'],
					'username' => $dbConfig['user'],
					'password' => $dbConfig['password'],
				]
			);
		}

		return $this->connection;
	}

	/**
	 * Resets the DB connection
	 */
	public function resetDBInstance()
	{
		$this->connection = null;
	}

}
