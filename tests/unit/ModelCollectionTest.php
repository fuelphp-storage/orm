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
use Fuel\Orm\Model;

/**
 * Tests for ModelCollection
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 */
class ModelCollectionTest extends Test
{

	/**
	 * @var ModelCollectionInterface
	 */
	protected $object;

	protected function _before()
	{
		$this->object = new ModelCollection;
	}

	public function testGetDefaultClass()
	{
		$this->assertEquals(
			'\Fuel\Orm\Model',
			$this->object->getModelClass()
		);
	}

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
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetInvalidDefaultClass()
	{
		$this->object->setModelClass(new \stdClass);
	}

	public function testSetModel()
	{
		$model = new Model;

		$this->object->set(0, $model);

		$this->assertEquals(
			$model,
			$this->object->get(0)
		);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetWithNonObject()
	{
		$this->object->set(0, '');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetWithInvalidObject()
	{
		$this->object->set(0, new \stdClass);
	}

	public function testCreateModelCollectionWithModels()
	{
		$models = [
			new Model,
			new Model,
			new Model,
		];

		$collection = new ModelCollection($models);

		$this->assertEquals(
			$models,
			$collection->getContents()
		);
	}

}
