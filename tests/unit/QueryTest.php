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

		$result = $postProvider->getQuery()->select()->execute();

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


}
