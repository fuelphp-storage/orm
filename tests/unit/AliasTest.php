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
 * @coversDefaultClass Fuel\Orm\Alias
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

	/**
	 * @covers ::aliasTable
	 * @group  Orm
	 */
	public function testTableAlias()
	{
		$name = 'mytable';

		$this->assertEquals(
			't0',
			$this->alias->aliasTable($name)
		);
	}

	/**
	 * @covers ::aliasTable
	 * @group  Orm
	 */
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

	/**
	 * @covers ::aliasTable
	 * @group  Orm
	 */
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

	/**
	 * @covers ::reverseTableAlias
	 * @group  Orm
	 */
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
	 * @group             Orm
	 */
	public function testInvalidReverseAlias()
	{
		$this->alias->reverseTableAlias('foobar');
	}
}
