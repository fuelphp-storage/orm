<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Behaviour;

use Fuel\Orm\ModelInterface;

/**
 * Defines an interface to allow a provider to be able to insert models
 *
 * @package Fuel\Orm\Behaviour
 * @author  Fuel Development Team
 * @since   2.0
 */
interface CreatableInterface
{

	/**
	 * Inserts new models into the database
	 *
	 * @param ModelInterface $model
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	public function create(ModelInterface $model);

}
