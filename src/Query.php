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

	public static $QUERY_INSERT = 1;
	public static $QUERY_SELECT = 2;
	public static $QUERY_DELETE = 3;
	public static $QUERY_UPDATE = 4;

	/**
	 * Defines the current query type
	 * @var int
	 */
	protected $queryType;

	/**
	 * @var ProviderInterface
	 */
	protected $provider;

	/**
	 * Contains the model that is currently being inserted
	 * @var ModelInterface
	 */
	protected $insertModel;

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
	 * {@inheritdoc}
	 */
	public function setProvider(ProviderInterface $provider)
	{
		$this->provider = $provider;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getProvider()
	{
		return $this->provider;
	}

	/**
	 * {@inheritdoc}
	 */
	public function insert($model)
	{
		$this->queryType = static::$QUERY_INSERT;
		$this->getProvider()
			->getQueryBuilder()
			->insert($this->provider->getTableName(), $model);

		$this->insertModel = $model;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($models)
	{
		$this->queryType = static::$QUERY_DELETE;
		$provider = $this->getProvider();
		$builder = $provider->getQueryBuilder();

		$builder->delete($provider->getTableName());

		$inIds = [];

		foreach ($models as $model)
		{
			// TODO: make sure this uses the actual PK
			$inIds[] = $model->id;
		}

		if (count($inIds) > 1)
		{
			$builder->where('id', 'IN', $inIds);
		}
		else
		{
			$builder->where('id', '=', $inIds);
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function select()
	{
		$this->queryType = static::$QUERY_SELECT;

		$provider = $this->getProvider();

		$this->provider
			->getQueryBuilder()
			->select($provider->getTableName(), $provider->getProperties());

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function update($model)
	{
		// TODO: Find out if multiple updates can be done together.
		// TODO: Use model diffs to make the queries smaller

		$this->queryType = static::$QUERY_UPDATE;
		$this->getProvider()
			->getQueryBuilder()
			->update($this->getProvider()->getTableName(), $model);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function where($property, $operator, $value = null)
	{
		if ($value === null)
		{
			$value = $operator;
			$operator = '=';
		}

		$this->provider->getQueryBuilder()
			->where($property, $operator, $value);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute()
	{
		$result = $this->getProvider()
			->getQueryBuilder()
			->execute();

		if ($this->queryType == static::$QUERY_SELECT)
		{
			return $this->getProvider()
				->hydrate($result);
		}
		elseif ($this->queryType == static::$QUERY_INSERT)
		{
			// get the id and pass that to the model
			$id = $result[0];
			// TODO: move this to the provider
			$this->insertModel['id'] = $id;
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
		$this->insertModel = null;
		$this->queryType = null;
		$this->getProvider()
			->getQueryBuilder()
			->reset();

		return $this;
	}

}
