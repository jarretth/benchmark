<?php
namespace Benchmark;

abstract class Benchmark {
    //our current unitcollection
    private static $index = null;
    //array of unitcollections
    private static $benchmarks = array();
    private static $config =
        array(
            'enabled' => true,
            'rusage'  => true,
            );

    public static function start($name) {
        if(!self::$config['enabled']) return;
        if(is_null(self::$index)) {
            if(!isset(self::$benchmarks[$name])) {
                self::$index = self::$benchmarks[$name] = new UnitCollection($this);
            } else {
                self::$index = self::$benchmarks[$name];
            }
            self::$index->start();
        }
    }

    public static function stop($name = null) {
        if(!self::$config['enabled']) return;
        if(!self::$index) return;
        self::$index->stop();

    }

    public static function bench($name, Closure $function, $times = 1) {
        if(!self::$config['enabled']) {
            $function();
            return;
        }
        while($times--) {
            self::start($name);
            try {
                $function();
            } catch(Exception $e) {
                self::stop($name);
                throw $e;
            }
            self::stop($name);
        }
    }

    public static function configure($config = array()) {
        if(!self::$config['enabled']) return; //can't reactivate it - spares me from a lot of checks
        self::$config = array_merge(self::$config,$config);
    }
}
