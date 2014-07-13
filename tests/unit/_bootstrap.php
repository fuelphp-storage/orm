<?php
// Here you can initialize variables that will for your tests

use Fuel\Database\Connection;

require_once __DIR__.'/../../vendor/autoload.php';

require_once __DIR__.'/stubs/SubjectStub.php';
require_once __DIR__.'/stubs/ProviderStub.php';
require_once __DIR__.'/stubs/Provider/PostProvider.php';

// If someone knows a sane way of getting at the codecetpion.yml config then PRs are welcome
/** @type Connection $fuelDBConnection */
$fuelDBConnection = \Fuel\Database\DB::connection(
	[
		'dsn'=> 'mysql:host=127.0.0.1;dbname=fuelphp_orm_tests',
		'username' => 'root',
		'password' => '',
	]
);

$GLOBALS['fuelDBConnection'] = $fuelDBConnection;
