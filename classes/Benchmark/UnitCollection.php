<?php
namespace Benchmark;

class UnitCollection {
    public $parent = null;
    private $units = array();
    private $index = null;
    private $n = null;

    public function __construct($parent) {
        $this->parent = $parent;
    }

    public function start($name) {
        if(!is_null($this->index) && !$this->index->isDone()) {
            $this->index->start($name);
            return;
        }
        $this->index = $this->units[] = new Unit($this);
    }

    public function stop($name = null) {
        if(is_null($this->index)) throw new Exception("Stopped without starting");
        if()
    }

}
