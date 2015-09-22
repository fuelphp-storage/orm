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
use Fuel\Orm\QueryBuilder\Fuel;

/**
 * Testes relating to has-many relationships.
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 *
 * @property \CodeGuy $codeGuy
 */
class RelationHasManyTest extends Test
{

	/**
	 * @var ProviderFactory
	 */
	protected $factory;

	protected function _before()
	{
		$this->factory = new ProviderFactory(
			new Fuel($this->codeGuy->getDbInstance())
		);

		$this->factory->add(
			'posts',
			['id', 'title', 'description', 'created_at', 'updated_at', 'author_id'],
			'posts',
			[
				'hasMany' => [
					'comments' => [
						'providerTo' => 'comments',
						'keyFrom' => 'id',
						'keyTo' => 'post_id',
					],
				],
			]
		);

		$this->factory->add(
			'comments',
			['id', 'post_id', 'body'],
			'comments'
		);
	}

	public function testSelect()
	{
		$this->codeGuy->haveInDatabase('posts', [
			'id' => '1',
			'title' => 'title',
			'description' => 'description',
			'created_at' => 123,
			'updated_at' => 321,
		]);

		$commentData = [
			'id' => '1',
			'post_id' => '1',
			'body' => 'Some interesting comment',
		];
		$this->codeGuy->haveInDatabase('comments', $commentData);

		$provider = $this->factory->get('posts');
		$post = $provider
			->getQuery()
			->select()
			->where('id', 1)
			->select()
			->execute();

		$this->assertInstanceOf(
			'Fuel\Orm\ModelCollectionInterface',
			$post->comments
		);

		$this->assertEquals(
			$commentData,
			$post->comments[0]->get()
		);
	}

}
