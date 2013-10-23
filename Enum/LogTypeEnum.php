<?php

namespace Zuni\LogBundle\Enum;

use Zuni\EnumBundle\Model\AbstractEnumList;
use Zuni\EnumBundle\Model\AbstractEnumObject;

class LogTypeEnum extends AbstractEnumList
{

    private static $instance;

    /**
     * @var LogType
     */
    public $CREATE;

    /**
     * @var LogType
     */
    public $READ;

    /**
     * @var LogType
     */
    public $UPDATE;

    /**
     * @var LogType
     */
    public $DELETE;

    public function __construct()
    {
        $this->CREATE = new LogType("C", "INSERT");
        $this->READ   = new LogType("R", "READ");
        $this->UPDATE = new LogType("U", "UPDATE");
        $this->DELETE = new LogType("D", "DELETE");
    }

    /**
     * @return LogTypeEnum
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new LogTypeEnum();
        }

        return self::$instance;
    }

}

class LogType extends AbstractEnumObject
{
    
}
