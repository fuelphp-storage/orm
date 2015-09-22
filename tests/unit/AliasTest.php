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
use LogicException;

/**
 * Tests for Alias
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 */
class AliasTest extends Test
{

	/**
	 * @var Alias
	 */
	protected $alias;

	protected function _before()
	{
		$this->alias = new Alias;
	}

	public function testTableAlias()
	{
		$name = 'mytable';

		$this->assertEquals(
			't0',
			$this->alias->aliasTable($name)
		);
	}

	public function testTableMultipleAlias()
	{
		$name = 'mytable';

		$this->assertEquals(
			't0',
			$this->alias->aliasTable($name)
		);

		$this->assertEquals(
			't0',
			$this->alias->aliasTable($name)
		);
	}

	public function testMultipleTableAlias()
	{
		$this->assertEquals(
			't0',
			$this->alias->aliasTable('first table')
		);

		$this->assertEquals(
			't1',
			$this->alias->aliasTable('second table')
		);
	}

	public function testReverseTableAlias()
	{
		$this->assertEquals(
			't0',
			$this->alias->aliasTable('table')
		);

		$this->assertEquals(
			'table',
			$this->alias->reverseTableAlias('t0')
		);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testInvalidReverseAlias()
	{
		$this->alias->reverseTableAlias('foobar');
	}
}
