<?php
namespace Mail\Db;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MailEntityRepositoryFactory implements FactoryInterface
{
	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		return $container
			->get(EntityManager::class)
			->getRepository(MailEntity::class);
	}
}