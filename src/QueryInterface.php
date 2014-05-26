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

/**
 * Allows Providers to interact with the database
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
interface QueryInterface
{
	/**
	 * Gets the provider that this Query belongs to
	 *
	 * @return ProviderInterface
	 *
	 * @since 2.0
	 */
	public function getProvider();

	/**
	 * Sets the provider that this Query belongs to
	 *
	 * @param ProviderInterface $provider
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setProvider(ProviderInterface $provider);

	/**
	 * Inserts a model or number of models
	 *
	 * @param array|ModelInterface $models Models to insert
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function insert($models);

	/**
	 * Deletes a model or number of models
	 *
	 * @param array|ModelInterface $models Models to delete
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function delete($models);

	/**
	 * Fetches a model or number of models
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function select();

	/**
	 * Executes the prepared query
	 *
	 * @return bool|array|ModelInterface
	 *
	 * @since 2.0
	 */
	public function execute();

	/**
	 * Updates a model or number of models
	 *
	 * @param array|ModelInterface $models Models to update
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function update($models);
}
