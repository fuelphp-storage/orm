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
use Fuel\Database\Connection;
use Fuel\Orm\Provider\PostProvider;
use Mockery\Mock;

/**
 * Tests for Query
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Orm\Query
 */
class QueryTest extends Test
{

	/**
	 * Gets an instance of a new Query along with a mocked ProviderInterface
	 * @return array [Query, ProviderInterface]
	 */
	protected function getInstance()
	{
		/** @var ProviderInterface $provider */
		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');
		$object = new Query($provider);

		return [$object, $provider];
	}

	/**
	 * @covers ::setProvider
	 * @covers ::getProvider
	 * @covers ::__construct
	 * @group  Orm
	 */
	public function testGetSetProvider()
	{
		/** @var Query $object */
		/** @var ProviderInterface $provider */
		list ($object, $provider) = $this->getInstance();

		$this->assertEquals(
			$provider,
			$object->getProvider()
		);

		$provider = \Mockery::mock('Fuel\Orm\ProviderInterface');

		$object->setProvider($provider);

		$this->assertEquals(
			$provider,
			$object->getProvider()
		);
	}

	/**
	 * @covers ::getTableAlias
	 * @group  Orm
	 */
	public function testGetTableAlias()
	{
		/** @var Query $object */
		list ($object) = $this->getInstance();

		$this->assertEquals(
			't0',
			$object->getTableAlias()
		);
	}

	/**
	 * @covers ::getPropertyAlias
	 * @group  Orm
	 */
	public function testGetPropertyAlias()
	{
		/** @var Query $object */
		list ($object) = $this->getInstance();

		$tableAlias = $object->getTableAlias();

		$this->assertEquals(
			$tableAlias . '.c0',
			$object->getPropertyAlias('one')
		);

		$this->assertEquals(
			$tableAlias . '.c1',
			$object->getPropertyAlias('two')
		);

		$this->assertEquals(
			$tableAlias . '.c0',
			$object->getPropertyAlias('one')
		);
	}

	/**
	 * @covers ::select
	 * @group  Orm
	 */
	public function testSingleSelect()
	{
		$this->codeGuy->haveInDatabase('posts', [
				'id' => '1',
				'title' => 'title',
				'description' => 'description',
				'created_at' => 123,
				'updated_at' => 321,
			]);

		$postProvider = new PostProvider($GLOBALS['fuelDBConnection']);

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

	/**
	 * @covers ::select
	 * @group  Orm
	 */
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

		$postProvider = new PostProvider($GLOBALS['fuelDBConnection']);

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

	/**
	 * @covers ::delete
	 * @group  Orm
	 */
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

		$provider = new PostProvider($GLOBALS['fuelDBConnection']);

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

	/**
	 * @covers ::delete
	 * @group  Orm
	 */
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

		$provider = new PostProvider($GLOBALS['fuelDBConnection']);

		$model1 = $provider->forgeModelInstance($modelData1);
		$model2 = $provider->forgeModelInstance($modelData2);

		$provider->getQuery()
				->delete([$model1, $model2])
				->execute();

		$this->codeGuy->cantSeeInDatabase('posts', $modelData1);
		$this->codeGuy->cantSeeInDatabase('posts', $modelData2);
	}

	/**
	 * @covers ::insert
	 * @group  Orm
	 */
	public function testSingleInsert()
	{
		$model1 = [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		];

		$provider = new PostProvider($GLOBALS['fuelDBConnection']);

		$model = $provider->forgeModelInstance($model1);

		$provider->getQuery()
			->insert([$model])
			->execute();

		$this->codeGuy->canSeeInDatabase('posts', $model1);
	}

	/**
	 * @covers ::insert
	 * @group  Orm
	 */
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

		$provider = new PostProvider($GLOBALS['fuelDBConnection']);

		$model1 = $provider->forgeModelInstance($modelData1);
		$model2 = $provider->forgeModelInstance($modelData2);

		$provider->getQuery()
				->insert([$model1, $model2])
				->execute();

		$this->codeGuy->canSeeInDatabase('posts', $modelData1);
		$this->codeGuy->canSeeInDatabase('posts', $modelData2);
	}

	/**
	 * @covers ::update
	 * @group  Orm
	 */
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

		$provider = new PostProvider($GLOBALS['fuelDBConnection']);
		$model = $provider->forgeModelInstance($model1);

		$model->title = 'shiny new title';
		$provider->getQuery()
			->update($model)
			->execute();

		$model1['title'] = 'shiny new title';
		$this->codeGuy->canSeeInDatabase('posts', $model1);
	}

}
