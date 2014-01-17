<?php
/**
 * @package   ${PACKAGE}
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm;

/**
 * Allows interaction with collections of Models
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
interface ModelCollectionInterface
{

	/**
	 * Get a key's value from this bag's data
	 *
	 * @param   string $key
	 * @param   mixed  $default
	 *
	 * @return  mixed
	 * @since   2.0.0
	 */
	public function get($key, $default = null);

	/**
	 * @param string $modelClass
	 *
	 * @since 2.0
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setModelClass($modelClass);

	/**
	 * Delete data from the container
	 *
	 * @param   string $key key to delete
	 *
	 * @return  boolean  delete success boolean
	 * @since   2.0.0
	 */
	public function delete($key);

	/**
	 * Gets the full class name that this collection will accept
	 *
	 * @return string
	 *
	 * @since  2.0
	 */
	public function getModelClass();

	/**
	 * The given value must be an instance of the $modelClass
	 *
	 * @inheritdoc
	 */
	public function set($key, $value);

}
