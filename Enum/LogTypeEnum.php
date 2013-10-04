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
    public $INSERT;
    
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
        $this->INSERT = new LogType("I", "INSERT");
        $this->UPDATE = new LogType("U", "UPDATE");
        $this->DELETE = new LogType("D", "DELETE");
    }
    
    /**
     * @return LogTypeEnum
     */
    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new LogTypeEnum();
        }
        
        return self::$instance;
    }
}


class LogType extends AbstractEnumObject{}

