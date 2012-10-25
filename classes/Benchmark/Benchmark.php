<?php
namespace Benchmark;

abstract class Benchmark {
    private static $index = array();
    private static $benchmarks = array();
    private static $config =
        array(
            'enabled' => true,
            'rusage'  => true,
            );

    public static function start($name) {
        if(!$config['enabled']) return;

    }

    public static function stop($name = null) {
        if(!$config['enabled']) return;

    }

    public static function configure($config = array()) {
        self::$config = array_merge(self::$config,$config);
    }
}
