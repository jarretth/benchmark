<?php

namespace Fuel\Util;

abstract class Benchmark {
    private static $index = array();
    private static $benchmarks = array();

    public static function start($name) {
        array_push(self::$index, $name);
        // $benchmarks[$name]
    }

    public static function stop($name = null) {
        if($name !== null) {
            // array_pop()
        }
    }


}
