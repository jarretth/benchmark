<?php
use Benchmark\Benchmark;

class BenchmarkTest extends PHPUnit_Framework_TestCase {
    public function testStart() {
        Benchmark::start('a');
        $this->assertEquals(1,1);
    }
}
