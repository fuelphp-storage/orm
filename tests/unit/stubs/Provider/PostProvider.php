<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Provider;

use Fuel\Orm\Provider;

/**
 * Provides access to the Post table
 *
 * @author  Fuel Development Team
 * @package Fuel\Orm
 */
class PostProvider extends Provider
{

	protected $tableName = 'posts';

	protected $properties = [
		'id',
		'title',
		'description',
		'created_at',
		'updated_at',
	];

}
