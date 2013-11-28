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
	 * @param $class
	 */
	public function setModelClass($class)
	{
		$this->modelClass = $class;
	}

}
