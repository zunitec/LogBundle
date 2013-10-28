<?php

namespace Zuni\LogBundle\Factory;

use Zuni\LogBundle\Entity\Log;
use Zuni\LogBundle\Enum\LogTypeEnum;
use Zuni\LogBundle\Factory\AbstractLogFactory;

/**
 *
 * @author Fábio Lemos Elizandro
 */
class LogFactoryDelete extends AbstractLogFactory
{
    /**
     * @return Log 
     */
    public function getLog()
    {
        $log = $this->initLog(new Log());
        $log->setType(LogTypeEnum::getInstance()->DELETE);
        
        return $log;
    }

}
