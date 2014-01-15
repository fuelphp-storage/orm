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

use Fuel\Database\DB;

/**
 * Defines a common interface for classes that define models
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
interface ProviderInterface
{

	/**
	 * Returns a list of properties
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function getProperties();

	/**
	 * Creates a new instance of the Provider's Model
	 *
	 * @param array $data Optional default data for the Model to contain
	 *
	 * @return ModelInterface
	 *
	 * @since 2.0
	 */
	public function forgeModelInstance($data = []);

	/**
	 * Gets a Query object that can be used to interact with the provider's table
	 *
	 * @return QueryInterface
	 *
	 * @since 2.0
	 */
	public function getQuery();

	/**
	 * Gets the name of the table assigned to this Provider
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getTableName();

	/**
	 * Gets the DB instance that this provider will use
	 *
	 * @return DB
	 *
	 * @since 2.0
	 */
	public function getDbal();

}
