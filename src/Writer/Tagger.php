<?php

namespace Needham\ModelDoc\Writer;

use phpDocumentor\Reflection\DocBlock\Serializer;
use ReflectionClass;

/**
 * Class Tagger
 * @package Needham\ModelDoc\Writer
 */
class Tagger
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer();
    }

    public function tag($class) {

        // todo ...

    }
}
