<?php

namespace Needham\ModelDoc\Models;

use Illuminate\Database\Eloquent\Model;
use Needham\ModelDoc\Namespaced;
use phpDocumentor\Reflection\DocBlock\Serializer;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;

/**
 * Class Discovery
 * @package Needham\ModelDoc\Models
 */
class Discovery
{
    const STUB_NAMESPACE = 'Stubs';

    private static $composer;
    /**
     * @var array
     */
    private static $classes;
    /**
     * @var DocBlockFactory
     */
    private $doc;

    public function __construct()
    {
        $this->doc  = DocBlockFactory::createInstance();
    }

    /**
     * get all models
     */
    public function fetchModels() : array
    {
        return $this->fetch(function($class) {
            return is_subclass_of($class , Model::class);
        });
    }

    /**
     * @return array
     */
    public function fetchHasStubDoc() : array
    {
        return $this->fetch(function($class) {

            $reflector = new ReflectionClass($class);
            if($reflector->getDocComment()) {
                $docblock = $this->doc->create($reflector);
                $tags = $docblock->getTagsByName('mixin');
                if(count($tags)) {
                    $tags = array_filter($tags, function (Tag $tag) use ($class) {
                        $ns = Namespaced::fromString($class)->withAppendedNamespace(self::STUB_NAMESPACE);
                        $testGlobal = sprintf('@mixin %s', $ns->withGlobal());
                        return strcmp($tag->render(), $testGlobal) === 0;
                    });
                    return count($tags);
                }
            }
        });
    }

    protected function fetch(callable $test) : array {

        $models = [];

        self::$composer = require app_path() . '/../vendor/autoload.php';
        self::$classes  = array_keys(self::$composer->getClassMap());

        $paths = config('model-doc.namespaces.models', []);

        foreach (self::$classes as $class) {
            foreach ($paths as $path) {
                if(stripos($class, $path) === 0) {
                    /**
                     * What we're looking for
                     */
                    if ($test($class)) {
                        $models[] = $class;
                    }
                }
            }
        }

        return $models;
    }
}
