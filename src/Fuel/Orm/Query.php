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
class Query implements QueryInterface
{

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
	 * @param array|ModelInterface $models Models to insert
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function insert($models)
	{
		// TODO: Implement insert() method.
	}

	/**
	 * Deletes a model or number of models
	 *
	 * @param array|ModelInterface $models Models to delete
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function delete($models)
	{
		// TODO: Implement delete() method.
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
		// TODO: Implement select() method.
	}

	/**
	 * Executes the prepared query
	 *
	 * @return bool|array|ModelInterface
	 *
	 * @since 2.0
	 */
	public function execute()
	{
		// TODO: Implement execute() method.
	}

	/**
	 * Updates a model or number of models
	 *
	 * @param array|ModelInterface $models Models to update
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function update($models)
	{
		// TODO: Implement update() method.
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
