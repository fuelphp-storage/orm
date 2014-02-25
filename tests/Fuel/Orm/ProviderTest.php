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

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'ProviderStub.php';

/**
 * Tests for Provider
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @covers  Fuel\Orm\Provider
 */
class ProviderTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var \ProviderStub
	 */
	protected $object;

	protected function setUp()
	{
		$db = \Mockery::mock('Fuel\Database\Connection');

		$this->object = new \ProviderStub($db);
	}

	/**
	 * @coversDefaultClass getProperties
	 * @group              Orm
	 */
	public function testGetProperties()
	{
		$this->assertEquals(
			['a','b','c',],
			$this->object->getProperties()
		);
	}

	/**
	 * @coversDefaultClass forgeModelInstance
	 * @group              Orm
	 */
	public function testGetModel()
	{
		$data = ['test'];
		$result = $this->object->forgeModelInstance($data);

		// Make sure we have a model
		$this->assertInstanceOf(
			'Fuel\Orm\Model',
			$result
		);

		// Make sure the data has been set
		$this->assertEquals(
			$data,
			$result->getOriginalData()->getContents()
		);

		// And make sure the provider has been set
		$this->assertEquals(
			$this->object,
			$result->getProvider()
		);
	}

	/**
	 * @coversDefaultClass getModelClass
	 * @group              Orm
	 */
	public function testGetModelClass()
	{
		$this->assertEquals(
			'Fuel\Orm\Model',
			$this->object->getModelClass()
		);
	}

	/**
	 * @coversDefaultClass getModelClass
	 * @expectedException  \RuntimeException
	 * @group              Orm
	 */
	public function testGetModelClassInvalid()
	{
		$this->object->setModelClass('\stdClass');

		$this->object->getModelClass();
	}

	/**
	 * @coversDefaultClass getModelCollectionClass
	 * @group              Orm
	 */
	public function testGetModelCollectionClass()
	{
		$this->assertEquals(
			'Fuel\Orm\ModelCollection',
			$this->object->getModelCollectionClass()
		);
	}

	public function testGetModelCollectionInstance()
	{
		$this->assertInstanceOf(
			'Fuel\Orm\ModelCollection',
			$this->object->forgeModelCollectionInstance()
		);
	}

	/**
	 * @coversDefaultClass getQuery
	 * @group              Orm
	 */
	public function testGetQuery()
	{
		$query = $this->object->getQuery();

		$this->assertInstanceOf(
			'\Fuel\Orm\Query',
			$query
		);

		$this->assertEquals(
			$this->object,
			$query->getProvider()
		);
	}

	/**
	 * @coversDefaultClass getTableName
	 * @expectedException  \RuntimeException
	 * @group              Orm
	 */
	public function testGetTableNameInvalid()
	{
		$this->object->getTableName();
	}

	/**
	 * @coversDefaultClass getTableName
	 * @group              Orm
	 */
	public function testGetTableName()
	{
		$name = 'my_table';
		$this->object->setTableName($name);

		$this->assertEquals(
			$name,
			$this->object->getTableName()
		);
	}

	/**
	 * @coversDefaultClass hydrate
	 * @group              Orm
	 */
	public function testHydrate()
	{
		$age = 32;
		$name = 'My Name';

		$modelData = [
			'name' => $name,
			'age' => $age,
		];

		/** @var ModelInterface $result */
		$result = $this->object->hydrate([$modelData]);

		$this->assertInstanceOf(
			'Fuel\Orm\ModelInterface',
			$result
		);

		$this->assertEquals(
			$age,
			$result->age
		);

		$this->assertEquals(
			$name,
			$result->name
		);
	}

}
