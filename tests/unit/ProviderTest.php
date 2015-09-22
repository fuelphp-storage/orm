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

/**
 * Tests for Provider
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
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

	public function testGetProperties()
	{
		$this->assertEquals(
			['a','b','c',],
			$this->provider->getProperties()
		);
	}

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

	public function testGetModelClass()
	{
		$this->assertEquals(
			'Fuel\Orm\Model',
			$this->provider->getModelClass()
		);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testGetModelClassInvalid()
	{
		$this->provider->setModelClass('\stdClass');

		$this->provider->getModelClass();
	}

	public function testGetModelCollectionClass()
	{
		$this->assertEquals(
			'Fuel\Orm\ModelCollection',
			$this->provider->getModelCollectionClass()
		);
	}

	public function testGetModelCollectionInstance()
	{
		$this->assertInstanceOf(
			'Fuel\Orm\ModelCollection',
			$this->provider->forgeModelCollectionInstance()
		);
	}

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
	 * @expectedException \RuntimeException
	 */
	public function testGetTableNameInvalid()
	{
		$this->provider->getTableName();
	}

	public function testGetTableName()
	{
		$name = 'my_table';
		$this->provider->setTableName($name);

		$this->assertEquals(
			$name,
			$this->provider->getTableName()
		);
	}

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

		/** @var \Fuel\Orm\ModelCollection $result */
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
	 */
	public function testGettingAnUnknownRelation()
	{
		$this->provider->getRelation('I do not exist');
	}

	public function testGetSetFactory()
	{
		$this->assertNull(
			$this->provider->getFactory()
		);

		/** @var \Fuel\Orm\ProviderFactory $factory */
		$factory = \Mockery::mock('Fuel\Orm\ProviderFactory');

		$this->provider->setFactory($factory);

		$this->assertEquals(
			$factory,
			$this->provider->getFactory()
		);
	}

}
