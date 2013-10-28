<?php

namespace Zuni\LogBundle\Utils;

/**
 *
 * @author Fábio Lemos Elizandro
 */
interface StateGeneratorInterface
{
    /**
     * Gera o estado da entidade
     */
    public function generate($entity);
    
    /**
     * Gera o estado do change set
     */
    public function generateChangeSet(array $changeSet);
    
}
