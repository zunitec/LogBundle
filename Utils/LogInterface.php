<?php
namespace Zuni\LogBundle\Utils;

/**
 *
 * Interface de log 
 * 
 * @author Fábio Lemos Elizandro
 */
interface LogInterface
{
    
    /**
     * Get id
     */
    public function getId();
    
    /**
     * Set Id do usuário
     */
    public function setUserId($userId);
    
    /**
     * Get id do usário
     */
    public function getUserId();
    
    /**
     * Set o estado do usuário
     */
    public function setUserState($userState);
    
    /**
     * Get estado do usuário
     */
    public function getUserState();
    
    /**
     * Set data que o log foi gravado 
     */
    public function setDate($date);

    /**
     * Get data do log
     * 
     * @return \DateTime 
     */
    public function getDate();
    
    /**
     * Set hora do log
     */
    public function setTime($time);
    
    /**
     * Get hora do log
     * 
     * @return \DateTime 
     */
    public function getTime();
    
    /**
     * Set id da entidade 
     */
    public function setEntityId($entityId);
    
    /**
     * Get id da entidade logada 
     */
    public function getEntityId();
    
    /**
     * Set o estado em que a entidade se encontra 
     */
    public function setEntityState($entityState);
    
    /**
     * Get estado que a entidade se encontra
     */
    public function getEntityState();
    
    /**
     * Set classe da entidade
     */
    public function setEntityClass($entityClass);
    
    /**
     * Get classe da entidade
     */
    public function getEntityClass();
    
    /**
     * Set mudançar na entidade
     */
    public function setChanges(array $changes);
    
    /**
     * Get mudanças na entidade
     */
    public function getChanges();
    
    /**
     * Set tipo de log
     */
    public function setType($type);
    
    /**
     * Get tipo de log 
     */
    public function getType();
}
