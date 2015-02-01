<?php
/**
 * @package   ${PACKAGE}
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2015 Fuel Development Team
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
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 *
	 * @since   2.0.0
	 */
	public function get($key, $default = null);

	/**
	 * @param string $modelClass
	 *
	 * @return void
	 *
	 * @since 2.0
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setModelClass($modelClass);

	/**
	 * Delete data from the container
	 *
	 * @param string $key key to delete
	 *
	 * @return boolean delete success boolean
	 *
	 * @since 2.0
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
	 * @param mixed $key   name of the index
	 * @param mixed $value Value of the index
	 *
	 * @since 2.0
	 */
	public function set($key, $value);

	/**
	 * Sets the parent provider.
	 *
	 * @param ProviderInterface $provider
	 *
	 * @since 2.0
	 */
	public function setProvider(ProviderInterface $provider);

	/**
	 * Gets the provider assigned to this collection.
	 *
	 * @return ProviderInterface
	 *
	 * @since  2.0
	 */
	public function getProvider();

}
