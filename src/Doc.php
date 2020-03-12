<?php

namespace Needham\ModelDoc;

/**
 * Class Doc
 * @package Needham\ModelDoc
 */
class Doc
{
    /**
     * @var Namespaced
     */
    protected $namespaced;

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
     * @param array $attributes
     * @throws \ReflectionException
     */
    public function __construct(string $name, array $attributes = [])
    {
        $this->source = $name;
        $this->namespaced = Namespaced::create($name);
        $this->attributes = $attributes;
    }

    public function getSource() : string  {
        $this->source;
    }

    public function getClassName() : string {
        return $this->namespaced->getClass();
    }

    public function getNamespace() : string {
        return $this->namespaced->getNamespaceString();
    }

    public function getNamespaced() : Namespaced {
        return $this->namespaced;
    }

    public function getAttributes() : array {
        return $this->attributes;
    }
}
