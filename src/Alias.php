<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2015 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm;

use LogicException;

/**
 * Responsible for creating and maintaining table and column aliases.
 *
 * @package Fuel\Orm
 * @since   2.0
 */
class Alias
{

	/**
	 * Keeps track of the next table alias number
	 *
	 * @var int
	 */
	protected $tableAliasCounter = 0;

	/**
	 * Keeps track of table aliases, indexed by the real table name
	 *
	 * @var string[]
	 */
	protected $tableAliases = [];

	/**
	 * Aliases the given table name.
	 *
	 * The same alias will always be returned for the same table name per instance.
	 *
	 * @param string $table
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function aliasTable($table)
	{
		if ( ! array_key_exists($table, $this->tableAliases))
		{
			// The alias does not exist yet so create one
			$this->tableAliases[$table] = 't' . $this->tableAliasCounter++;
		}

		return $this->tableAliases[$table];
	}

	/**
	 * Takes an existing table alias and returns a table name if the alias is known.
	 *
	 * @param string $alias
	 *
	 * @return string
	 *
	 * @throws LogicException
	 *
	 * @since 2.0
	 */
	public function reverseTableAlias($alias)
	{
		$searchResult = array_search($alias, $this->tableAliases);

		if ($searchResult === false)
		{
			throw new LogicException('ORM-007: ['.$alias.'] is not a known alias');
		}

		return $searchResult;
	}

}
