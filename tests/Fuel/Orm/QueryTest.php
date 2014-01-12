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
	 * @coversDefaultClass setProvider
	 * @coversDefaultClass getProvider
	 * @coversDefaultClass __construct
	 * @group              Orm
	 */
	public function testGetSetProvider()
	{
		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');

		$object = new Query($provider);

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

}
