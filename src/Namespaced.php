<?php


namespace Needham\ModelDoc;


use ReflectionClass;

class Namespaced
{
    /**
     * @var array
     */
    private $namespace;
    /**
     * @var string
     */
    private $class;

    /**
     * Namespaced constructor.
     * @param string $class
     * @param array $namespace
     */
    protected function __construct(string $class, array $namespace = [])
    {
        $this->namespace = $namespace;
        $this->class = $class;
    }

    /**
     * @return array
     */
    public function getNamespace(): array
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getNamespaceString(): string
    {
        return self::implode($this->namespace);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return static
     */
    public static function fromString(string $class) : self {
        $array = self::explode($class);
        $class = array_pop($array);
        return new self($class, $array);
    }

    /**
     * @param $class
     * @return static
     * @throws \ReflectionException
     */
    public static function create($class) : self {
        if(is_object($class)) {
            return self::fromInstance($class);
        }
        if(is_string($class)) {
            return self::fromString($class);
        }
        if(is_array($class)) {
            return self::fromArray($class);
        }
        throw new \Exception("Unknown class type");
    }

    /**
     * @param array $ns
     * @return static
     */
    public static function fromArray(array $ns) : self {
        $class = array_pop($ns);
        return new self($class, $ns);
    }

    /**
     * @param $obj
     * @return Namespaced
     * @throws \ReflectionException
     */
    public static function fromInstance($obj) {
        $class = new ReflectionClass($obj);
        $name = $class->getShortName();
        $namespace = '\\'.$class->getNamespaceName();
        return new self($name, self::explode($namespace));
    }

    /**
     * @param string $ns
     * @return array
     */
    protected static function explode(string $ns) : array {
        return array_filter(explode('\\', $ns));
    }

    /**
     * @param array $ns
     * @return string
     */
    protected static function implode(array $ns) : string {
        return implode( '\\', array_filter($ns));
    }

    public function withAppendedNamespace(string $ns) {
        $model = new self($this->getClass(), $this->getNamespace());
        array_unshift($model->namespace, $ns);
        return $model;
    }

    /**
     * @return string
     */
    public function withGlobal() {
        return '\\' . (string) $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $ns = $this->namespace;
        $ns[] = $this->class;
        return self::implode($ns);
    }
}
