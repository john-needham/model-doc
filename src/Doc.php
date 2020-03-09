<?php

namespace Needham\ModelDoc;

/**
 * Class Doc
 * @package Needham\ModelDoc
 */
class Doc
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var string
     */
    private $source;

    /**
     * Doc constructor.
     * @param string $name
     * @param string $namespace
     * @param array $attributes
     */
    public function __construct(string $name, array $attributes = [])
    {
        $this->source = $name;
        $namespace = null;
        try {
            $class = (new \ReflectionClass($name));
            $name = $class->getShortName();
            $namespace = $class->getNamespaceName();
        } catch (\ReflectionException $e) {
            // ..
        }

        $this->name = $name;
        $this->namespace = $namespace;
        $this->attributes = $attributes;
    }

    public function getSource() : string  {
        $this->name;
    }

    public function getClassName() : string {
        return $this->name;
    }

    public function getNamespace() : string {
        return $this->namespace;
    }

    public function getAttributes() : array {
        return $this->attributes;
    }
}
