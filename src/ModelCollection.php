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

use Fuel\Common\DataContainer;

/**
 * Allows interaction with collections of Models
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
class ModelCollection extends DataContainer implements ModelCollectionInterface
{

	/**
	 * Contains the class name of the model type this collection accepts.
	 * Defaults to \Fuel\Orm\Model
	 *
	 * @var string
	 */
	protected $modelClass = '\Fuel\Orm\Model';

	/**
	 * Contains the parent provider
	 *
	 * @var ProviderInterface
	 */
	protected $provider;

	/**
	 * Gets the full class name that this collection will accept
	 *
	 * @return string
	 *
	 * @since  2.0
	 */
	public function getModelClass()
	{
		return $this->modelClass;
	}

	/**
	 * @param string $modelClass
	 *
	 * @since 2.0
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setModelClass($modelClass)
	{
		if ( ! is_string($modelClass))
		{
			$actualClass = gettype($modelClass);

			if (is_object($modelClass))
			{
				$actualClass = get_class($modelClass);
			}

			throw new \InvalidArgumentException('ORM-004: The model class name must be a string, [' . $actualClass . '] passed instead.');
		}

		$this->modelClass = $modelClass;
	}

	/**
	 * The given value must be an instance of the $modelClass
	 *
	 * @inheritdoc
	 */
	public function set($key, $value)
	{
		$targetClass = $this->getModelClass();
		if ( ! is_object($value) or ! $value instanceof $targetClass)
		{
			$actualClass = gettype($value);

			if (is_object($value))
			{
				$actualClass = get_class($value);
			}

			throw new \InvalidArgumentException('ORM-005: Invalid model instance. Expecting [' . $this->getModelClass() . '] got [' . $actualClass . ']');
		}

		return parent::set($key, $value);
	}

	/**
	 * Sets the parent provider.
	 *
	 * @param ProviderInterface $provider
	 *
	 * @since 2.0
	 */
	public function setProvider(ProviderInterface $provider)
	{
		$this->provider = $provider;
	}

	/**
	 * Gets the provider assigned to this collection.
	 *
	 * @return ProviderInterface
	 *
	 * @since  2.0
	 */
	public function getProvider()
	{
		return $this->provider;
	}
}
