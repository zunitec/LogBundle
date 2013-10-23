<?php

namespace Zuni\LogBundle\Factory;

use Zuni\LogBundle\Utils\LogInterface;

/**
 * Fabrica de log 
 *
 * @author Fábio Lemos Elizandro
 */
abstract class AbstractLogFactory
{
    /**
     * Get log
     * 
     * @return LogInterface 
     */
    abstract public function getLog();
}
