<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2013 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Behaviour;

use Fuel\Orm\ModelInterface;

/**
 * Defines an interface to allow a provider to be able to update models
 *
 * @package Fuel\Orm\Behaviour
 * @author  Fuel Development Team
 * @since   2.0
 */
interface MutableInterface
{

	/**
	 * Updates the given model
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	public function update(ModelInterface $model);

}
