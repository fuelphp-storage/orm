<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2015 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm;

/**
 * Handles the creation of Providers and allows them to be referenced by name.
 */
class ProviderFactory
{

	/**
	 * Contains provider configs for later construction
	 *
	 * @var array
	 */
	protected $providerConfigs = [];

	/**
	 * @var Provider[]
	 */
	protected $providers = [];

	/**
	 * Adds a new provider definition.
	 *
	 * @param string $name
	 * @param array  $properties
	 * @param string $tableName
	 * @param array  $relations
	 *
	 * @since 2.0
	 */
	public function add($name, $properties, $tableName = null, $relations = [])
	{
		$this->providerConfigs[$name] = [
			'name' => $name,
			'properties' => $properties,
			'tableName' => $tableName,
			'relations' => $relations,
		];
	}

	// TODO: Add constructed provider

	/**
	 * Returns true if the given provider is known.
	 *
	 * @param string $name
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	public function has($name)
	{
		return isset($this->providerConfigs[$name]);
	}

	/**
	 * Gets a constructed provider.
	 *
	 * @param string $name
	 *
	 * @return Provider
	 *
	 * @since 2.0
	 */
	public function get($name)
	{
		// Return the provider if it has already been constructed
		if (isset($this->providers[$name]))
		{
			return $this->providers[$name];
		}

		$config = $this->providerConfigs[$name];
		$provider = new Provider;
		$provider->setProperties($config['properties']);
		$provider->setTableName($config['tableName']);

		$this->providers[$name] = $provider;
		return $provider;
	}

	/**
	 * Removes a provider.
	 *
	 * @param string $name
	 *
	 * @since 2.0
	 */
	public function remove($name)
	{
		unset($this->providerConfigs[$name]);
		unset($this->providers[$name]);
	}

}
