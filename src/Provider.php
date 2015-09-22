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
use RuntimeException;

/**
 * Defines properties of a model and a single point to fetch/save them
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
class Provider implements ProviderInterface
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
	 * Class that will be used for building queries.
	 * @var QueryBuilderInterface
	 */
	protected $queryBuilder;

	/**
	 * Factory that created this Provider, allows other providers to be referenced by name.
	 * @var ProviderFactory
	 */
	protected $factory;

	public function __construct(QueryBuilderInterface $queryBuilder = null)
	{
		$this->queryBuilder = $queryBuilder;
	}

	/**
	 * Returns a list of properties.
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
	 * Sets the provider's properties.
	 *
	 * @param array $properties
	 *
	 * @since 2.0
	 */
	public function setProperties($properties)
	{
		$this->properties = $properties;
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

		// make sure a collection is returned if needed
		return $this->forgeModelCollectionInstance($models);
	}

	/**
	 * {@inheritdoc}
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
		if ( ! is_subclass_of($this->modelClass, 'Fuel\Orm\ModelInterface'))
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
	 * Gets the name of the table assigned to this Provider.
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
			throw new RuntimeException('ORM-003: No table name specified for [' . get_called_class() . ']');
		}

		return $this->tableName;
	}

	/**
	 * Sets the table name that the provider will use.
	 *
	 * @param string $name
	 *
	 * @since 2.0
	 */
	public function setTableName($name)
	{
		$this->tableName = $name;
	}

	/**
	 * Sets the query builder to use to generate queries
	 *
	 * @param QueryBuilderInterface $queryBuilder
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setQueryBuilder(QueryBuilderInterface $queryBuilder)
	{
		$this->queryBuilder = $queryBuilder;

		return $this;
	}

	/**
	 * Gets the query builder that this provider will use
	 *
	 * @return QueryBuilderInterface
	 *
	 * @since 2.0
	 */
	public function getQueryBuilder()
	{
		return $this->queryBuilder;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addRelation($name, AbstractRelation $relation)
	{
		$this->relations[$name] = $relation;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasRelation($name)
	{
		return isset($this->relations[$name]);
	}

	/**
	 * Gets all relations assigned to this provider
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
	 * {@inheritdoc}
	 */
	public function getRelation($name)
	{
		if ( ! $this->hasRelation($name))
		{
			throw new InvalidArgumentException('ORM-008: Relation ['.$name.'] does not exist in ['.get_called_class().']');
		}

		return $this->relations[$name];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFactory()
	{
		return $this->factory;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setFactory(ProviderFactory $factory)
	{
		$this->factory = $factory;
	}

}
