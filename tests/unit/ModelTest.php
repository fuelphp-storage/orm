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

use Codeception\TestCase\Test;
use Mockery;

/**
 * Tests for Model
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 */
class ModelTest extends Test
{

	/**
	 * @var Model
	 */
	protected $object;

	protected function _before()
	{
		$this->object = new Model;
	}

	public function testIsNew()
	{
		$this->assertTrue(
			$this->object->isNew()
		);

		$this->object->setIsNew(false);

		$this->assertFalse(
			$this->object->isNew()
		);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testIsNewInvalid()
	{
		/** @noinspection PhpParamsInspection */
		$this->object->setIsNew(new \stdClass());
	}

	public function testGetOriginalData()
	{
		$this->assertInstanceOf(
			'Fuel\Common\DataContainer',
			$this->object->getOriginalData()
		);
	}

	public function testSetGetProvider()
	{
		/** @var \Fuel\Orm\ProviderInterface $provider */
		$provider = Mockery::mock('Fuel\Orm\ProviderInterface');

		$this->object->setProvider($provider);

		$this->assertEquals(
			$provider,
			$this->object->getProvider()
		);
	}

	public function testConstructWithData()
	{
		$name = 'Test Model';

		$data = [
			'name' => $name,
		];

		$object = new Model($data);

		$this->assertEquals(
			$data,
			$object->getOriginalData()->getContents()
		);

		$this->assertEquals(
			$name,
			$object->name
		);
	}

}
