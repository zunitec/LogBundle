<?php

namespace Zuni\LogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zuni\EnumBundle\Annotation as Enum;
use Zuni\LogBundle\Annotation as Loggable;
use Zuni\LogBundle\Enum\LogType;
use Zuni\LogBundle\Utils\LogInterface;

/**
 * 
 * @Loggable\NotLoggable
 * @ORM\Entity
 * @ORM\Table(name="log")
 * @Enum\HasEnum
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var array
     * 
     * @ORM\Column(name="user_state", type="array", nullable=true)
     */
    private $userState;

    /**
     * @var date 
     * 
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="time", type="time")
     */
    private $time;

    /**
     * @var integer 
     * 
     * @ORM\Column(name="entity_id", type="integer")
     */
    private $entityId;

    /**
     * @var array
     * 
     * @ORM\Column(name="entity_state", type="array")
     */
    private $entityState;

    /**
     * @var string 
     * 
     * @ORM\Column(name="entity_class", type="string")
     */
    private $entityClass;

    /**
     * @var array
     * 
     * @ORM\Column(name="changes", type="array", nullable=true)
     */
    private $changes;

    /**
     * @var LogType
     * 
     * @Enum\Enum(enumList="\Zuni\LogBundle\Enum\LogTypeEnum")
     * @ORM\Column(name="log_type", type="enum", length=1)
     */
    private $type;

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
     * Set userState
     *
     * @param array $userState
     * @return Log
     */
    public function setUserState($userState)
    {
        $this->userState = $userState;

        return $this;
    }

    /**
     * Get userState
     *
     * @return array 
     */
    public function getUserState()
    {
        return $this->userState;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
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
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Log
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
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
     * Set entityState
     *
     * @param array $entityState
     * @return Log
     */
    public function setEntityState($entityState)
    {
        $this->entityState = $entityState;

        return $this;
    }

    /**
     * Get entityState
     *
     * @return array 
     */
    public function getEntityState()
    {
        return $this->entityState;
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
    public function setChanges(array $changes)
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
     * @param enum $type
     * @return Log
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return enum 
     */
    public function getType()
    {
        return $this->type;
    }

}
