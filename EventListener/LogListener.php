<?php

namespace Zuni\LogBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use LogicException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Zuni\LogBundle\Annotation\NotLoggable;
use Zuni\LogBundle\Factory\AbstractLogFactory;
use Zuni\LogBundle\Factory\LogFactoryCreate;
use Zuni\LogBundle\Factory\LogFactoryDelete;
use Zuni\LogBundle\Factory\LogFactoryUpdate;
use Zuni\LogBundle\Utils\StateGenerator;

/**
 * Listener para persistir log 
 */
class LogListener
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Guarda o change set da entidade 
     * utiliza o spl_hash.
     * 
     * @var array
     */
    private static $changeSetMap;
    
    /**
     * Guarda o state generator da entidade antes de deletar 
     * utiliza o spl_hash.
     * 
     * @var array
     */
    private static $preRemoveEntity;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Persist o log
     * 
     * @param EntityManager $em
     * @param AbstractLogFactory $logFactory
     */
    private function index(EntityManager $em, AbstractLogFactory $logFactory)
    {
        if ($this->isLoggable($em->getClassMetadata($logFactory->getEntityName()))) {
            $this->container->get("doctrine.orm.log_entity_manager")->persist($logFactory->getLog());
            $this->container->get("doctrine.orm.log_entity_manager")->flush();
        }
    }

    /**
     * Pre persist método
     * 
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args->getEntityManager(), new LogFactoryCreate($args->getEntity(), new StateGenerator($args->getEntityManager()) ,$this->getUser()));
    }

    /**
     * Pre update, para pegar o change set
     * e persistir em um atributo da instancia
     * 
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->persistChangeSet($args->getEntity(), $args->getEntityChangeSet());
    }

    /**
     * Post update
     * 
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args->getEntityManager(), new LogFactoryUpdate($args->getEntity(), new StateGenerator($args->getEntityManager()), $this->getChangeSet($args->getEntity()), $this->getUser()));
    }

    /**
     * Persiste o state generate antes de deletar para 
     * não perder o identificador da entidade
     * 
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->persistPreRemoveENity($args->getEntity());
    }
    
    /**
     * Post remove
     * 
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->index($args->getEntityManager(), new LogFactoryDelete($this->getPreRemoveEntity($args->getEntity()), new StateGenerator($args->getEntityManager()), $this->getUser()));
    }

    /**
     * Verifica se a classe é logavel
     * 
     * @param object $entity Entidade
     * @param ClassMetadata $classMetadata
     * @return boolean
     */
    private function isLoggable(ClassMetadata $classMetadata)
    {
        $annotationReader = new AnnotationReader();

        /* @var $classAnnotation NotLoggable */
        $classAnnotation = $annotationReader->getClassAnnotation($classMetadata->getReflectionClass(), 'Zuni\\LogBundle\\Annotation\\NotLoggable');

        if (!$classAnnotation) {
            return true;
        }

        return $classAnnotation->loggable;
    }

    /**
     * Persist o change set em memoria 
     * para ser utilizado no post persist 
     * 
     * @param object $entity
     */
    private function persistChangeSet($entity, array $changeSet)
    {
        if (!self::$changeSetMap) {
            self::$changeSetMap = array();
        }
        
        self::$changeSetMap[\spl_object_hash($entity)] = $changeSet;
    }
    
    /**
     * Get change set da entidade 
     * 
     * @param object $entity
     * @return array 
     */
    private function getChangeSet($entity)
    {
        if (!self::$changeSetMap) {
            self::$changeSetMap = array();
        }
        
        if (!\array_key_exists(\spl_object_hash($entity), self::$changeSetMap)) {
            return array();
        }
        
        return self::$changeSetMap[\spl_object_hash($entity)];
    }
    
    /**
     * Persist o change set em memoria 
     * para ser utilizado no post persist 
     * 
     * @param object $entity
     */
    private function persistPreRemoveENity($entity)
    {
        if (!self::$preRemoveEntity) {
            self::$preRemoveEntity = array();
        }
        
        self::$preRemoveEntity[\spl_object_hash($entity)] = clone $entity;
    }
    
    /**
     * Get change set da entidade 
     * 
     * @param object $entity
     * @return array 
     */
    private function getPreRemoveEntity($entity)
    {
        if (!self::$preRemoveEntity) {
            self::$preRemoveEntity = array();
        }
        
        if (!\array_key_exists(\spl_object_hash($entity), self::$preRemoveEntity)) {
            return array();
        }
        
        return self::$preRemoveEntity[\spl_object_hash($entity)];
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    private function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

}
