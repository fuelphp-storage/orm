<?php
/**
 * @package   Fuel\Orm\Query
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2014 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Query;

use Fuel\Orm\ProviderInterface;

/**
 * Allows queries of various kinds to be constructed
 *
 * @package Fuel\Orm\Query
 * @author  Fuel Development Team
 * @since   2.0
 */
class Builder
{

	/**
	 * @var ProviderInterface
	 */
	protected $provider;

	/**
	 * @var array
	 */
	protected $aliases = [];

	/**
	 * Contains the next alias number to use
	 * @var int
	 */
	protected $nextAliasNumber = 0;

	public function __construct(ProviderInterface $provider)
	{
		$this->setProvider($provider);
	}

	/**
	 * @return ProviderInterface
	 */
	public function getProvider()
	{
		return $this->provider;
	}

	/**
	 * @param ProviderInterface $provider
	 */
	public function setProvider($provider)
	{
		$this->provider = $provider;
	}

	/**
	 * Returns the alias that will be used for the Provider's table
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function getTableAlias()
	{
		// TODO: make this aware of when multiple tables are in play
		return 't0';
	}

	/**
	 * @param $property string
	 *
	 * @return mixed
	 *
	 * @since 2.0
	 */
	public function getPropertyAlias($property)
	{
		if ( ! array_key_exists($property, $this->aliases))
		{
			$this->createTableAlias($property);
		}

		return $this->aliases[$property];
	}

	/**
	 * @param $property string
	 *
	 * @since 2.0
	 */
	protected function createTableAlias($property)
	{
		$this->aliases[$property] = $this->getTableAlias() . '.c' . $this->nextAliasNumber;
		$this->nextAliasNumber ++;
	}

}
