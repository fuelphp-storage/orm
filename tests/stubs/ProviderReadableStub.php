<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2013 Fuel Development Team
 * @link      http://fuelphp.com
 */

use Fuel\Orm\Behaviour\ReadableInterface;

require_once 'ProviderStub.php';

/**
 * Sub class for testing Provider
 *
 * @author  Fuel Development Team
 * @package Fuel\Orm
 */
class ProviderReadableStub extends ProviderStub implements ReadableInterface
{

	/**
	 * Loads models from the database
	 *
	 * @return \Fuel\Orm\ModelInterface
	 *
	 * @since 2.0
	 */
	public function find()
	{
		// TODO: Implement find() method.
	}
}
