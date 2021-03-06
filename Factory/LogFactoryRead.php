<?php

namespace Zuni\LogBundle\Factory;

use Zuni\LogBundle\Entity\Log;
use Zuni\LogBundle\Enum\LogTypeEnum;

/**
 * @author Fábio Lemos Elizandro
 */
class LogFactoryRead extends AbstractLogFactory
{
    /**
     * @return Log 
     */
    public function getLog()
    {
        $log = $this->initLog(new Log());
        $log->setType(LogTypeEnum::getInstance()->READ);
        
        return $log;
    }
}
