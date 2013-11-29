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

use Fuel\Database\DB;
use LogicException;
use RuntimeException;

/**
 * Defines properties of a model and a single point to fetch/save them
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 *
 * @method isReadable
 * @method isCreatable
 * @method isDestroyable
 * @method isMutable
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
	protected $modelClass = '\Fuel\Orm\Model';

	/**
	 * Contains the name of the table this Provider will interact with
	 * @var string
	 */
	protected $tableName;

	/**
	 * DB Class that will be used for interacting with the database
	 * @var DB
	 */
	protected $dbal;

	public function __construct(DB $dbal)
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
		return new Query($this, $this->getDbal());
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

	/**
	 * Sets the DB instance to use to generate queries
	 *
	 * @param DB $dbal
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setDbal($dbal)
	{
		$this->dbal = $dbal;

		return $this;
	}

	/**
	 * Gets the DB instance that this provider will use
	 *
	 * @return DB
	 *
	 * @since 2.0
	 */
	public function getDbal()
	{
		return $this->dbal;
	}

	/**
	 * Magic method to be able to check if interfaces have been implemented
	 *
	 * @param string $name
	 * @param mixed  $args
	 *
	 * @since 2.0
	 */
	public function __call($name, $args)
	{
		// If the name starts with an "is" we can check for interfaces
		if (strpos($name, 'is') === 0)
		{
			// get the name of the interface
			$interfaceName = substr($name, 2);

			$classInterfaces = class_implements(get_called_class());

			// TODO: Make it so you can use behaviours from anywhere
			// Return true/false if that exists or not
			return in_array('Fuel\Orm\Behaviour\\'.$interfaceName.'Interface', $classInterfaces);
		}

		// TODO: make this translatable
		throw new LogicException('No such method '.$name);
	}

}
