<?php

namespace Needham\ModelDoc\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Discovery
 * @package Needham\ModelDoc\Models
 */
class Discovery
{
    private static $composer;
    /**
     * @var array
     */
    private static $classes;

    /**
     * get all models
     */
    public function fetch() : array {

        $models = [];

        $paths = config('model-doc.paths.models', []);

        self::$composer = require app_path() . '/../vendor/autoload.php';

        self::$classes  = array_keys(self::$composer->getClassMap());

        foreach (self::$classes as $class) {
            foreach($paths as $path) {
                if(stripos($class, $path) === 0) {
                    if (is_subclass_of($class , Model::class)) {
                        $models[] = $class;
                    }
                }
            }
        }

        return $models;
    }
}
