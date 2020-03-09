<?php

namespace Needham\ModelDoc;

/**
 * Class Attribute
 * @package Needham\ModelDoc
 */
class Attribute
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $type;

    /**
     * Attribute constructor.
     * @param string $name
     * @param string $type
     */
    public function __construct(
        string $name,
        string $type
    )
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
