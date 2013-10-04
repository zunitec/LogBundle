<?php

namespace Zuni\LogBundle\EventListener;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zuni\LogBundle\Entity\Log;
use Zuni\LogBundle\Enum\LogType;
use Zuni\LogBundle\Enum\LogTypeEnum;

class LogListener
{

    protected $container;
    private $needsFlush = false;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        if (!$args->getEntity() instanceof Log) {
            $this->createLog($args, LogTypeEnum::getInstance()->INSERT);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $changes = array();

        foreach ($args->getEntityChangeSet() as $key => $change) {
            foreach ($change as $i => $changed) {
                if ($changed instanceof DateTime) {
                    $change[$i] = $changed->format('d/m/Y H:i:s');
                } elseif (gettype($changed) == 'object') {
                    $className = get_class($changed);
                    //explode o nome da classe para remover o proxy (Proxies\__CG__\)
                    $classNameExploded = explode('_\\', $className);
                    $change[$i] = array(
                        'id' => $changed->getId(),
                        'className' => isset($classNameExploded[1]) ? $classNameExploded[1] : $className
                    );
                }
            }
            $changes[$key] = $change;
        }
        
        $this->createLog($args, LogTypeEnum::getInstance()->UPDATE, $changes);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $this->createLog($args, LogTypeEnum::getInstance()->DELETE);
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if ($this->needsFlush) {
            $this->needsFlush = false;
            $args->getEntityManager()->flush();
        }
    }

    public function createLog(LifecycleEventArgs $args, LogType $type, $changes = array())
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $entityClass = get_class($entity);
        $user = $this->container->get('security.context')->getToken()->getUser();
        $date = new DateTime('now');

        $log = new Log();
        $log->setEntityClass($entityClass)
                ->setEntityId($entity->getId())
                ->setDate($date)
                ->setUserId($user->getId())
                ->setType($type)
                ->setChanges($changes);

        $em->persist($log);
        $this->needsFlush = true;
    }

}