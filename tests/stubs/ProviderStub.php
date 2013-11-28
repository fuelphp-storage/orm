<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2013 Fuel Development Team
 * @link      http://fuelphp.com
 */

/**
 * Sub class for testing Provider
 *
 * @author  Fuel Development Team
 * @package Fuel\Orm
 */
class ProviderStub extends \Fuel\Orm\Provider
{

	protected $properties = [
		'a', 'b', 'c',
	];

	/**
	 * Used to be able to easily test invalid model classes
	 *
	 * @param string $class
	 */
	public function setModelClass($class)
	{
		$this->modelClass = $class;
	}

	/**
	 * Used to set the value of the table name property for testing
	 *
	 * @param string $name
	 */
	public function setTableName($name)
	{
		$this->tableName = $name;
	}

}
