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
use LogicException;

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
	public function insert($models)
	{
		$this->getProvider()
			->getQueryBuilder()
			->insert($this->provider->getTableName(), $models);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($models)
	{
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
		$this->resultNeedsHydration = true;

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
		$this->getProvider()
			->getQueryBuilder()
			->reset();

		return $this;
	}

}
