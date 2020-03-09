<?php

namespace Needham\ModelDoc\Database;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Needham\ModelDoc\Attribute;


class Inspector
{
    const SQL_TABLE_NAME = 'TABLE_NAME';
    const SQL_COL_NAME = 'COLUMN_NAME';
    const SQL_COL_TYPE = 'DATA_TYPE';

    public function inspect($class) : array {

        $attributes = [];

        if(class_exists($class)) {
            $instance = new $class;
        } else {
            dd($class);
        }

        $table = $instance->getTable();
        $columns = DB::table('INFORMATION_SCHEMA.COLUMNS')
            ->select(DB::raw('*'))
            ->where('TABLE_NAME', $table)
            ->get()->toArray();

        foreach ($columns as $column) {
            $attributes[] = new Attribute(
                data_get($column, self::SQL_COL_NAME),
                // data_get($column, self::SQL_COL_TYPE)
                'mixed'
            );
        }

        return $attributes;
    }
}
