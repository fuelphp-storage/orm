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
 * Allows Providers to interact with the database
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
class Query
{

	/**
	 * @var ProviderInterface
	 */
	protected $provider;

	public function __construct(ProviderInterface $provider)
	{
		$this->setProvider($provider);
	}

	/**
	 * Sets the provider that this Query belongs to
	 *
	 * @param ProviderInterface $provider
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setProvider(ProviderInterface $provider)
	{
		$this->provider = $provider;

		return $this;
	}

	/**
	 * Gets the provider that this Query belongs to
	 *
	 * @return ProviderInterface
	 *
	 * @since 2.0
	 */
	public function getProvider()
	{
		return $this->provider;
	}

}
