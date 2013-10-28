<?php

namespace Zuni\LogBundle\Factory;

use Symfony\Component\Security\Core\User\UserInterface;
use Zuni\LogBundle\Entity\Log;
use Zuni\LogBundle\Enum\LogTypeEnum;
use Zuni\LogBundle\Utils\StateGeneratorInterface;

/**
 *
 * @author Fábio Lemos Elizandro
 */
class LogFactoryUpdate extends AbstractLogFactory
{

    /**
     * Alterações feitas na entidade 
     * primeira posição antigo valor 
     * segunda valor atual
     * 
     * @var array
     */
    private $changeSet;

    function __construct($entity, StateGeneratorInterface $stateGenerator, array $changeSet, UserInterface $user = null)
    {
        parent::__construct($entity, $stateGenerator, $user);
        $this->setChangeSet($changeSet);
    }

    /**
     * @return Log 
     */
    public function getLog()
    {
        $log = $this->initLog(new Log());
        $log->setType(LogTypeEnum::getInstance()->UPDATE);
        $log->setChanges($this->getChangeSet());

        return $log;
    }

    /**
     * Get change set
     * 
     * @return array
     */
    public function getChangeSet()
    {
        return $this->changeSet;
    }

    /**
     * Set change set
     * 
     * @param array $changeSet
     */
    private function setChangeSet(array $changeSet)
    {
        $this->changeSet = $this->getStateGenerator()->generateChangeSet($changeSet);
    }
    
}
