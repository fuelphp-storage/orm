<?php
/**
 * @package   Fuel\Orm
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2015 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Orm\Relation;

use Fuel\Orm\ModelCollectionInterface;
use Fuel\Orm\ModelInterface;

class HasMany extends AbstractRelation
{

	public function __construct($config = [])
	{
		$this->setKeyFrom($config['keyFrom']);
		$this->setKeyTo($config['keyTo']);
		$this->setProviderFrom($config['providerFrom']);
		$this->setProviderTo($config['providerTo']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getModels(ModelInterface $modelFrom)
	{
		$provider = $modelFrom->getProvider()
			->getFactory()
			->get($this->getProviderTo());

		$result = $provider
			->getQuery()
			->select()
			->where($this->getKeyTo(), $modelFrom->{$this->getKeyFrom()})
			->execute();

		// If the result is not a model collection then make sure one is returned for consistency
		if ( ! $result instanceof ModelCollectionInterface)
		{
			$result = $provider->forgeModelCollectionInstance([$result]);
		}

		return $result;
	}

}
