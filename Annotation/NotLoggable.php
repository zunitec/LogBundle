<?php

namespace Zuni\LogBundle\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class NotLoggable
{

    /**
     *
     * @var boolean
     */
    public $loggable = false;

}