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

use Fuel\Database\Connection;
use Fuel\Orm\Relation\AbstractRelation;
use InvalidArgumentException;
use RuntimeException;

/**
 * Defines properties of a model and a single point to fetch/save them
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
abstract class Provider implements ProviderInterface
{

	/**
	 * An array containing a list of properties for the model
	 * @var array
	 */
	protected $properties = [];

	/**
	 * Contains the full name of the class that this provider will use for models
	 * @var string
	 */
	protected $modelClass = 'Fuel\Orm\Model';

	/**
	 * Contains the full name of the class that this provider will use for model collections
	 * @var string
	 */
	protected $modelCollectionClass = 'Fuel\Orm\ModelCollection';

	/**
	 * Contains the name of the table this Provider will interact with
	 * @var string
	 */
	protected $tableName;

	/**
	 * Contains a list of known relations indexed by name
	 * @var AbstractRelation[]
	 */
	protected $relations = [];

	/**
	 * Connection class that will be used for interacting with the database
	 * @var Connection
	 */
	protected $dbal;

	public function __construct(Connection $dbal)
	{
		$this->setDbal($dbal);
	}

	/**
	 * Returns a list of properties
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
 	* Creates a new instance of the Provider's Model
 	*
 	* @param array $data Optional default data for the Model to contain
 	*
 	* @return ModelInterface
 	*
 	* @since 2.0
 	*/
	public function forgeModelInstance($data = [])
	{
		$class = $this->getModelClass();

		/** @type ModelInterface $instance */
		$instance = new $class((array) $data);
		$instance->setProvider($this);

		return $instance;
	}

	/**
	 * Creates model instances from assorted data
	 *
	 * @param array $data
	 *
	 * @return ModelCollectionInterface|ModelInterface
	 *
	 * @since 2.0
	 */
	public function hydrate($data)
	{
		$models = [];

		foreach ($data as $modelData)
		{
			$models[] = $this->forgeModelInstance($modelData);
		}

		if (count($models) == 1)
		{
			return $models[0];
		}

		// TODO: make sure a collection is returned if needed
		return $this->forgeModelCollectionInstance($models);
	}

	/**
	 * Creates a new instance of the Provider's ModelCollection
	 *
	 * @param ModelInterface[] $models
	 *
	 * @return ModelCollectionInterface
	 *
	 * @since 2.0
	 */
	public function forgeModelCollectionInstance($models = [])
	{
		$class = $this->getModelCollectionClass();

		/** @type ModelCollectionInterface $instance */
		$instance = new $class($models);

		$instance->setModelClass($this->getModelClass());
		$instance->setProvider($this);

		return $instance;
	}

	/**
	 * Gets the class name of the model that this provider will create.
	 *
	 * @return string
	 *
	 * @throws RuntimeException
	 *
	 * @since 2.0
	 */
	public function getModelClass()
	{
		if ( ! in_array('Fuel\Orm\ModelInterface', class_implements($this->modelClass)))
		{
			throw new RuntimeException('ORM-002: The given model class must implement ModelInterface');
		}

		return $this->modelClass;
	}

	/**
	 * Gets the class name of the model collection that this provider will use
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getModelCollectionClass()
	{
		return $this->modelCollectionClass;
	}

	/**
	 * Gets a Query object that can be used to interact with this provider's table
	 *
	 * @return QueryInterface
	 *
	 * @since 2.0
	 */
	public function getQuery()
	{
		return new Query($this);
	}

	/**
	 * Gets the name of the table assigned to this Provider
	 *
	 * @return string
	 *
	 * @throws RuntimeException If there is no specified table name
	 *
	 * @since 2.0
	 */
	public function getTableName()
	{
		if ($this->tableName === null)
		{
			throw new RuntimeException('ORM-003: No table name specified for [' . get_class() . ']');
		}

		return $this->tableName;
	}

	/**
	 * Sets the DB instance to use to generate queries
	 *
	 * @param Connection $dbal
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setDbal(Connection $dbal)
	{
		$this->dbal = $dbal;

		return $this;
	}

	/**
	 * Gets the DB instance that this provider will use
	 *
	 * @return Connection
	 *
	 * @since 2.0
	 */
	public function getDbal()
	{
		return $this->dbal;
	}

	/**
	 * Gets all relations
	 *
	 * @return AbstractRelation[]
	 *
	 * @since 2.0
	 */
	public function getRelations()
	{
		return $this->relations;
	}

	/**
	 * Adds a new relation to the provider. Please note, adding a relation twice with the same name will result in the
	 * first one being overridden.
	 *
	 * @param string           $name
	 * @param AbstractRelation $relation
	 *
	 * @since 2.0
	 */
	public function addRelation($name, AbstractRelation $relation)
	{
		$this->relations[$name] = $relation;
	}

	/**
	 * Removes a relation from the provider
	 *
	 * @param string $name
	 *
	 * @since 2.0
	 */
	public function removeRelation($name)
	{
		unset($this->relations[$name]);
	}

	/**
	 * Gets a single relation
	 *
	 * @param string $name
	 *
	 * @return AbstractRelation
	 *
	 * @since 2.0
	 */
	public function getRelation($name)
	{
		if ( ! array_key_exists($name, $this->relations))
		{
			throw new InvalidArgumentException("ORM-008: Relation [{$name}] does not exist in [".get_called_class().']');
		}

		return $this->relations[$name];
	}

	/**
	 * Sets the relations array, should be indexed by relation name.
	 *
	 * @param AbstractRelation[] $relations
	 *
	 * @since 2.0
	 */
	public function setRelations($relations)
	{
		$this->relations = $relations;
	}

}
