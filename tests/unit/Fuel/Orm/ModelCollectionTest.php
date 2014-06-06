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
 * Tests for ModelCollection
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Orm\ModelCollection
 */
class ModelCollectionTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var ModelCollectionInterface
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new ModelCollection;
	}

	/**
	 * @covers ::getModelClass
	 * @group  Orm
	 */
	public function testGetDefaultClass()
	{
		$this->assertEquals(
			'\Fuel\Orm\Model',
			$this->object->getModelClass()
		);
	}

	/**
	 * @covers ::getModelClass
	 * @covers ::setModelClass
	 * @group  Orm
	 */
	public function testGetSetDefaultClass()
	{
		$class = '\stdClass';

		$this->object->setModelClass($class);

		$this->assertEquals(
			$class,
			$this->object->getModelClass()
		);
	}

	/**
	 * @covers            ::setModelClass
	 * @expectedException \InvalidArgumentException
	 * @group             Orm
	 */
	public function testSetInvalidDefaultClass()
	{
		$this->object->setModelClass(new \stdClass);
	}

	/**
	 * @covers ::set
	 * @group  Orm
	 */
	public function testSetModel()
	{
		$model = \Mockery::mock('\Fuel\Orm\Model');

		$this->object->set(0, $model);

		$this->assertEquals(
			$model,
			$this->object->get(0)
		);
	}

	/**
	 * @covers            ::set
	 * @expectedException \InvalidArgumentException
	 * @group             Orm
	 */
	public function testSetWithNonObject()
	{
		$this->object->set(0, '');
	}

	/**
	 * @covers            ::set
	 * @expectedException \InvalidArgumentException
	 * @group             Orm
	 */
	public function testSetWithInvalidObject()
	{
		$this->object->set(0, new \stdClass);
	}

	/**
	 * @covers ::setModelClass
	 * @covers ::set
	 * @covers ::get
	 * @group  Orm
	 */
	public function testSetWithAlternateClassName()
	{
		$className = '\stdClass';
		$object = new $className();

		$this->object->setModelClass($className);

		$this->object->set(0, $object);

		$this->assertEquals(
			$object,
			$this->object->get(0)
		);
	}

}
