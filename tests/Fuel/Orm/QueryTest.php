<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2013 Fuel Development Team
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
	 * @var Query
	 */
	protected $object;

	/**
	 * @var ProviderInterface
	 */
	protected $provider;

	protected function setUp()
	{
		$this->provider = \Mockery::mock('Fuel\Orm\ProviderInterface');

		$this->object = new Query($this->provider);
	}

	/**
	 * @coversDefaultClass setProvider
	 * @coversDefaultClass getProvider
	 * @coversDefaultClass __construct
	 * @group              Orm
	 */
	public function testGetSetProvider()
	{
		$this->assertEquals(
			$this->provider,
			$this->object->getProvider()
		);

		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');

		$this->object->setProvider($provider);

		$this->assertEquals(
			$provider,
			$this->object->getProvider()
		);
	}

}
