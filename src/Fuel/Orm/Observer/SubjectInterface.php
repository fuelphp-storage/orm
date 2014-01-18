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
 * Defines an object that can be observed
 *
 * @package Fuel\Orm\Observer
 * @author  Fuel Development Team
 * @since   2.0
 */
interface SubjectInterface
{

	/**
	 * Attaches an Observer
	 *
	 * @param ObserverInterface $observer
	 * @param string|string[]   $events
	 *
	 * @since 2.0
	 */
	public function attach(ObserverInterface $observer, $events);

	/**
	 * Triggers a stack of observers
	 *
	 * @param mixed  $subject
	 * @param string $event
	 *
	 * @since 2.0
	 */
	public function trigger($subject, $event);

}
