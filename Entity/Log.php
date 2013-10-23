<?php

namespace Zuni\LogBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zuni\EnumBundle\Annotation;
use Zuni\LogBundle\Enum\LogType;
use Zuni\LogBundle\Utils\LogInterface;

/**
 * Log
 * 
 * @ORM\Entity
 * @ORM\Table(name=log)
 * @Annotation\HasEnum
 */
class Log implements LogInterface
{
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * 
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var date 
     * 
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer 
     * 
     * @ORM\Column(name="entity_id", type="integer")
     */
    private $entityId;

    /**
     * @var string 
     * 
     * @ORM\Column(name="entity_class", type="string")
     */
    private $entityClass;

    /**
     * @var array
     * 
     * @ORM\Column(name="changes", type="array")
     */
    private $changes;

    /**
     * @var LogType
     * 
     * @Annotation\Enum(enumList="\Zuni\LogBundle\Enum\LogTypeEnum")
     * @ORM\Column(name="log_type", type="enum", length=1)
     */
    private $type;

    public function __construct()
    {
        $this->changes = array();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Log
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set date
     *
     * @param DateTime $date
     * @return Log
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set entityId
     *
     * @param integer $entityId
     * @return Log
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer 
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set entityClass
     *
     * @param string $entityClass
     * @return Log
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get entityClass
     *
     * @return string 
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Set changes
     *
     * @param array $changes
     * @return Log
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;

        return $this;
    }

    /**
     * Get changes
     *
     * @return array 
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * Set type
     *
     * @param LogType $type
     * @return Log
     */
    public function setType(LogType $type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return LogType
     */
    public function getType()
    {
        return $this->type;
    }
}