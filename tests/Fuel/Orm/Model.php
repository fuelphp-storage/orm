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

/**
 * Tests for Model
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 */
class Model extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Model
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new Model;
	}

}
