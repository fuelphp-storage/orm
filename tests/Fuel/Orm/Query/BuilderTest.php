<?php
/**
 * @package   Fuel\Orm\Query
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Query;

use Fuel\Orm\ProviderInterface;

/**
 * Tests for Builder
 *
 * @package Fuel\Orm\Query
 * @author  Fuel Development Team
 * @covers  Fuel\Orm\Query\Builder
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Builder
	 */
	protected $object;

	protected function setUp()
	{
		/** @var ProviderInterface $provider */
		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');

		$this->object = new Builder($provider);
	}

	/**
	 * @coversDefaultClass getTableAlias
	 * @group              Orm
	 */
	public function testGetTableAlias()
	{
		$this->assertEquals(
			't0',
			$this->object->getTableAlias()
		);
	}

	/**
	 * @coversDefaultClass getPropertyAlias
	 * @group              Orm
	 */
	public function testGetPropertyAlias()
	{
		$tableAlias = $this->object->getTableAlias();

		$this->assertEquals(
			$tableAlias . '.c0',
			$this->object->getPropertyAlias('one')
		);

		$this->assertEquals(
			 $tableAlias . '.c1',
			 $this->object->getPropertyAlias('two')
		);

		$this->assertEquals(
			 $tableAlias . '.c0',
			 $this->object->getPropertyAlias('one')
		);
	}

}
