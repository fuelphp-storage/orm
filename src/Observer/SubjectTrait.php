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

trait SubjectTrait
{

	/**
	 * Contains all known observers
	 * @var array
	 */
	protected $observers = [];

	/**
	 * Attaches an Observer
	 *
	 * @param ObserverInterface $observer
	 * @param string|string[]   $events
	 *
	 * @since 2.0
	 */
	public function attach(ObserverInterface $observer, $events)
	{
		if ( ! is_array($events))
		{
			$events = [$events];
		}

		foreach ($events as $event)
		{
			$this->observers[$event][] = $observer;
		}
	}

	/**
	 * Triggers a stack of observers
	 *
	 * @param mixed  $subject
	 * @param string $event
	 *
	 * @since 2.0
	 */
	public function trigger($subject, $event)
	{
		foreach ($this->observers[$event] as $observer)
		{
			/** @var ObserverInterface $observer */
			$result = $observer->notify($subject, $event);

			if ($result === false)
			{
				// The observer returned false so stop anything else happening
				break;
			}
		}
	}
}
