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
use Fuel\Orm\Provider\PostProvider;
use Fuel\Orm\QueryBuilder\Fuel;
use LogicException;
use Mockery;

/**
 * Tests for Query
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 *
 * @property \CodeGuy $codeGuy
 */
class QueryTest extends Test
{

	/**
	 * Gets an instance of a new Query along with a mocked ProviderInterface
	 * @return array [Query, ProviderInterface]
	 */
	protected function getInstance()
	{
		/** @type ProviderInterface $provider */
		$provider = Mockery::mock('Fuel\Orm\ProviderInterface');
		$object = new Query($provider);

		return [$object, $provider];
	}

	/**
	 * Gets a working query builder.
	 * @return Fuel
	 */
	protected function getQueryBuilder()
	{
		return new Fuel($this->codeGuy->getDbInstance());
	}

	public function testGetSetProvider()
	{
		/** @type Query $object */
		/** @type ProviderInterface $provider */
		list ($object, $provider) = $this->getInstance();

		$this->assertEquals(
			$provider,
			$object->getProvider()
		);

		$provider = Mockery::mock('Fuel\Orm\ProviderInterface');

		$object->setProvider($provider);

		$this->assertEquals(
			$provider,
			$object->getProvider()
		);
	}

	public function testSingleSelect()
	{
		$this->codeGuy->haveInDatabase('posts', [
				'id' => '1',
				'title' => 'title',
				'description' => 'description',
				'created_at' => 123,
				'updated_at' => 321,
			]);

		$postProvider = new PostProvider($this->getQueryBuilder());

		$result = $postProvider->getQuery()
			->select()
			->execute();

		$this->assertEquals(
			1,
			$result->id
		);

		$this->assertEquals(
			'title',
			$result->title
		);

		$this->assertEquals(
			'description',
			$result->description
		);
	}

	public function testMultipleSelect()
	{
		$this->codeGuy->haveInDatabase('posts', [
				'id' => '1',
				'title' => 'title',
				'description' => 'description',
				'created_at' => 123,
				'updated_at' => 321,
			]);
		$this->codeGuy->haveInDatabase('posts', [
				'id' => '2',
				'title' => 'title2',
				'description' => 'description2',
				'created_at' => 456,
				'updated_at' => 654,
			]);

		$postProvider = new PostProvider($this->getQueryBuilder());

		/** @type ModelCollection $result */
		$result = $postProvider->getQuery()
			->select()
			->execute();

		$this->assertInstanceOf(
			'\Fuel\Orm\ModelCollection',
			$result
		);

		$this->assertCount(
			2,
			$result->getContents()
		);
	}

	public function testSingleDelete()
	{
		$model1 = [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];
		$this->codeGuy->haveInDatabase('posts', $model1);

		$model2 = [
			'id' => '2',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];
		$this->codeGuy->haveInDatabase('posts', $model2);

		$provider = new PostProvider($this->getQueryBuilder());

		$model = $provider->forgeModelInstance($model1);

		$provider->getQuery()
			->delete([$model])
			->execute();

		$this->codeGuy->cantSeeInDatabase(
			'posts',
			$model1
		);

		$this->codeGuy->canSeeInDatabase(
			'posts',
			$model2
		);
	}

	public function testMultipleDelete()
	{
		$modelData1 = [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];
		$this->codeGuy->haveInDatabase('posts', $modelData1);

		$modelData2 = [
			'id' => '2',
			'title' => 'title2',
			'description' => 'description2',
			'created_at' => 456,
			'updated_at' => 654,
		];
		$this->codeGuy->haveInDatabase('posts', $modelData2);

		$provider = new PostProvider($this->getQueryBuilder());

		$model1 = $provider->forgeModelInstance($modelData1);
		$model2 = $provider->forgeModelInstance($modelData2);

		$provider->getQuery()
				->delete([$model1, $model2])
				->execute();

		$this->codeGuy->cantSeeInDatabase('posts', $modelData1);
		$this->codeGuy->cantSeeInDatabase('posts', $modelData2);
	}

	public function testSingleInsert()
	{
		$model1 = [
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];

		$provider = new PostProvider($this->getQueryBuilder());

		$model = $provider->forgeModelInstance($model1);

		$provider->getQuery()
			->insert($model)
			->execute();

		$this->codeGuy->canSeeInDatabase('posts', $model1);
		$this->assertEquals('1', $model->id);
	}

	public function testMultipleInsert()
	{
		$modelData1 = [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];
		$modelData2 = [
			'id' => '2',
			'title' => 'title2',
			'description' => 'description2',
			'created_at' => 456,
			'updated_at' => 654,
		];

		$provider = new PostProvider($this->getQueryBuilder());

		$model1 = $provider->forgeModelInstance($modelData1);
		$model2 = $provider->forgeModelInstance($modelData2);

		$provider->getQuery()
				->insert([$model1, $model2])
				->execute();

		$this->codeGuy->canSeeInDatabase('posts', $modelData1);
		$this->codeGuy->canSeeInDatabase('posts', $modelData2);
	}

	public function testMultipleInsertWithCollection()
	{
		$modelData1 = [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];
		$modelData2 = [
			'id' => '2',
			'title' => 'title2',
			'description' => 'description2',
			'created_at' => 456,
			'updated_at' => 654,
		];

		$provider = new PostProvider($this->getQueryBuilder());

		$model1 = $provider->forgeModelInstance($modelData1);
		$model2 = $provider->forgeModelInstance($modelData2);

		$provider->getQuery()
			->insert($provider->forgeModelCollectionInstance([$model1, $model2]))
			->execute();

		$this->codeGuy->canSeeInDatabase('posts', $modelData1);
		$this->codeGuy->canSeeInDatabase('posts', $modelData2);
	}

	public function testSelectWithWhere()
	{
		$modelData1 = [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];
		$modelData2 = [
			'id' => '2',
			'title' => 'title2',
			'description' => 'description2',
			'created_at' => 456,
			'updated_at' => 654,
		];
		$this->codeGuy->haveInDatabase('posts', $modelData1);
		$this->codeGuy->haveInDatabase('posts', $modelData2);

		$provider = new PostProvider($this->getQueryBuilder());

		$result = $provider->getQuery()
			->select()
			->where('id', '2')
			->execute();

		$this->assertInstanceOf(
			'\Fuel\Orm\Model',
			$result
		);

		$this->assertEquals(
			'title2',
			$result->title
		);

		$this->assertEquals(
			'description2',
			$result->description
		);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testWhereWithoutQuery()
	{
		/** @type Query $query */
		list($query, ) = $this->getInstance();

		$query->where('foo', '<', 123);
	}

	public function testSingleUpdate()
	{
		$model1 = [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];
		$this->codeGuy->haveInDatabase('posts', $model1);

		$provider = new PostProvider($this->getQueryBuilder());
		$model = $provider->forgeModelInstance($model1);

		$model->title = 'shiny new title';
		$provider->getQuery()
			->update($model)
			->execute();

		$model1['title'] = 'shiny new title';
		$this->codeGuy->canSeeInDatabase('posts', $model1);
	}

}
