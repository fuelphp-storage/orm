<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2015 Fuel Development Team
 * @link      http://fuelphp.com
 */


namespace Fuel\Orm\QueryBuilder;

use Fuel\Database\Connection;
use Fuel\Orm\ModelInterface;
use Fuel\Orm\QueryBuilderInterface;
use LogicException;

/**
 * Allows queries to be built and executed using FuelPHP v2's database package.
 *
 * @package Fuel\Orm\QueryBuilder
 *
 * @since 2.0
 */
class Fuel implements QueryBuilderInterface
{

	/**
	 * Contains the query currently being constructed
	 *
	 * @var \Fuel\Database\Collector
	 */
	protected $currentQuery;

	/**
	 * Fuel DBAL connection to the database.
	 *
	 * @var Connection
	 */
	protected $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * {@inheritdoc}
	 */
	public function select($table, $columns = [])
	{
		$this->currentQuery = $this->connection
			->selectArray($columns)
			->from($table);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($table)
	{
		$this->currentQuery = $this->connection->delete($table);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function insert($table, $row)
	{
		$this->currentQuery = $this->connection
			->insert($table);

		if ($row instanceof ModelInterface)
		{
			$row = $row->toArray();
		}

		$this->currentQuery->values($row);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function where($column, $operator, $value)
	{
		if ($this->currentQuery === null)
		{
			throw new LogicException('ORM-006: You must start a query before you can filter it');
		}

		$this->currentQuery->where($column, $operator, $value);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function count($table)
	{
		// TODO: Implement count() method.

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function reset()
	{
		$this->currentQuery = null;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute()
	{
		// TODO Make this work right for count, delete, update and insert queries
		return $this->currentQuery->execute();
	}

	/**
	 * {@inheritdoc}
	 */
	public function update($table, $values)
	{
		$this->currentQuery = $this->connection->update($table);

		foreach ($values as $name => $value)
		{
			// TODO: Add proper PK checks in here
			if ($name !== 'id')
			{
				$this->currentQuery->set($name, $value);
			}
		}

		// TODO: Update to use the actual PK
		$this->where('id', '=', $values['id']);
	}
}
