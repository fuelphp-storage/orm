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
use Fuel\Orm\Relation\AbstractRelationStub;
use InvalidArgumentException;
use Mockery\Mock;

/**
 * Tests for Provider
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Orm\Provider
 */
class ProviderTest extends Test
{

	/**
	 * @var \ProviderStub
	 */
	protected $provider;

	protected function _before()
	{
		$db = \Mockery::mock('Fuel\Orm\QueryBuilderInterface');

		$this->provider = new \ProviderStub($db);
	}

	/**
	 * @covers ::getProperties
	 * @group  Orm
	 */
	public function testGetProperties()
	{
		$this->assertEquals(
			['a','b','c',],
			$this->provider->getProperties()
		);
	}

	/**
	 * @covers ::forgeModelInstance
	 * @group  Orm
	 */
	public function testGetModel()
	{
		$data = ['test'];
		$result = $this->provider->forgeModelInstance($data);

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
			$this->provider,
			$result->getProvider()
		);
	}

	/**
	 * @covers ::getModelClass
	 * @group  Orm
	 */
	public function testGetModelClass()
	{
		$this->assertEquals(
			'Fuel\Orm\Model',
			$this->provider->getModelClass()
		);
	}

	/**
	 * @covers            ::getModelClass
	 * @expectedException \RuntimeException
	 * @group             Orm
	 */
	public function testGetModelClassInvalid()
	{
		$this->provider->setModelClass('\stdClass');

		$this->provider->getModelClass();
	}

	/**
	 * @covers ::getModelCollectionClass
	 * @group  Orm
	 */
	public function testGetModelCollectionClass()
	{
		$this->assertEquals(
			'Fuel\Orm\ModelCollection',
			$this->provider->getModelCollectionClass()
		);
	}

	/**
	 * @covers ::forgeModelCollectionInstance
	 * @group  Orm
	 */
	public function testGetModelCollectionInstance()
	{
		$this->assertInstanceOf(
			'Fuel\Orm\ModelCollection',
			$this->provider->forgeModelCollectionInstance()
		);
	}

	/**
	 * @covers ::getQuery
	 * @group  Orm
	 */
	public function testGetQuery()
	{
		$query = $this->provider->getQuery();

		$this->assertInstanceOf(
			'\Fuel\Orm\Query',
			$query
		);

		$this->assertEquals(
			$this->provider,
			$query->getProvider()
		);
	}

	/**
	 * @covers            ::getTableName
	 * @expectedException \RuntimeException
	 * @group             Orm
	 */
	public function testGetTableNameInvalid()
	{
		$this->provider->getTableName();
	}

	/**
	 * @covers ::getTableName
	 * @group  Orm
	 */
	public function testGetTableName()
	{
		$name = 'my_table';
		$this->provider->setTableName($name);

		$this->assertEquals(
			$name,
			$this->provider->getTableName()
		);
	}

	/**
	 * @covers ::hydrate
	 * @group  Orm
	 */
	public function testHydrate()
	{
		$age = 32;
		$name = 'My Name';

		$modelData = [[
			'name' => $name,
			'age' => $age,
		]];

		/** @type ModelInterface $result */
		$result = $this->provider->hydrate($modelData);

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

	/**
	 * @covers ::hydrate
	 * @group  Orm
	 */
	public function testHydrateWithMultipleModels()
	{
		$modelData = [
			[
				'name' => 'name1',
				'age' => 'age1',
			],
			[
				'name' => 'name2',
				'age' => 'age2',
			],
		];

		$result = $this->provider->hydrate($modelData);

		$this->assertInstanceOf(
			'\Fuel\Orm\ModelCollection',
			$result
		);

		$this->assertCount(
			2,
			$result->getContents()
		);
	}

	/**
	 * @covers ::addRelation
	 * @covers ::getRelation
	 * @covers ::getRelations
	 * @group  Orm
	 */
	public function testAddGetRelation()
	{
		$relation = new AbstractRelationStub;
		$name = 'test';

		$this->provider->addRelation($name, $relation);

		$this->assertEquals(
			$relation,
			$this->provider->getRelation($name)
		);

		$this->assertEquals(
			[$name => $relation],
			$this->provider->getRelations()
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @group             Orm
	 */
	public function testGettingAnUnknownRelation()
	{
		$this->provider->getRelation('I do not exist');
	}

	/**
	 * @group Orm
	 */
	public function testGetSetFactory()
	{
		$this->assertNull(
			$this->provider->getFactory()
		);

		$factory = \Mockery::mock('Fuel\Orm\ProviderFactory');

		$this->provider->setFactory($factory);

		$this->assertEquals(
			$factory,
			$this->provider->getFactory()
		);
	}

}
