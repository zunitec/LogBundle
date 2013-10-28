<?php

namespace Zuni\LogBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Gera o estado da entidade
 *
 * @author Fábio Lemos Elizandro
 */
abstract class AbstractStateGenerator implements StateGeneratorInterface
{

    /**
     *
     * @var EntityManager
     */
    private $em;
    
    /**
     * 
     * @param EntityManager $em
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
    
    /**
     * Retorna o acessador de propriedade
     * 
     * @return PropertyAccessorInterface
     */
    public function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }
    
    /**
     * Verifica se o objeto é uma entidade
     * 
     * @param object $object
     * @return boolean 
     */
    protected function isEntity($object)
    {
        return $this->getEntityManager()->getMetadataFactory()->hasMetadataFor(\get_class($object));
    }
    
}
