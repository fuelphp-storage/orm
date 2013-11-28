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

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'AbstractProviderStub.php';

/**
 * Tests for AbstractProvider
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @covers  Fuel\Orm\AbstractProvider
 */
class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var \AbstractProviderStub
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new \AbstractProviderStub();
	}

	/**
	 * @coversDefaultClass getProperties
	 * @group              Orm
	 */
	public function testGetProperties()
	{
		$this->assertEquals(
			['a','b','c',],
			$this->object->getProperties()
		);
	}

	/**
	 * @coversDefaultClass forgeModelInstance
	 * @group              Orm
	 */
	public function testGetModel()
	{
		$data = ['test'];
		$result = $this->object->forgeModelInstance($data);

		// Make sure we have a model
		$this->assertInstanceOf(
			'Fuel\Orm\Model',
			$result
		);

		// Make sure the data has been set
		$this->assertEquals(
			$data,
			$result->getOriginalData()->getContents()
		);

		// And make sure the provider has been set
		$this->assertEquals(
			$this->object,
			$result->getProvider()
		);
	}

	/**
	 * @coversDefaultClass getModelClass
	 * @group              Orm
	 */
	public function testGetModelClass()
	{
		$this->assertEquals(
			'\Fuel\Orm\Model',
			$this->object->getModelClass()
		);
	}

	/**
	 * @coversDefaultClass getModelClass
	 * @expectedException  \RuntimeException
	 * @group              Orm
	 */
	public function testGetModelClassInvalid()
	{
		$this->object->setModelClass('\stdClass');

		$this->object->getModelClass();
	}

}
