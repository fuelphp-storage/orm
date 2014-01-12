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
 * @covers  Fuel\Orm\ModelCollection
 */
class ModelCollectionTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var ModelCollection
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new ModelCollection;
	}

	/**
	 * @coversDefaultClass getModelClass
	 * @group              Orm
	 */
	public function testGetDefaultClass()
	{
		$this->assertEquals(
			'\Fuel\Orm\Model',
			$this->object->getModelClass()
		);
	}

	/**
	 * @coversDefaultClass getModelClass
	 * @coversDefaultClass setModelClass
	 * @group              Orm
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
	 * @coversDefaultClass setModelClass
	 * @expectedException  \InvalidArgumentException
	 * @group              Orm
	 */
	public function testSetInvalidDefaultClass()
	{
		$this->object->setModelClass(new \stdClass);
	}

	/**
	 * @coversDefaultClass set
	 * @group              Orm
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
	 * @coversDefaultClass set
	 * @expectedException  \InvalidArgumentException
	 * @group              Orm
	 */
	public function testSetWithNonObject()
	{
		$this->object->set(0, '');
	}

	/**
	 * @coversDefaultClass set
	 * @expectedException  \InvalidArgumentException
	 * @group              Orm
	 */
	public function testSetWithInvalidObject()
	{
		$this->object->set(0, new \stdClass);
	}

	/**
	 * @coversDefaultClass setModelClass
	 * @coversDefaultClass set
	 * @coversDefaultClass get
	 * @group              Orm
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
