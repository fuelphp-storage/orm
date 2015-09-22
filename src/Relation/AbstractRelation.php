<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2015 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Relation;

use Fuel\Orm\ModelCollectionInterface;
use Fuel\Orm\ModelInterface;

/**
 * Defines a relation between two providers
 *
 * @package Fuel\Orm
 * @since   2.0
 */
abstract class AbstractRelation
{

	/**
	 * The key that represents the relation on the left hand side
	 *
	 * @var string
	 */
	protected $keyFrom;

	/**
	 * Class name or identifier of the provider on the left hand side of the relation
	 *
	 * @var string
	 */
	protected $providerFrom;

	/**
	 * The key that represents the relation on the right hand side
	 *
	 * @var string
	 */
	protected $keyTo;

	/**
	 * Class name or identifier of the provider on the right hand side of the relation
	 *
	 * @var string
	 */
	protected $providerTo;

	/**
	 * Returns the models that are represented by the relationship.
	 *
	 * @param ModelInterface  $modelFrom The parent, or left hand, model.
	 *
	 * @return ModelInterface|ModelCollectionInterface
	 */
	abstract public function getModels(ModelInterface $modelFrom);

	/**
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getKeyFrom()
	{
		return $this->keyFrom;
	}

	/**
	 * @param string $keyFrom
	 *
	 * @since 2.0
	 */
	public function setKeyFrom($keyFrom)
	{
		$this->keyFrom = $keyFrom;
	}

	/**
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getProviderFrom()
	{
		return $this->providerFrom;
	}

	/**
	 * @param string $providerFrom
	 *
	 * @since 2.0
	 */
	public function setProviderFrom($providerFrom)
	{
		$this->providerFrom = $providerFrom;
	}

	/**
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getKeyTo()
	{
		return $this->keyTo;
	}

	/**
	 * @param string $keyTo
	 *
	 * @since 2.0
	 */
	public function setKeyTo($keyTo)
	{
		$this->keyTo = $keyTo;
	}

	/**
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getProviderTo()
	{
		return $this->providerTo;
	}

	/**
	 * @param string $providerTo
	 *
	 * @since 2.0
	 */
	public function setProviderTo($providerTo)
	{
		$this->providerTo = $providerTo;
	}

}
