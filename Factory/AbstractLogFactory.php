<?php

namespace Zuni\LogBundle\Factory;

use Symfony\Component\Security\Core\User\UserInterface;
use Zuni\LogBundle\Utils\LogInterface;
use Zuni\LogBundle\Utils\StateGeneratorInterface;

/**
 * Fabrica de log 
 *
 * @todo Alterar type de usuário para uma interface personalizada pel "id"
 * @author Fábio Lemos Elizandro
 */
abstract class AbstractLogFactory
{
    /**
     *
     * Entidade que vai ser logada
     * 
     * @var object
     */
    private $entity;
    
    /**
     *
     * @var UserInterface
     */
    private $user;
    
    /**
     *
     * @var StateGeneratorInterface
     */
    private $stateGenerator;
    
    function __construct($entity, StateGeneratorInterface $stateGenerator , UserInterface $user = null)
    {
        $this->entity = $entity;
        $this->user = $user;
        $this->stateGenerator = $stateGenerator;
    }
    
    /**
     * Get state generator
     * 
     * @return StateGeneratorInterface
     */
    public function getStateGenerator()
    {
        return $this->stateGenerator;
    }

    /**
     * Get entity
     * 
     * @return object 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Get User
     * 
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
        
    /**
     * Busca o nome completo da entidade
     * 
     * @return string 
     */
    public function getEntityName()
    {
        return \get_class($this->getEntity());
    }
    
    /**
     * Gera um log com informações que são compartilhadas 
     * entre as fabricas
     */
    protected function initLog(LogInterface $log)
    {
        $log->setDate(new \DateTime("now"));
        $log->setTime(new \DateTime("now"));
        
        if ($this->getUser()) {
            $log->setUserId($this->getUser()->getId());
            $log->setUserState($this->getStateGenerator()->generate($this->getUser()));
        }
        
        $log->setEntityClass($this->getEntityName());
        $log->setEntityId($this->getEntity()->getId());
        $log->setEntityState($this->getStateGenerator()->generate($this->getEntity()));
        
        return $log;
    }
    
    /**
     * Get log
     * 
     * @return LogInterface 
     */
    abstract public function getLog();
}
