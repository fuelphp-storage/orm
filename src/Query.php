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

use Fuel\Orm\Observer\SubjectInterface;
use Fuel\Orm\Observer\SubjectTrait;

/**
 * Allows Providers to interact with the database
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
class Query implements QueryInterface, SubjectInterface
{

	use SubjectTrait;

	/**
	 * @var ProviderInterface
	 */
	protected $provider;

	/**
	 * @var array
	 */
	protected $aliases = [];

	/**
	 * Contains the next alias number to use for properties
	 *
	 * @var int
	 */
	protected $nextAliasNumber = 0;

	/**
	 * Contains the query currently being constructed
	 *
	 * @var \Fuel\Database\Collector
	 */
	protected $currentQuery;

	/**
	 * Is set to true if the query result will need hydration or not. Used for select() queries.
	 *
	 * @var bool
	 */
	protected $resultNeedsHydration = false;

	/**
	 * @param ProviderInterface $provider Provider that owns this Query
	 *
	 * @since 2.0
	 */
	public function __construct(ProviderInterface $provider)
	{
		$this->setProvider($provider);
	}

	/**
	 * Sets the provider that this Query belongs to
	 *
	 * @param ProviderInterface $provider
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setProvider(ProviderInterface $provider)
	{
		$this->provider = $provider;

		return $this;
	}

	/**
	 * Gets the provider that this Query belongs to
	 *
	 * @return ProviderInterface
	 *
	 * @since 2.0
	 */
	public function getProvider()
	{
		return $this->provider;
	}

	/**
	 * Inserts a model or number of models
	 *
	 * @param ModelInterface[] $models Models to insert
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function insert($models)
	{
		$provider = $this->getProvider();

		$dbal = $provider->getDbal();

		$this->currentQuery = $dbal
			->insert($provider->getTableName());

		foreach ($models as $model)
		{
			$this->currentQuery->values($model->toArray());
		}

		return $this;
	}

	/**
	 * Deletes a model or number of models
	 *
	 * @param ModelInterface[] $models Models to delete
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function delete($models)
	{
		$provider = $this->getProvider();

		$dbal = $provider->getDbal();

		$this->currentQuery = $dbal->delete($provider->getTableName());

		$inIds = [];

		foreach ($models as $model)
		{
			$inIds = $model->id;
		}

		// TODO: make sure this uses the actual PK
		if (count($inIds) > 1)
		{
			$this->currentQuery->where('id', 'IN', $inIds);
		}
		else
		{
			$this->currentQuery->where('id', $inIds);
		}

		return $this;
	}

	/**
	 * Fetches a model or number of models
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function select()
	{
		$this->resultNeedsHydration = true;

		$provider = $this->getProvider();

		$columns = $provider->getProperties();

		$dbal = $provider->getDbal();

		// WTF?
		$firstColumn = array_shift($columns);
		$this->currentQuery = $dbal->select($firstColumn);

		foreach ($columns as $column)
		{
			$this->currentQuery->select($column);
		}

		$this->currentQuery->from($provider->getTableName());

		return $this;
	}

	/**
	 * Updates a single model.
	 *
	 * @param ModelInterface $model
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function update($model)
	{
		// TODO: Find out if multiple inserts can be done together.

		$provider = $this->getProvider();

		$this->currentQuery = $provider->getDbal()
			->update($provider->getTableName());

		foreach ($model as $name => $value)
		{
			if ($name !== 'id')
			{
				$this->currentQuery->set($name, $value);
			}
		}

		// TODO: Update to use the actual PK
		$this->currentQuery->where('id', $model->id);

		return $this;
	}

	/**
	 * Executes the prepared query
	 *
	 * @return ModelInterface|ModelCollectionInterface|null
	 *
	 * @since 2.0
	 */
	public function execute()
	{
		$result = $this->currentQuery->execute();

		if ($this->resultNeedsHydration)
		{
			return $this->getProvider()
				->hydrate($result);
		}

		// Not directly needed but added for clarity
		return $result;
	}

	/**
	 * Resets the currently built query
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function reset()
	{
		$this->currentQuery = null;

		return $this;
	}

	/**
	 * Gets the query currently being constructed
	 *
	 * @return \Fuel\Database\Collector
	 *
	 * @since 2.0
	 */
	public function getCurrentQuery()
	{
		return $this->currentQuery;
	}

	/**
	 * Returns the alias that will be used for the Provider's table
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getTableAlias()
	{
		// TODO: make this aware of when multiple tables are in play
		return 't0';
	}

	/**
	 * Gets an alias for the given property
	 *
	 * @param $property string
	 *
	 * @return mixed
	 *
	 * @since 2.0
	 */
	public function getPropertyAlias($property)
	{
		if ( ! array_key_exists($property, $this->aliases))
		{
			$this->createPropertyAlias($property);
		}

		return $this->aliases[$property];
	}

	/**
	 * Creates an alias for a given property
	 *
	 * @param $property string
	 *
	 * @since 2.0
	 */
	protected function createPropertyAlias($property)
	{
		$this->aliases[$property] = $this->getTableAlias() . '.c' . $this->nextAliasNumber;
		$this->nextAliasNumber++;
	}

}
