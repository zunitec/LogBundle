<?php

namespace Zuni\LogBundle\Utils;

use ReflectionProperty;

/**
 * Gera o estado da entidade
 *
 * @author Fábio Lemos Elizandro
 */
class StateGenerator extends AbstractStateGenerator
{

    /**
     * Gera o etado da entidade
     * 
     * @param object $entity
     * @return array state
     */
    public function generate($entity)
    {
        $state = array();
        
        $classMetadata = $this->getEntityManager()->getClassMetadata(\get_class($entity));
        
        /* @var $properties ReflectionProperty */
        $properties = $classMetadata->getReflectionProperties();
        
        foreach ($properties as $propertie) {
            $propertie->setAccessible(true);
            $propertieValue = $propertie->getValue($entity);
            
            $state[$propertie->getName()] = $this->filterValue($propertieValue);
        }
        
        return $state;
        
    }
    
    /**
     * Gera o estado para um chage set do doctrine 
     * 
     * @param array $changeSet
     * @return array
     */
    public function generateChangeSet(array $changeSet)
    {
        $state = array();
    
        foreach ($changeSet as $key => $chenge) {
            $state[$key][0] = $this->filterValue($chenge[0]);
            $state[$key][1] = $this->filterValue($chenge[1]);
        }
        
        return $state;
    }
    
    /**
     * Manipula o valor caso precise
     * se for uma entidade pegará o id da mesma 
     * se não for mais for um complex type irá serializar o mesmo
     * 
     * @param mixed $value
     */
    private function filterValue($value)
    {
        if (\is_object($value)) {
            $value = $this->filterObjectType($value);
        }
        
        return $value;
    }
    
    /**
     * Filtra o objeto para filtrar os valores invalidos 
     * 
     * @param object $value
     */
    private function filterObjectType($value)
    {
        if($this->isProxie($value)){
            $value = array("id" => $value->getId(), "entity" => \get_parent_class($value));
        }elseif ($this->isEntity($value)) {
            $value = array("id" => $value->getId(), "entity" => \get_class($value));
        }elseif($value instanceof \Doctrine\ORM\PersistentCollection){
            /* @var $value \Doctrine\ORM\PersistentCollection */
            $newValue = array();
            foreach ($value as $objectCollection) {
                $newValue[] = $this->filterObjectType($objectCollection);
            }
            $value = $newValue;
        }  elseif ($value instanceof \Zuni\EnumBundle\Model\AbstractEnumObject) {
            $value = $value->getId();
        }


        return $value;
    }

    private function isProxie($value)
    {
        return substr(\get_class($value), 0, 8) == "Proxies\\";
    }

}
