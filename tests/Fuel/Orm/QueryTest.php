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

/**
 * Tests for Query
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @covers  Fuel\Orm\Query
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
	 * @coversDefaultClass setProvider
	 * @coversDefaultClass getProvider
	 * @coversDefaultClass __construct
	 * @group              Orm
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
	 * @coversDefaultClass getTableAlias
	 * @group              Orm
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
	 * @coversDefaultClass getPropertyAlias
	 * @group              Orm
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

}
