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

use Fuel\Common\DataContainer;

/**
 * Defines common functionality for a data model
 *
 * @package Fuel\Orm
 * @author  Fuel Development Team
 * @since   2.0
 */
interface ModelInterface
{
	/**
	 * Sets the Provider that created this model
	 *
	 * @param ProviderInterface $provider
	 *
	 * @return $this
	 */
	public function setProvider(ProviderInterface $provider);

	/**
	 * Sets the isNew status
	 *
	 * @param bool $status
	 *
	 * @return $this
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @since 2.0
	 */
	public function setIsNew($status);

	/**
	 * Gets the Provider for this model
	 *
	 * @return ProviderInterface
	 */
	public function getProvider();

	/**
	 * Returns true if this model is new
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	public function isNew();

	/**
	 * Gets the original data assigned to this model
	 *
	 * @return DataContainer
	 *
	 * @since 2.0
	 */
	public function getOriginalData();
}
