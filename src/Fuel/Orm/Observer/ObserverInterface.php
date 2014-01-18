<?php
/**
 * @package   Fuel\Orm\Observer
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Observer;

/**
 * Responds to an observable object.
 *
 * @package Fuel\Orm\Observer
 * @author  Fuel Development Team
 * @since   2.0
 */
interface ObserverInterface
{

	/**
	 * Is called when one of this observer's events are triggered in the object it is listening to.
	 * If this method returns boolean false the event processing will end.
	 *
	 * @param Object $subject
	 * @param string $event
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	function notify($subject, $event);

}
