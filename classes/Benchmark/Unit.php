<?php
namespace Benchmark;

class Unit {
    private $start   = null;
    private $end     = null;
    private $times   = null;
    private $rusage  = false;


    private $ucs = null;
    public $parent = null;

    public function __construct($parent, $rusage = false) {
        $this->parent = $parent;
        if($this->rusage = $rusage) {
            $rusage = getrusage();
            $this->start =
                array(
                    'utime_s'  => $rusage['ru_utime.tv_sec'],
                    'utime_us' => $rusage['ru_utime.tv_usec'],
                    'stime_s'  => $rusage['ru_stime.tv_sec'],
                    'stime_us' => $rusage['ru_stime.tv_usec'],
                    'real'     => microtime(true)
                );
        } else {
            $this->start = array('real' => microtime(true));
        }
    }

    public function stop() {
        $stop = array('real' => microtime(true));
        if($this->rusage) {
            $rusage = getrusage();
            $stop['utime_s']  = $rusage['ru_utime.tv_sec'];
            $stop['utime_us'] = $rusage['ru_utime.tv_usec'];
            $stop['stime_s']  = $rusage['ru_stime.tv_sec'];
            $stop['stime_us'] = $rusage['ru_stime.tv_usec'];
        }
        if(!is_null($this->stop) || !is_null($this->times)) return;
        $this->stop = $stop;
    }

    public function time() {
        if(is_null($this->stop) && !is_null($this->times)) throw new Exception("Tried to calculate times without stopping the unit");
        if(is_null($this->times)) {
            $this->times = array('real' => ($this->stop['real'] - $this->start['real']));
            if($this->rusage) {
                $this->times['user']   = ($this->stop['utime_s']  + ($this->stop['utime_us']/1e6)) -
                                         ($this->start['utime_s'] + ($this->start['utime_us']/1e6));
                $this->times['system'] = ($this->stop['stime_s'] + ($this->stop['stime_us']/1e6)) -
                                         ($this->start['stime_s'] + ($this->start['stime_us']/1e6));
            }
            $this->start = null;
            $this->stop  = null;
        }
        return $this->times;
    }

    public function isDone() {
        return is_null($this->times) || is_null($this->stop);
    }
}
