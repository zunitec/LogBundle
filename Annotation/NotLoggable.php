<?php

namespace Zuni\ZuniwebBundle\Annotation;

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