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

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'SubjectStub.php';

use \SubjectStub;

/**
 * Tests for SubjectTrait
 *
 * @package Fuel\Orm\Observer
 * @author  Fuel Development Team
 *
 * @coversDefaultClass Fuel\Orm\Observer\SubjectTrait
 */
class SubjectTraitTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var SubjectStub
     */
    protected $object;

    protected function setUp()
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

		/** @var ObserverInterface $observer */
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

		/** @var ObserverInterface $observer1 */
		$this->object->attach($observer1, 'test');
		/** @var ObserverInterface $observer2 */
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

		/** @var ObserverInterface $observer1 */
		$this->object->attach($observer1, 'test');
		/** @var ObserverInterface $observer2 */
		$this->object->attach($observer2, 'test');

		$this->object->trigger($this->object, 'test');
	}

}
