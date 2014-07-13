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

use Codeception\TestCase\Test;
use \SubjectStub;

/**
 * Tests for SubjectTrait
 *
 * @package Fuel\Orm\Observer
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Orm\Observer\SubjectTrait
 */
class SubjectTraitTest extends Test {

    /**
     * @var SubjectStub
     */
    protected $object;

    protected function _before()
    {
		$this->object = new SubjectStub;
    }

	/**
	 * @covers ::attach
	 * @covers ::trigger
	 * @group  Orm
	 */
	public function testSimpleObserver()
	{
		$observer = \Mockery::mock('Fuel\Orm\Observer\ObserverInterface');
		$observer->shouldReceive('notify')->with($this->object, 'test')->once();

		/** @type ObserverInterface $observer */
		$this->object->attach($observer, 'test');

		$this->object->trigger($this->object, 'test');
	}

	/**
	 * @covers ::attach
	 * @covers ::trigger
	 * @group  Orm
	 */
	public function testMultipleObservers()
	{
		$observer1 = \Mockery::mock('Fuel\Orm\Observer\ObserverInterface');
		$observer1->shouldReceive('notify')->with($this->object, 'test')->once();

		$observer2 = \Mockery::mock('Fuel\Orm\Observer\ObserverInterface');
		$observer2->shouldReceive('notify')->with($this->object, 'test')->once();

		/** @type ObserverInterface $observer1 */
		$this->object->attach($observer1, 'test');
		/** @type ObserverInterface $observer2 */
		$this->object->attach($observer2, 'test');

		$this->object->trigger($this->object, 'test');
	}

	/**
	 * @covers ::attach
	 * @covers ::trigger
	 * @group  Orm
	 */
	public function testStopStack()
	{
		$observer1 = \Mockery::mock('Fuel\Orm\Observer\ObserverInterface');
		$observer1->shouldReceive('notify')->with($this->object, 'test')->once()->andReturn(false);

		$observer2 = \Mockery::mock('Fuel\Orm\Observer\ObserverInterface');
		$observer2->shouldReceive('notify')->never();

		/** @type ObserverInterface $observer1 */
		$this->object->attach($observer1, 'test');
		/** @type ObserverInterface $observer2 */
		$this->object->attach($observer2, 'test');

		$this->object->trigger($this->object, 'test');
	}

}
