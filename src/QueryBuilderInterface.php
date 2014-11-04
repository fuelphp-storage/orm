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

use LogicException;

/**
 * Defines a common interface for allowing queries to be built. This allows a separation between the Query dev interface
 * and the actual DBAL library meaning the ORM can be fully backend agnostic.
 *
 * The reset method should be used for clearing the current query and starting a new one. The implementing class is not
 * expected to do this automatically.
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
interface QueryBuilderInterface
{

	/**
	 * Starts building a select query.
	 * Each value of $columns should be the name of the column to select. If the value is an array then the first
	 * sub-value is the column name and the second sub-value is the alias.
	 *
	 * @param string $table      Name of the table to perform operations on
	 * @param array  $columns If empty then selecting all columns should be assumed
	 *
	 * @return $this
	 *
	 * @since  2.0
	 */
	public function select($table, $columns = []);

	/**
	 * Starts building a delete query
	 *
	 * @param string $table
	 *
	 * @return $this
	 *
	 * @since  2.0
	 */
	public function delete($table);

	/**
	 * Starts building an insert query.
	 * $values should be an array of arrays, each child array should contain new values indexed by column name.
	 *
	 * @param string           $table
	 * @param ModelInterface[] $values
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function insert($table, $values);

	/**
	 * Starts building an update query.
	 *
	 * @param string $table
	 * @param array  $values
	 *
	 * @return $this
	 *
	 * @since  2.0
	 */
	public function update($table, $values);

	/**
	 * Adds a where statement to the query
	 *
	 * @param string $column
	 * @param string $operator
	 * @param mixed  $value
	 *
	 * @return $this
	 *
	 * @throws LogicException Should be thrown if a query has not yet been started.
	 *
	 * @since 2.0
	 */
	public function where($column, $operator, $value);

	/**
	 * Starts building a count query.
	 *
	 * @param string $table
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function count($table);

	/**
	 * Should clear any built query and reset the class back to a "new" state.
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function reset();

	/**
	 * Executes the built query.
	 *
	 * If this is a select query then an array of data should be returned. An array element for each result containing
	 * key value pairs.
	 *
	 * If this is an insert or delete query then an array should be returned with the first value as the number of affected
	 * rows.
	 *
	 * If this is a count query then an array should be returned where the first element is the count of rows.
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function execute();

}
