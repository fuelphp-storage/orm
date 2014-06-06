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
 * Tests for Model
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Orm\Model
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Model
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new Model;
	}

	/**
	 * @covers ::isNew
	 * @covers ::setIsNew
	 * @group  Orm
	 */
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
	 * @covers            ::setIsNew
	 * @expectedException \InvalidArgumentException
	 * @group             Orm
	 */
	public function testIsNewInvalid()
	{
		$this->object->setIsNew(new \stdClass());
	}

	/**
	 * @covers ::getOriginalData
	 * @group  Orm
	 */
	public function testGetOriginalData()
	{
		$this->assertInstanceOf(
			'Fuel\Common\DataContainer',
			$this->object->getOriginalData()
		);
	}

	/**
	 * @covers ::setProvider
	 * @covers ::getProvider
	 * @group  Orm
	 */
	public function testSetGetProvider()
	{
		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');

		$this->object->setProvider($provider);

		$this->assertEquals(
			$provider,
			$this->object->getProvider()
		);
	}

	/**
	 * @covers ::__construct
	 * @covers ::getOriginalData
	 * @group  Orm
	 */
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
