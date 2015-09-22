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

use Fuel\Database\Connection;
use Fuel\Orm\Relation\AbstractRelation;
use InvalidArgumentException;

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
	 * Creates a new instance of the Provider's ModelCollection
	 *
	 * @param ModelInterface[] $models
	 *
	 * @return ModelCollectionInterface
	 *
	 * @since 2.0
	 */
	public function forgeModelCollectionInstance($models = []);

	/**
	 * Creates model instances from assorted data
	 *
	 * @param array $data Data to create models from
	 *
	 * @return ModelInterface|ModelCollectionInterface
	 *
	 * @since 2.0
	 */
	public function hydrate($data);

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
	 * Gets the Connection instance that this provider will use
	 *
	 * @return QueryBuilderInterface
	 *
	 * @since 2.0
	 */
	public function getQueryBuilder();

	/**
	 * Sets the factory that was used to create this provider
	 *
	 * @param ProviderFactory $factory
	 *
	 * @since 2.0
	 */
	public function setFactory(ProviderFactory $factory);

	/**
	 * Checks if the given relation exists
	 *
	 * @param string $name
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	public function hasRelation($name);

	/**
	 * Gets the given relation
	 *
	 * @param string $name
	 *
	 * @return AbstractRelation
	 *
	 * @throws InvalidArgumentException
	 *
	 * @since 2.0
	 */
	public function getRelation($name);

	/**
	 * Adds a relation to this provider
	 *
	 * @param string           $name
	 * @param AbstractRelation $relation
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function addRelation($name, AbstractRelation $relation);

	/**
	 * @return ProviderFactory
	 *
	 * @since 2.0
	 */
	public function getFactory();

}
