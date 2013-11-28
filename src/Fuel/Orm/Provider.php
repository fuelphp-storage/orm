<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2013 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm;

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
	protected $modelClass = '\Fuel\Orm\Model';

	/**
	 * Contains the name of the table this Provider will interact with
	 * @var string
	 */
	protected $tableName;

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

		/** @var ModelInterface $instance */
		$instance = new $class($data);
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
			// TODO: make this translatable
			throw new RuntimeException('The given model class must implement ModelInterface');
		}

		return $this->modelClass;
	}

	/**
	 * Gets a Query object that can be used to interact with this provider's table
	 *
	 * @return Query
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
	 * @since 2.0
	 */
	public function getTableName()
	{
		if ($this->tableName === null)
		{
			// TODO: Make this translatable
			throw new RuntimeException('No table name specified for '.get_class());
		}

		return $this->tableName;
	}
}
