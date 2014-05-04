<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm;

use Mockery\Mock;

/**
 * Tests for Query
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Orm\Query
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Gets an instance of a new Query along with a mocked ProviderInterface
	 * @return array [Query, ProviderInterface]
	 */
	protected function getInstance()
	{
		/** @var ProviderInterface $provider */
		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');
		$object = new Query($provider);

		return [$object, $provider];
	}

	/**
	 * @covers ::setProvider
	 * @covers ::getProvider
	 * @covers ::__construct
	 * @group  Orm
	 */
	public function testGetSetProvider()
	{
		/** @var Query $object */
		/** @var ProviderInterface $provider */
		list ($object, $provider) = $this->getInstance();

		$this->assertEquals(
			$provider,
			$object->getProvider()
		);

		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');

		$object->setProvider($provider);

		$this->assertEquals(
			$provider,
			$object->getProvider()
		);
	}

	/**
	 * @covers ::getTableAlias
	 * @group  Orm
	 */
	public function testGetTableAlias()
	{
		/** @var Query $object */
		list ($object) = $this->getInstance();

		$this->assertEquals(
			't0',
			$object->getTableAlias()
		);
	}

	/**
	 * @covers ::getPropertyAlias
	 * @group  Orm
	 */
	public function testGetPropertyAlias()
	{
		/** @var Query $object */
		list ($object) = $this->getInstance();

		$tableAlias = $object->getTableAlias();

		$this->assertEquals(
			$tableAlias . '.c0',
			$object->getPropertyAlias('one')
		);

		$this->assertEquals(
			$tableAlias . '.c1',
			$object->getPropertyAlias('two')
		);

		$this->assertEquals(
			$tableAlias . '.c0',
			$object->getPropertyAlias('one')
		);
	}

	/**
	 * @covers ::select
	 * @covers ::getCurrentQuery
	 * @group  Orm
	 */
	public function testSelect()
	{
		/** @var Query $object */
		/** @var Mock $provider */
		list ($object, $provider) = $this->getInstance();

		$tableName = 'table';
		$properties = [
			'a' => 'a',
			'b' => 'b',
			'c' => 'c',
		];

		// Create a new DBAL mock
		$dbal = \Mockery::mock('Fuel\Database\Connection');

		// Set up our provider Mock
		$provider->shouldReceive('getDbal')
			->once()
			->andReturn($dbal);

		$provider->shouldReceive('getProperties')
			->once()
			->andReturn($properties);

		$provider->shouldReceive('getTableName')
			->once()
			->andReturn($tableName);

		// Set up our DBAL mock
		$dbal->shouldReceive('select')
			->with($properties)
			->once()
			->andReturn($dbal);

		$dbal->shouldReceive('from')
			->with($tableName)
			->once()
			->andReturn($dbal);

		// Make sure it's blank to start with
		$this->assertNull($object->getCurrentQuery());

		// Perform the call to select to test the above
		$object->select();

		// Make sure our current query is set
		$this->assertEquals(
			 $dbal,
			 $object->getCurrentQuery()
		);
	}

}
